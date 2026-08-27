<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NidOrder;
use Illuminate\Http\Request;

class IdCardOrderController extends Controller
{
    /**
     * Display a listing of ID card orders
     */
    public function index()
    {
        return view('admin.id-card-order.index');
    }

    /**
     * Get orders list with search and filter (AJAX)
     */
    public function getOrders(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $page = $request->input('page', 1);
        $perPage = 15;

        // Build query
        $query = NidOrder::query();

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nid', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status) {
            $statusMap = [
                'pending' => NidOrder::STATUS_PENDING,
                'processing' => NidOrder::STATUS_PROCESSING,
                'completed' => NidOrder::STATUS_COMPLETED,
                'rejected' => NidOrder::STATUS_REJECTED
            ];
            
            if (isset($statusMap[$status])) {
                $query->where('status', $statusMap[$status]);
            }
        }

        // Get statistics
        $stats = [
            'total' => NidOrder::count(),
            'pending' => NidOrder::where('status', NidOrder::STATUS_PENDING)->count(),
            'processing' => NidOrder::where('status', NidOrder::STATUS_PROCESSING)->count(),
            'completed' => NidOrder::where('status', NidOrder::STATUS_COMPLETED)->count(),
        ];

        // Paginate results
        $paginated = $query->latest()->paginate($perPage, ['*'], 'page', $page);

        // Format orders
        $orders = $paginated->items();
        $formattedOrders = array_map(function ($order) {
            return [
                'id' => $order->id,
                'name' => $order->name,
                'nid' => $order->nid,
                'email' => $order->email,
                'dob' => $order->dob,
                'form_type' => $order->form_type,
                'form_type_name' => $order->form_type_name,
                'cost' => $order->cost,
                'status' => $this->getStatusString($order->status),
                'status_code' => $order->status,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
                'user_id' => $order->user_id,
                'text' => $order->text,
                'admin_note' => $order->admin_note,
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
            'status' => 'required|in:pending,processing,completed,rejected',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $order = NidOrder::findOrFail($orderId);

        // Map status string to number
        $statusMap = [
            'pending' => NidOrder::STATUS_PENDING,
            'processing' => NidOrder::STATUS_PROCESSING,
            'completed' => NidOrder::STATUS_COMPLETED,
            'rejected' => NidOrder::STATUS_REJECTED
        ];

        $newStatus = $statusMap[$request->input('status')];
        
        // Prepare update data
        $updateData = ['status' => $newStatus];

        // Add rejection reason and notes if rejecting
        if ($newStatus == NidOrder::STATUS_REJECTED) {
            $reason = $request->input('reason', 'No reason provided');
            $notes = $request->input('notes', '');
            
            // Store rejection details (you may need to add columns to nid_orders table)
            $updateData['rejection_reason'] = $reason;
            $updateData['rejection_notes'] = $notes;
        }

        $order->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'status' => $this->getStatusString($newStatus),
            'status_code' => $newStatus
        ]);
    }

    /**
     * Approve an order
     */
    public function approve(Request $request, $orderId)
    {
        $order = NidOrder::with('user')->findOrFail($orderId);

        $user = $order->user;
        if ($order->is_money_back) {
            if ($order->cost > $user->balance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient balance',
                    'status' => $order->status
                ]);
            }
            $user->balance = $user->balance - $order->cost;
            $user->save();
        }

        $order->update(['status' => NidOrder::STATUS_PROCESSING]);

        return response()->json([
            'success' => true,
            'message' => 'Order approved successfully',
            'status' => 'processing'
        ]);
    }

    /**
     * Reject an order
     */
    public function reject(Request $request, $orderId)
    {
        $request->validate([
            'reason' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $order = NidOrder::with('user')->findOrFail($orderId);
        
        $updateData = [
            'status' => NidOrder::STATUS_REJECTED,
            'rejection_reason' => $request->input('reason', 'No reason provided'),
            'rejection_notes' => $request->input('notes', ''),
            'is_money_back' => 1
        ];

        $order->update($updateData);
        
        $user = $order->user;
        if ($order->is_money_back) {
            $user->increment('balance', $order->cost);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order rejected successfully',
            'status' => 'rejected'
        ]);
    }

    /**
     * Complete an order
     */
    public function complete(Request $request, $orderId)
    {
        $order = NidOrder::findOrFail($orderId);
        $order->update(['status' => NidOrder::STATUS_COMPLETED]);

        return response()->json([
            'success' => true,
            'message' => 'Order completed successfully',
            'status' => 'completed'
        ]);
    }

    /**
     * Upload PDF for an order
     */
    public function uploadPDF(Request $request, $id)
    {
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:5120' // 5MB max
        ]);

        try {
            $order = NidOrder::findOrFail($id);
            
            if ($request->hasFile('pdf_file')) {
                $file = $request->file('pdf_file');
                $fileName = 'nid-order-' . $id . '-' . time() . '.pdf';
                
                // Save to public/uploads/nid-orders directory
                $file->move(public_path('uploads/nid-orders'), $fileName);
                
                // Delete old PDF if exists
                if ($order->admin_note && file_exists(public_path($order->admin_note))) {
                    unlink(public_path($order->admin_note));
                }
                
                // Save path to admin_note field
                $order->admin_note = 'uploads/nid-orders/' . $fileName;
                $order->save();
                
                return response()->json([
                    'success' => true,
                    'message' => 'PDF uploaded successfully',
                    'file_name' => $fileName,
                    'file_path' => $order->admin_note
                ]);
            }
            
            return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
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
    public function downloadPDF($id)
    {
        $order = NidOrder::findOrFail($id);
        
        if (!$order->admin_note || !file_exists(public_path($order->admin_note))) {
            abort(404, 'PDF file not found');
        }

        return response()->download(public_path($order->admin_note));
    }

    /**
     * Export orders to CSV or PDF
     */
    public function export(Request $request)
    {
        $format = $request->input('format', 'csv');
        
        $orders = NidOrder::latest()->get();

        if ($format === 'csv') {
            return $this->exportCsv($orders);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($orders);
        }

        return response()->json(['error' => 'Invalid format'], 400);
    }

    /**
     * Export orders as CSV
     */
    private function exportCsv($orders)
    {
        $filename = 'id-card-orders-' . date('Y-m-d-His') . '.csv';
        $handle = fopen('php://memory', 'r+');

        // CSV Header
        fputcsv($handle, [
            'ID',
            'Name',
            'NID',
            'Email',
            'DOB',
            'Form Type',
            'Cost',
            'Status',
            'Created At',
            'Updated At'
        ]);

        // CSV Data
        foreach ($orders as $order) {
            fputcsv($handle, [
                $order->id,
                $order->name,
                $order->nid,
                $order->email,
                $order->dob,
                $order->form_type_name,
                $order->cost,
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
     * Export orders as PDF
     */
    private function exportPdf($orders)
    {
        // You can use TCPDF, MPDF, or DomPDF for PDF generation
        // This is a basic implementation - install a package like: composer require barryvdh/laravel-dompdf
        
        // Example with Laravel DomPDF:
        // $pdf = PDF::loadView('admin.id-card-order.pdf', compact('orders'));
        // return $pdf->download('id-card-orders-' . date('Y-m-d-His') . '.pdf');

        // For now, return CSV as fallback
        return $this->exportCsv($orders);
    }

    /**
     * Save notes for an order
     */
    public function saveNotes(Request $request, $id)
    {
        try {
            $order = NidOrder::findOrFail($id);
            $order->text = $request->input('text', '');
            $order->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Notes saved successfully',
                'text' => $order->text
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving notes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Convert status code to string
     */
    private function getStatusString($status)
    {
        return match ($status) {
            NidOrder::STATUS_PENDING => 'pending',
            NidOrder::STATUS_PROCESSING => 'processing',
            NidOrder::STATUS_COMPLETED => 'completed',
            NidOrder::STATUS_REJECTED => 'rejected',
            default => 'unknown'
        };
    }
}
