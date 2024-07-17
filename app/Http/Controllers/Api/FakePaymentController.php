<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Rules\CardNumber;

class FakePaymentController extends Controller
{
    public function processPayment(Request $request)
    {

        $validate = $request->validate([
            "full_name" => "required|string|max:255",
            'card_number' => ['required', new CardNumber],
            'expiry_date' => 'required|date_format:m/y',
            'cvv' => 'required|digits:3',
        ]);
        //TODO
        //clear cart on success,
        //update with payment id and payment status



        if ($validate) {
            $mockyUrl = 'https://run.mocky.io/v3/192c87e3-e951-4c7d-af1c-b70dea4de70b';

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

                    return view('paymentSuccess');
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
        } else {
            return response()->json([
                'status' => 'error',
                'message' => ' Please enter a valid card number, expiry date and cvv.
                ',
            ], 400);
        }
    }
}
