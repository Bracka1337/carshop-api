<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class FakePaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $request->validate([
            'card_number' => 'required|digits:16',
            'expiry_date' => 'required|date_format:m/y',
            'cvv' => 'required|digits:3',
        ]);

        $mockyUrl = 'https://run.mocky.io/v3/43730507-7c65-4222-81a7-cb951368cdc7'; // Replace with your actual Mocky API URL

        $client = new Client();

        try {
            $response = $client->post($mockyUrl, [
                'json' => [
                    'card_number' => $request->input('card_number'),
                    'expiry_date' => $request->input('expiry_date'),
                    'cvv' => $request->input('cvv'),
                ]
            ]);

            $responseBody = json_decode($response->getBody(), true);

            if ($response->getStatusCode() == 200 && $responseBody['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Payment processed successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment failed. Please try again.',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment failed. Please try again.',
            ], 500);
        }
    }
}
