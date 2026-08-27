<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SimNetworkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SimNetworkOrderController extends Controller
{
    // Status constants
    const STATUS_PENDING = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_REJECTED = 3;

    /**
     * Display a listing of SIM network orders
     */
    public function index()
    {
        return view('admin.sim_network_order.index');
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
        $query = SimNetworkOrder::with('user')->whereHas('user');

        // Search filter - search in form_data JSON
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
            'total' => SimNetworkOrder::count(),
            'pending' => SimNetworkOrder::where('status', self::STATUS_PENDING)->count(),
            'processing' => SimNetworkOrder::where('status', self::STATUS_PROCESSING)->count(),
            'completed' => SimNetworkOrder::where('status', self::STATUS_COMPLETED)->count(),
        ];

        // Paginate results
        $paginated = $query->latest()->paginate($perPage, ['*'], 'page', $page);

        // Format orders
        $orders = $paginated->items();
        $formattedOrders = array_map(function ($order) {
            return [
                'id' => $order->id,
                'user_id' => $order->user_id,
                'name' => $order->user->name,
                'email' => $order->user->email,                                    
                'phone' => $order->user->phone,
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
            $order = SimNetworkOrder::findOrFail($orderId);

            $newStatus = $request->input('status');
            
            // Prepare update data
            $updateData = ['status' => $newStatus];

            // If rejecting, save the rejection reason to reject_note column
            if ($newStatus == self::STATUS_REJECTED) {
                $reason = $request->input('reason', 'কোনো কারণ প্রদান করা হয়নি');
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
     * Approve an order (set to processing)
     */
    public function approve(Request $request, $orderId)
    {
        try {
            $order = SimNetworkOrder::with("user")->findOrFail($orderId);

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
        $request->validate([
            'reason' => 'nullable|string'
        ]);

        try {
            $order = SimNetworkOrder::with("user")->findOrFail($orderId);
            
            $updateData = [
                "status" => self::STATUS_REJECTED,
                "reject_note" => $request->input("reason", "No reason provided"),
                "is_money_back" => 1
            ];

            $order->update($updateData);

            $user = $order->user;
            if ($order->is_money_back) {
                $user->increment("balance", $order->cost);
            }

            return response()->json([
                'success' => true,
                'message' => 'Order rejected successfully',
                'status' => self::STATUS_REJECTED
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
            $order = SimNetworkOrder::findOrFail($orderId);
            $order->update(['status' => self::STATUS_COMPLETED]);

            return response()->json([
                'success' => true,
                'message' => 'Order completed successfully',
                'status' => self::STATUS_COMPLETED
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
        $format = $request->input('format', 'csv');
        
        $orders = SimNetworkOrder::latest()->get();

        if ($format === 'csv') {
            return $this->exportCsv($orders);
        }

        return response()->json(['error' => 'Invalid format'], 400);
    }

    /**
     * Upload PDF for an order
     */
    public function uploadPdf(Request $request, $orderId)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240', // Max 10MB
        ]);

        try {
            $order = SimNetworkOrder::findOrFail($orderId);

            // Delete old PDF if exists
            if ($order->admin_note && file_exists(public_path($order->admin_note))) {
                unlink(public_path($order->admin_note));
            }

            // Handle file upload
            if ($request->hasFile('pdf')) {
                $file = $request->file('pdf');
                $filename = 'order_' . $orderId . '_' . time() . '.pdf';
                
                // Move file to public/sim_network_pdfs
                $file->move(public_path('sim_network_pdfs'), $filename);
                
                // Save path in admin_note column
                $pdfPath = 'sim_network_pdfs/' . $filename;
                $order->update(['admin_note' => $pdfPath]);

                return response()->json([
                    'success' => true,
                    'message' => 'PDF uploaded successfully',
                    'path' => $pdfPath
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No PDF file found'
            ], 400);

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
            $order = SimNetworkOrder::findOrFail($orderId);

            if (!$order->admin_note || !str_contains($order->admin_note, '.pdf')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No PDF found for this order'
                ], 404);
            }

            $filePath = public_path($order->admin_note);

            if (!file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'PDF file not found'
                ], 404);
            }

            return response()->download($filePath, 'order_' . $orderId . '_document.pdf');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error downloading PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update note for an order (save to text column)
     */
    public function updateNote(Request $request, $orderId)
    {
        try {
            $request->validate([
                'text' => 'required|string|max:500'
            ]);

            $order = SimNetworkOrder::findOrFail($orderId);
            
            // Update both text and status to completed
            $order->update([
                'text' => $request->input('text'),
                'status' => self::STATUS_COMPLETED  // Auto set to completed (2)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'নোট সফলভাবে সংরক্ষিত এবং অর্ডার সম্পন্ন করা হয়েছে!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'নোট সংরক্ষণে সমস্যা হয়েছে: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export orders as CSV
     */
    private function exportCsv($orders)
    {
        $filename = 'sim-network-orders-' . date('Y-m-d-His') . '.csv';
        $handle = fopen('php://memory', 'r+');

        // CSV Header
        fputcsv($handle, [
            'ID',
            'User ID',
            'Service Type',
            'Form Data',
            'Status',
            'Created At',
            'Updated At'
        ]);

        // CSV Data
        foreach ($orders as $order) {
            $formData = is_array($order->form_data) ? json_encode($order->form_data) : $order->form_data;
            
            fputcsv($handle, [
                $order->id,
                $order->user_id,
                $order->form_type_name ?? $this->getServiceName($order->type),
                $formData,
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
            1 => 'কল লিস্ট ৩ মাস',
            2 => 'রবি/এয়ারটেল SMS',
            3 => 'বাংলালিংক SMS',
            4 => 'নাম্বার টু লোকেশন',
            5 => 'NID টু নাম্বার',
            6 => 'IMEI টু লোকেশন',
            7 => 'IMEI টু এক্টিভ',
            8 => 'নাম্বার টু IMEI',
            9 => 'বিকাশ ইনফো',
            10 => 'নগদ ইনফো',
            11 => 'রকেট ইনফো',
            default => 'Unknown'
        };
    }
}
