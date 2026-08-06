<?php

namespace App\Services;

use App\Models\Order;

class GCashPaymentService
{
    private $apiUrl = 'https://pay.gcash.com/api/';
    private $merchantId;
    private $apiKey;
    private $merchantSecret;

    public function __construct()
    {
        $this->merchantId = config('payment.gcash.merchant_id');
        $this->apiKey = config('payment.gcash.api_key');
        $this->merchantSecret = config('payment.gcash.merchant_secret');
    }

    /**
     * Create a GCash payment link for the order
     */
    public function createPaymentLink(Order $order)
    {
        $paymentData = [
            'merchant_id' => $this->merchantId,
            'amount' => $order->total_amount,
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'customer_name' => $order->first_name . ' ' . $order->last_name,
            'customer_email' => $order->email,
            'customer_phone' => $order->phone,
            'description' => 'Art Connect - Order #' . $order->order_number,
            'redirect_url' => route('payment.gcash.callback'),
            'success_url' => route('order.show', $order),
            'failure_url' => route('order.checkout', $order),
            'cancel_url' => route('order.checkout', $order),
        ];

        // Generate signature
        $paymentData['signature'] = $this->generateSignature($paymentData);

        return $this->sendRequest('create_payment', $paymentData);
    }

    /**
     * Verify payment from GCash callback
     */
    public function verifyPayment($referenceNumber, $amount, $signature)
    {
        $verifyData = [
            'merchant_id' => $this->merchantId,
            'reference_number' => $referenceNumber,
            'amount' => $amount,
        ];

        // Verify signature
        $expectedSignature = $this->generateSignature($verifyData);
        if ($signature !== $expectedSignature) {
            return false;
        }

        return $this->sendRequest('verify_payment', $verifyData);
    }

    /**
     * Generate HMAC signature
     */
    private function generateSignature($data)
    {
        $message = json_encode($data);
        return hash_hmac('sha256', $message, $this->merchantSecret);
    }

    /**
     * Send request to GCash API
     */
    private function sendRequest($endpoint, $data)
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->apiUrl . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey,
            ],
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            return json_decode($response, true);
        }

        return null;
    }

    /**
     * Create a simple GCash payment button/link
     * For testing/mock implementation
     */
    public function generateMockPaymentLink(Order $order)
    {
        // Return direct URL instead of using route() to avoid model binding issues
        return '/payment/gcash/process/' . $order->id;
    }

    /**
     * Record payment transaction
     */
    public function recordPayment(Order $order, $referenceNumber, $amount, $status = 'paid')
    {
        // Map status for orders table (pending, paid, failed)
        $orderStatus = ($status === 'completed') ? 'paid' : $status;
        
        $order->update([
            'payment_status' => $orderStatus,
            'payment_method' => 'gcash',
            'gcash_reference_number' => $referenceNumber,
            'paid_at' => now(),
        ]);

        // Create payment record (accepts pending, completed, failed)
        $paymentStatus = ($status === 'paid') ? 'completed' : $status;
        
        \App\Models\Payment::create([
            'order_id' => $order->id,
            'amount' => $amount,
            'payment_method' => 'gcash',
            'reference_number' => $referenceNumber,
            'status' => $paymentStatus,
            'paid_at' => now(),
        ]);

        return true;
    }
}
