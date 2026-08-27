<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TinOrder;
use Illuminate\Http\Request;

class TinOrderController extends Controller
{
    // Status constants
    const STATUS_PENDING = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_REJECTED = 3;

    /**
     * Display a listing of TIN orders
     */
    public function index()
    {
        return view('admin.tin_order.index');
    }

    /**
     * Get orders list with search and filter (AJAX)
     */
    public function getOrders(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $type = $request->input('type');
        $page = $request->input('page', 1);
        $perPage = 15;

        // Build query
        $query = TinOrder::with('user');

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('user_id', 'like', "%{$search}%")
                  ->orWhere('form_data', 'like', "%{$search}%")
                  ->orWhere('form_type_name', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        // Type filter
        if ($type) {
            $query->where('type', $type);
        }

        // Get statistics
        $stats = [
            'total' => TinOrder::count(),
            'pending' => TinOrder::where('status', self::STATUS_PENDING)->count(),
            'processing' => TinOrder::where('status', self::STATUS_PROCESSING)->count(),
            'completed' => TinOrder::where('status', self::STATUS_COMPLETED)->count(),
        ];

        // Paginate results
        $paginated = $query->latest()->paginate($perPage, ['*'], 'page', $page);

        // Format orders
        $orders = $paginated->items();
        $formattedOrders = array_map(function ($order) {
            return [
                'id' => $order->id,
                'user_id' => $order->user_id,
                'user_name' => $order->user->name,
                'user_email' => $order->user->email,
                'user_phone' => $order->user->phone,
                'form_data' => $order->form_data,
                'type' => $order->type,
                'form_type_name' => $order->form_type_name ?? $this->getServiceName($order->type),
                'status' => $order->status,
                'admin_note' => $order->admin_note,
                'text' => $order->text,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ];
        }, $orders);

        $pagination = [
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'per_page' => $paginated->perPage(),
            'total' => $paginated->total(),
        ];

        return response()->json([
            'orders' => $formattedOrders,
            'stats' => $stats,
            'pagination' => $pagination
        ]);
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|integer|in:0,1,2,3',
            'reason' => 'nullable|string'
        ]);

        try {
            $order = TinOrder::findOrFail($orderId);

            $newStatus = $request->input('status');
            $reason = $request->input('reason');
            
            $updateData = ['status' => $newStatus];
            
            // If rejecting (status = 3), save the rejection reason in reject_note
            if ($newStatus == self::STATUS_REJECTED && $reason) {
                $updateData['reject_note'] = $reason;
            }

            $order->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'status' => $newStatus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Approve an order
     */
    public function approve(Request $request, $orderId)
    {
        try {
            $order = TinOrder::with("user")->findOrFail($orderId);

            $user = $order->user;
            if ($order->is_money_back) {
                if ($order->cost > $user->balance) {
                    return response()->json([
                        "success" => false,
                        "message" => "Insufficient balance",
                        "status" => $order->status
                    ]);
                }
                $user->balance = $user->balance - $order->cost;
                $user->save();
            }

            $order->update(["status" => self::STATUS_PROCESSING]);

            return response()->json([
                "success" => true,
                "message" => "Order approved successfully"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Error approving order: " . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject an order
     */
    public function reject(Request $request, $orderId)
    {
        try {
            $order = TinOrder::with("user")->findOrFail($orderId);

            $reason = $request->input("reason");
            
            $updateData = [
                "status" => self::STATUS_REJECTED,
                "reject_note" => $reason,
                "is_money_back" => 1
            ];

            $order->update($updateData);

            $user = $order->user;
            if ($order->is_money_back) {
                $user->increment("balance", $order->cost);
            }

            return response()->json([
                "success" => true,
                "message" => "Order rejected successfully"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error rejecting order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Complete an order
     */
    public function complete(Request $request, $orderId)
    {
        try {
            $order = TinOrder::findOrFail($orderId);
            $order->update(['status' => self::STATUS_COMPLETED]);

            return response()->json([
                'success' => true,
                'message' => 'Order completed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error completing order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export orders to CSV
     */
    public function export(Request $request)
    {
        $orders = TinOrder::latest()->get();
        return $this->exportCsv($orders);
    }

    /**
     * Upload PDF for an order
     */
    public function uploadPdf(Request $request, $orderId)
    {
        try {
            $request->validate([
                'pdf' => 'required|file|mimes:pdf|max:10240' // Max 10MB
            ]);

            $order = TinOrder::findOrFail($orderId);

            // Create directory if it doesn't exist
            $uploadPath = public_path('tin_orders');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Generate unique filename
            $fileName = 'tin_order_' . $orderId . '_' . time() . '.pdf';
            $filePath = 'tin_orders/' . $fileName;

            // Move uploaded file
            $request->file('pdf')->move($uploadPath, $fileName);

            // Delete old PDF if exists
            if ($order->admin_note && strpos($order->admin_note, '.pdf') !== false) {
                $oldFilePath = public_path($order->admin_note);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Save file path to admin_note column and set status to completed
            $order->admin_note = $filePath;
            $order->status = self::STATUS_COMPLETED; // Auto-complete the order
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'PDF uploaded successfully and order marked as completed',
                'file_path' => $filePath
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid file. Please upload a PDF file (max 10MB)'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download PDF for an order
     */
    public function downloadPdf($orderId)
    {
        try {
            $order = TinOrder::findOrFail($orderId);

            if (!$order->admin_note || strpos($order->admin_note, '.pdf') === false) {
                abort(404, 'PDF not found for this order');
            }

            $filePath = public_path($order->admin_note);

            if (!file_exists($filePath)) {
                abort(404, 'PDF file not found on server');
            }

            return response()->download($filePath);
        } catch (\Exception $e) {
            abort(404, 'PDF not found');
        }
    }

    /**
     * Save note for an order
     */
    public function saveNote(Request $request, $orderId)
    {
        try {
            $request->validate([
                'text' => 'nullable|string'
            ]);

            $order = TinOrder::findOrFail($orderId);
            $order->text = $request->input('text');
            $order->status = self::STATUS_COMPLETED; // Auto-complete the order
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'নোট সফলভাবে সেভ হয়েছে এবং অর্ডার সম্পন্ন করা হয়েছে!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving note: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export orders as CSV
     */
    private function exportCsv($orders)
    {
        $filename = 'tin-orders-' . date('Y-m-d-His') . '.csv';
        $handle = fopen('php://memory', 'r+');

        // CSV Header
        fputcsv($handle, [
            'ID',
            'User ID',
            'Service Type',
            'Form Data',
            'Status',
            'Admin Note',
            'Created At',
            'Updated At'
        ]);

        // CSV Data
        foreach ($orders as $order) {
            $formData = is_object($order->form_data) || is_array($order->form_data) 
                ? json_encode($order->form_data) 
                : $order->form_data;
            
            fputcsv($handle, [
                $order->id,
                $order->user_id,
                $order->form_type_name ?? $this->getServiceName($order->type),
                $formData,
                $this->getStatusString($order->status),
                $order->admin_note,
                $order->created_at,
                $order->updated_at
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }

    /**
     * Convert status code to string
     */
    private function getStatusString($status)
    {
        return match ($status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_REJECTED => 'Rejected',
            default => 'Unknown'
        };
    }

    /**
     * Get service name in Bengali
     */
    private function getServiceName($type)
    {
        return match ($type) {
            1 => 'টিন সার্টিফিকেট অর্ডার',
            2 => 'নিউ টিন আবেদন',
            3 => 'জিরো রিটার্ন আবেদন',
            4 => 'টিন সার্টিফিকেট কারেকশন',
            5 => 'টিন আইডি পাসওয়ার্ড সেট',
            default => 'Unknown'
        };
    }
}
