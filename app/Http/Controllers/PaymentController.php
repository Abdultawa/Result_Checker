<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class PaymentController extends Controller
{
    public function makePayment($regNo)
    {
        $results = Result::where('regNo', $regNo)->get();
        return view('make-payment', ['results' => $results]);
    }
    public function statement(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
            'Content-Type' => 'application/json',
        ])->get('https://api.paystack.co/transaction/verify/' . $request->reference);
    
        // Check if the request was successful
        
        if ($response->successful()) {
            // Get the transaction data from the response            
            if ($response->json('data.status') === 'success') {
                Payment::where('email', $response->json('data.customer.email'))->update(['status' => 'success']);
                $payment = Payment::where('email', $response->json('data.customer.email'))->first();
                return view('statement',['payment' => $payment]);
            } else {
                return back()->with('error', 'Transaction verification failed. Please try again later.');
            }
        } else {
            return back()->with('error', 'Failed to verify transaction. Please try again later.');
        }
    }
    
    public function processPayment(Request $request)
    {
        // Validate the form data
        $request->validate([
            'firstname' =>'required',
            'lastname' =>'required',
            'regNo' =>'required',
            'dept' => 'required',
            'email' => 'required|email',
        ]);
        Payment::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'regNo' => $request->regNo,
            'dept' => $request->dept,
            'email' => $request->email,
            
        ]);
    
        // Call the Paystack API to initiate the payment
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.paystack.co/transaction/initialize', [
            'amount' => 2000 * 100, 
            'email' => $request->email,
            'callback_url' => route('statement'),
            'metadata' => [
                'custom_fields' => [
                    [
                        'display_name' => 'Payment For',
                        'variable_name' => 'payment_for',
                        'value' => 'Statement of Result',
                    ]
                ]
            ]
        ]);
    
        // Check if the request was successful
        if ($response->successful()) {
            // Get the authorization URL from the response data
            $authorizationUrl = $response['data']['authorization_url'];
            
            // Redirect the user to the payment gateway for payment
            return redirect()->away($authorizationUrl);
        } else {
            return back()->with('error', 'Failed to initiate payment. Please try again later.');
        }
    }
    
}
