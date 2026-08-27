<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PassportOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PassportOrderController extends Controller
{
    // Status constants
    const STATUS_PENDING = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_CANCELLED = 3;

    /**
     * Display a listing of passport orders
     */
    public function index()
    {
        $orders = PassportOrder::with('user')->latest()->get();
        return view('admin.Passport_order.index', compact('orders'));
    }

    /**
     * Get orders list with search and filter (AJAX)
     */
    public function getOrders(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $formType = $request->input('form_type');
        $page = $request->input('page', 1);
        $perPage = 15;

        // Build query
        $query = PassportOrder::query();

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('user_id', 'like', "%{$search}%")
                  ->orWhere('form_type', 'like', "%{$search}%")
                  ->orWhere('form_type_name', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        // Form type filter
        if ($formType) {
            $query->where('form_type', $formType);
        }

        // Get statistics
        $stats = [
            'total' => PassportOrder::count(),
            'pending' => PassportOrder::where('status', self::STATUS_PENDING)->count(),
            'processing' => PassportOrder::where('status', self::STATUS_PROCESSING)->count(),
            'completed' => PassportOrder::where('status', self::STATUS_COMPLETED)->count(),
        ];

        // Paginate results
        $paginated = $query->latest()->paginate($perPage, ['*'], 'page', $page);

        // Format orders
        $orders = $paginated->items();
        $formattedOrders = array_map(function ($order) {
            return [
                'id' => $order->id,
                'user_id' => $order->user_id,
                'form_type' => $order->form_type,
                'form_type_name' => $order->form_type_name,
                'form_data' => is_string($order->form_data) ? $order->form_data : json_encode($order->form_data),
                'status' => $order->status,
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
     * Get order details
     */
    public function details($id)
    {
        $order = PassportOrder::findOrFail($id);

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'user_id' => $order->user_id,
                'form_type' => $order->form_type,
                'form_type_name' => $order->form_type_name,
                'form_data' => is_string($order->form_data) ? $order->form_data : json_encode($order->form_data),
                'status' => $order->status,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ]
        ]);
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:0,1,2,3',
        ]);

        $order = PassportOrder::findOrFail($orderId);

        $newStatus = (int) $request->input('status');
        
        $order->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'status' => $newStatus
        ]);
    }

    public function approve($orderId)
    {
        $order = PassportOrder::with("user")->findOrFail($orderId);

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
            "message" => "Order approved successfully",
            "status" => self::STATUS_PROCESSING
        ]);
    }

    public function reject(Request $request, $orderId)
    {
        $order = PassportOrder::with("user")->findOrFail($orderId);
        
        $rejectionReason = $request->input("rejection_reason");

        $updateData = [
            "status" => self::STATUS_CANCELLED, 
            "reject_note" => $rejectionReason,
            "is_money_back" => 1
        ];

        $order->update($updateData);

        $user = $order->user;
        if ($order->is_money_back) {
            $user->increment("balance", $order->cost);
        }

        return response()->json([
            "success" => true,
            "message" => "Order rejected successfully",
            "status" => self::STATUS_CANCELLED,
            "rejection_reason" => $rejectionReason
        ]);
    }

    /**
     * Download PDF for order
     */
    public function downloadPDF($orderId)
    {
        try {
            $order = PassportOrder::findOrFail($orderId);

            // Check if order has a PDF path
            if (!$order->admin_note) {
                return response()->json([
                    'success' => false,
                    'message' => 'এই অর্ডারের জন্য কোন PDF নেই'
                ], 404);
            }

            // Build file path
            $filePath = public_path() . $order->admin_note;

            // Check if file exists
            if (!file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'ফাইল খুঁজে পাওয়া যায়নি'
                ], 404);
            }

            // Return file download
            return response()->download($filePath, 'order_' . $orderId . '.pdf');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'ডাউনলোড করতে সমস্যা হয়েছে: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload PDF for order
     */
    public function uploadPDF(Request $request, $orderId)
    {
        try {
            $request->validate([
                'pdf' => 'required|file|mimes:pdf|max:10240', // 10MB max
            ]);

            $order = PassportOrder::findOrFail($orderId);

            // Check if file exists
            if (!$request->hasFile('pdf')) {
                return response()->json([
                    'success' => false,
                    'message' => 'কোন ফাইল নির্বাচিত হয়নি'
                ], 400);
            }

            $file = $request->file('pdf');

            // Generate unique filename
            $fileName = 'order_' . $orderId . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Create directory if it doesn't exist
            $uploadDir = public_path('passport_pdfs');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Save file directly to public folder
            $filePath = $uploadDir . '/' . $fileName;
            $file->move($uploadDir, $fileName);

            // URL path to be stored in database
            $pdfUrl = '/passport_pdfs/' . $fileName;

            // Update order with PDF path in admin_note
            $updated = $order->update([
                'admin_note' => $pdfUrl
            ]);

            return response()->json([
                'success' => true,
                'message' => 'PDF সফলভাবে আপলোড হয়েছে',
                'pdf_url' => $pdfUrl,
                'file_path' => $filePath,
                'order_id' => $orderId,
                'admin_note' => $pdfUrl
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'ফাইল ভ্যালিডেশন ব্যর্থ: ' . implode(', ', $e->errors()['pdf'] ?? ['অজানা ত্রুটি'])
            ], 422);
        } catch (\Exception $e) {
            \Log::error('PDF Upload Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'PDF আপলোড করতে সমস্যা হয়েছে: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save note to order
     */
    public function saveNote(Request $request, $orderId)
    {
        try {
            $request->validate([
                'note' => 'nullable|string',
            ]);

            $order = PassportOrder::findOrFail($orderId);
            $order->update([
                'text' => $request->input('note', '')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'নোট সফলভাবে সংরক্ষণ হয়েছে'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'নোট সংরক্ষণে সমস্যা: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save rejection reason for order
     */
    public function saveRejectionReason(Request $request, $orderId)
    {
        try {
            $request->validate([
                'rejection_reason' => 'required|string',
            ]);

            $order = PassportOrder::findOrFail($orderId);
            $rejectionReason = $request->input('rejection_reason');

            // Save rejection reason to reject_note column
            $order->update([
                'reject_note' => $rejectionReason
            ]);

            return response()->json([
                'success' => true,
                'message' => 'বাতিল করার কারণ সফলভাবে সংরক্ষণ হয়েছে',
                'rejection_reason' => $rejectionReason
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'ভ্যালিডেশন ব্যর্থ: ' . implode(', ', $e->errors()['rejection_reason'] ?? ['অজানা ত্রুটি'])
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Rejection Reason Save Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'কারণ সংরক্ষণে সমস্যা: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete an order
     */
    public function destroy($id)
    {
        try {
            $order = PassportOrder::findOrFail($id);
            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export orders to CSV
     */
    public function export(Request $request)
    {
        $format = $request->input('format', 'csv');
        
        $orders = PassportOrder::latest()->get();

        if ($format === 'csv') {
            return $this->exportCsv($orders);
        }

        return response()->json(['error' => 'Invalid format'], 400);
    }

    /**
     * Export orders as CSV
     */
    private function exportCsv($orders)
    {
        $filename = 'passport-orders-' . date('Y-m-d-His') . '.csv';
        $handle = fopen('php://memory', 'r+');

        // CSV Header
        fputcsv($handle, [
            'ID',
            'User ID',
            'Form Type',
            'Form Type Name',
            'Status',
            'Created At',
            'Updated At'
        ]);

        // CSV Data
        foreach ($orders as $order) {
            fputcsv($handle, [
                $order->id,
                $order->user_id,
                $order->form_type,
                $order->form_type_name,
                $this->getStatusString($order->status),
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
        return match ((int) $status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
            default => 'Unknown'
        };
    }
}
