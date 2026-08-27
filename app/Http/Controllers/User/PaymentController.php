<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Transaction;

class PaymentController extends Controller
{
    // Show the payment form or handle the payment request
    public function payment(Request $request)
    {
        if ($request->isMethod('get')) {
            // Show the payment form
            return view('user.payment_form'); // Blade file to be created
        }

        // Handle the payment request (POST method)
        $request->validate([
            'holding_id' => 'required|integer',
            'amount' => 'required|numeric|min:1',
        ]);

        // Extract input data
        $holding_id = $request->input('holding_id');
        $amount = $request->input('amount');

        // API endpoint
        $url = 'https://dakhila.ldtax.gov.bd/dakhila/payment-request-lsg';

        // Prepare the payload
        $payload = [
            'holding_id' => $holding_id,
            'amount' => $amount,
            'advance_year' => 0,
            'depositor_cid' => 7831377, // Replace with dynamic value if needed
            'owner_id' => 0,
            'is_app' => 0,
        ];

        try {
            // Make the API request using Laravel's HTTP client
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://portal.ldtax.gov.bd',
            ])->post($url, $payload);

            // Check the response status
            if ($response->successful()) {
                $data = $response->json();

                // Check if status is true
                if ($data['status'] === "true" && isset($data['url'])) {
                    // Charge the user
                    $user = auth()->user();
                    $fee = \App\Models\ServiceCharge::getCharge('payment');

                    // Ensure the user has sufficient balance
                    if ($user->balance < $fee) {
                        return back()->withErrors(['msg' => 'Insufficient balance to complete the payment request.']);
                    }

                    // Deduct the fee
                    $user->balance -= $fee;
                    $user->save();

                    // Log the transaction
                    $this->createTransaction($fee, 'Debit', 'Charged for payment request', $user->id);

                    // Return success message with payment URL
                    return redirect()->to($data['url'])->with('success', 'Payment URL ready. You have been charged 300.');
                } else {
                    // Handle case where payment request was unsuccessful
                    return back()->withErrors(['msg' => 'Payment request failed: ' . ($data['msg'] ?? 'Unknown error')]);
                }
            } else {
                // If API response is unsuccessful, return with error message
                $error = $response->json();
                return back()->withErrors(['msg' => 'Payment request failed: ' . ($error['message'] ?? 'Unknown error')]);
            }
        } catch (\Exception $e) {
            // Handle any exceptions thrown during the request
            return back()->withErrors(['msg' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    // Helper function to log transactions
    protected function createTransaction($amount, $type, $details, $user_id)
    {
        // Create a new transaction instance
        $transaction = new Transaction();
        $transaction->user_id = $user_id;
        $transaction->amount = $amount;
        $transaction->type = $type; // 'Debit' or 'Credit'
        $transaction->details = $details;
        $transaction->tx_id = uniqid('txn_', true); // Generate a unique transaction ID
        $transaction->created_at = now();
        $transaction->save();
    }
}
