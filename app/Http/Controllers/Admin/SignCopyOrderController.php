<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SignCopyOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SignCopyOrderController extends Controller
{
    public function index()
    {
        $orders = SignCopyOrder::with('user')
            ->latest()
            ->get();

        return view('admin.sign_copy_order.index', compact('orders'));
    }

    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|integer|in:0,1,2,3'
        ]);

        $order = SignCopyOrder::findOrFail($orderId);
        $order->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'status' => $order->status
        ]);
    }

    public function approve($orderId)
    {
        $order = SignCopyOrder::findOrFail($orderId);

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

        $order->update(['status' => 1]);

        return response()->json([
            'success' => true,
            'message' => 'Order approved successfully',
            'status' => 1
        ]);
    }

    public function reject($orderId)
    {
        $order = SignCopyOrder::findOrFail($orderId);
        
        // Get status_note from request if available (will handle Bangla text properly)
        $statusNote = request()->input('status_note');
        
        $user = $order->user;
        $user->increment('balance', $order->cost);
        $order->update([
            'status' => 2, // 2 = Rejected
            'status_note' => $statusNote ,
            'is_money_back' => 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'অর্ডার সফলভাবে বাতিল করা হয়েছে',
            'status' => 2,
            'status_note' => $statusNote
        ]);
    }

    public function complete($orderId)
    {
        $order = SignCopyOrder::findOrFail($orderId);
        $order->update(['status' => 3]); // 3 = Completed

        return response()->json([
            'success' => true,
            'message' => 'Order completed successfully',
            'status' => 3
        ]);
    }

    public function uploadPDF(Request $request, $orderId)
    {
        try {
            // Check if file exists in request
            if (!$request->hasFile('pdf_file')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No file uploaded'
                ], 422);
            }

            $file = $request->file('pdf_file');

            // Validate file existence and size
            if (!$file->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid file upload'
                ], 422);
            }

            // Check file size (max 10MB)
            if ($file->getSize() > 10 * 1024 * 1024) {
                return response()->json([
                    'success' => false,
                    'message' => 'File size must not exceed 10MB'
                ], 422);
            }

            // Check file extension (not MIME type since fileinfo may be disabled)
            $ext = strtolower($file->getClientOriginalExtension());
            if ($ext !== 'pdf') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only PDF files are allowed'
                ], 422);
            }

            $order = SignCopyOrder::findOrFail($orderId);

            // Delete old PDF if exists (from old location)
            if ($order->pdf_file && Storage::disk('public')->exists($order->pdf_file)) {
                Storage::disk('public')->delete($order->pdf_file);
            }

            // Delete old PDF from public folder if exists
            if ($order->admin_note && file_exists(public_path($order->admin_note))) {
                @unlink(public_path($order->admin_note));
            }

            // Create uploads directory if it doesn't exist
            $uploadsDir = public_path('uploads/sign-copy-orders');
            if (!is_dir($uploadsDir)) {
                @mkdir($uploadsDir, 0755, true);
            }

            // Generate unique filename: order_17_20251122_123456.pdf
            $filename = 'order_' . $orderId . '_' . date('Ymd_His') . '.pdf';
            
            // Move file to directory
            if (!$file->move($uploadsDir, $filename)) {
                throw new \Exception('Failed to move file to uploads directory');
            }
            
            // Save relative path for web access
            $pdfPath = 'uploads/sign-copy-orders/' . $filename;
            
            // Update order with admin_note (PDF path) and status = 3 (Completed)
            $order->update([
                'admin_note' => $pdfPath,
                'status' => 3  // Auto set status to Completed
            ]);

            return response()->json([
                'success' => true,
                'message' => 'PDF uploaded successfully and order marked as completed',
                'pdf_path' => $pdfPath,
                'status' => 3
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    public function downloadPDF($filename)
    {
        try {
            $filepath = public_path($filename);

            // Security check - ensure file exists
            if (!file_exists($filepath) || !is_file($filepath)) {
                return response()->json(['error' => 'File not found'], 404);
            }

            // Security check - ensure filename doesn't contain path traversal
            if (strpos($filename, '..') !== false) {
                return response()->json(['error' => 'Access denied'], 403);
            }

            return response()->download($filepath, basename($filepath));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
