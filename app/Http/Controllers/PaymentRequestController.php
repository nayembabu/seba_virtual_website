<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Transaction;

class PaymentRequestController extends Controller
{
    public function makePaymentRequest(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'holding_id' => 'required|numeric',
        'amount1' => 'required|numeric',
    ]);

    // Retrieve the current user
    $user = auth()->user();
    $fee = \App\Models\ServiceCharge::getCharge('payment-request');

    // Check if the user has sufficient balance for the fee
    if ($user->balance < $fee) {
        return back()->withInput()->withErrors(['msg' => 'Insufficient balance']);
    }

    // Initialize Guzzle client
    $client = new Client();

    // Define the endpoint URL
    $url = 'https://dakhila.ldtax.gov.bd/dakhila/payment-request-lsg';

    // Define the headers
    $headers = [
        'Content-Type' => 'application/json',
        'Sec-Ch-Ua-Platform' => 'Windows',
        'Accept-Language' => 'en-GB,en;q=0.9',
        'Accept' => 'application/json',
        'Sec-Ch-Ua' => '"Chromium";v="131", "Not_A Brand";v="24"',
        'Sec-Ch-Ua-Mobile' => '?0',
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.6778.140 Safari/537.36',
        'Origin' => 'https://portal.ldtax.gov.bd',
        'Sec-Fetch-Site' => 'same-site',
        'Sec-Fetch-Mode' => 'cors',
        'Sec-Fetch-Dest' => 'empty',
        'Referer' => 'https://portal.ldtax.gov.bd/',
        'Accept-Encoding' => 'gzip, deflate, br',
    ];

    // Define the body of the POST request (the data to send)
    $data = [
        'holding_id' => $request->holding_id,
        'amount' => $request->amount1,  // Use the input amount here for API
        'advance_year' => 0,
        'depositor_cid' => 7831377, // Customize these as needed
        'owner_id' => 0,
        'is_app' => 0,
    ];

    try {
        // Send the POST request to the API
        $response = $client->post($url, [
            'json' => $data,
            'headers' => $headers,
        ]);

        // Get the response body as a string
        $responseBody = json_decode($response->getBody()->getContents(), true);

        // Check if the response status is true
        if (isset($responseBody['status']) && $responseBody['status'] === 'true') {
            // Create the transaction record with the fixed $fee (not user-provided amount)
            $this->createTransaction($fee, 'Debit', 'Payment request to LSG', $user->id);

            // Deduct the fee from the user's balance
            $user->balance -= $fee;  // Subtract the fixed fee
            $user->save(); // Save the updated balance

            // Return the payment URL from the response
            return redirect()->back()->with('status', 'Payment URL: ' . $responseBody['url']);
        } else {
            return redirect()->back()->with('status', 'Failed to get payment URL.');
        }
    } catch (RequestException $e) {
        return redirect()->back()->with('status', 'An error occurred: ' . $e->getMessage());
    }
}

    /**
     * Create a new transaction for the user.
     *
     * @param float $amount
     * @param string $type
     * @param string $details
     * @param int $user_id
     * @param string|null $tx_id
     * @param string|null $reference
     * @return void
     */
    protected function createTransaction($amount, $type, $details, $user_id, $tx_id = null, $reference = null)
    {
        // Create a new transaction instance
        $transaction = new Transaction();
        $transaction->user_id = $user_id;
        $transaction->amount = $amount; // Use the fixed fee amount here
        $transaction->type = $type; // 'Debit' or 'Credit'
        $transaction->details = $details; // Use 'details' instead of 'description'
        $transaction->tx_id = $tx_id; // Save the transaction ID
        $transaction->created_at = now(); // Set the current timestamp
        $transaction->save(); // Save the transaction record
    }
}
