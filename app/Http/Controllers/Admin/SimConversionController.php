<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SimConversion;
use Illuminate\Http\Request;

class SimConversionController extends Controller
{
    // Status constants
    const STATUS_PENDING = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_REJECTED = 3;

    /**
     * Display a listing of SIM conversion orders
     */
    public function index()
    {
        return view('admin.Seam_Biometric_order.index');
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
        $query = SimConversion::with('user');

        // Search filter - search in phone number from form_data
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('user_id', 'like', "%{$search}%")
                  ->orWhere('form_data', 'like', "%{$search}%");
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
            'total' => SimConversion::count(),
            'pending' => SimConversion::where('status', self::STATUS_PENDING)->count(),
            'processing' => SimConversion::where('status', self::STATUS_PROCESSING)->count(),
            'completed' => SimConversion::where('status', self::STATUS_COMPLETED)->count(),
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
                'form_type_name' => $order->form_type_name,
                'status' => $order->status,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
                'admin_note' => $order->admin_note,
                'note' => $order->note,
                'text' => $order->text,
                'reject_note' => $order->reject_note,
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
            $order = SimConversion::findOrFail($orderId);

            $newStatus = $request->input('status');
            
            // Prepare update data
            $updateData = ['status' => $newStatus];

            // Add rejection reason if rejecting
            if ($newStatus == self::STATUS_REJECTED) {
                $reason = $request->input('reason', 'No reason provided');
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
            $order = SimConversion::with("user")->findOrFail($orderId);

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
            $order = SimConversion::with("user")->findOrFail($orderId);
            
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
            $order = SimConversion::findOrFail($orderId);
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
        
        $orders = SimConversion::latest()->get();

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
        $filename = 'sim-conversion-orders-' . date('Y-m-d-His') . '.csv';
        $handle = fopen('php://memory', 'r+');

        // CSV Header
        fputcsv($handle, [
            'ID',
            'User ID',
            'Phone Number',
            'Type',
            'Form Type Name',
            'Status',
            'Created At',
            'Updated At'
        ]);

        // CSV Data
        foreach ($orders as $order) {
            $formData = is_string($order->form_data) ? json_decode($order->form_data) : $order->form_data;
            $phoneNumber = $formData->number ?? 'N/A';
            
            fputcsv($handle, [
                $order->id,
                $order->user_id,
                $phoneNumber,
                $this->getTypeName($order->type),
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
        return match ($status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_REJECTED => 'Rejected',
            default => 'Unknown'
        };
    }

    /**
     * Get type name in Bengali
     */
    private function getTypeName($type)
    {
        return match ($type) {
            1 => 'জিপি',
            2 => 'বাংলালিংক',
            3 => 'রবি',
            default => 'Unknown'
        };
    }

    /**
     * Upload PDF and save path to admin_note, then mark order as completed
     */
    public function uploadPDF(Request $request, $orderId)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240' // 10MB max
        ]);

        try {
            $order = SimConversion::findOrFail($orderId);

            // Create upload directory if it doesn't exist
            $uploadDir = 'sim-conversions-pdfs';
            if (!file_exists(public_path($uploadDir))) {
                mkdir(public_path($uploadDir), 0755, true);
            }

            // Generate unique filename with timestamp
            $file = $request->file('pdf');
            $filename = 'sim-conversion-' . $orderId . '-' . time() . '.pdf';
            $file->move(public_path($uploadDir), $filename);

            // Save path to admin_note column and mark as completed
            $pdfPath = $uploadDir . '/' . $filename;
            $order->update([
                'admin_note' => $pdfPath,
                'status' => self::STATUS_COMPLETED // Auto-complete on PDF upload
            ]);

            return response()->json([
                'success' => true,
                'message' => 'PDF uploaded successfully and order marked as completed',
                'pdf_path' => $pdfPath
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download PDF from admin_note
     */
    public function downloadPDF($orderId)
    {
        try {
            $order = SimConversion::findOrFail($orderId);

            if (!$order->admin_note) {
                return response()->json([
                    'success' => false,
                    'message' => 'No PDF found for this order'
                ], 404);
            }

            $pdfPath = public_path($order->admin_note);

            if (!file_exists($pdfPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'PDF file not found'
                ], 404);
            }

            return response()->download($pdfPath);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error downloading PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save note to text column and mark as completed
     */
    public function saveNote(Request $request, $orderId)
    {
        $request->validate([
            'note' => 'nullable|string'
        ]);

        try {
            $order = SimConversion::findOrFail($orderId);
            $order->update([
                'text' => $request->input('note'),
                'status' => self::STATUS_COMPLETED // Mark as completed (2)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Note saved successfully and order marked as completed'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving note: ' . $e->getMessage()
            ], 500);
        }
    }
}
