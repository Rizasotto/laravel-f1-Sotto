<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\GCashPaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $gcashService;

    public function __construct(GCashPaymentService $gcashService)
    {
        $this->gcashService = $gcashService;
    }

    /**
     * Handle GCash payment processing - Direct redirect to GCash
     */
    public function processGCash(Request $request, Order $order)
    {
        // Verify order belongs to authenticated user
        if ($order->buyer_id !== auth()->id()) {
            return redirect()->route('order.index')->with('error', 'Unauthorized');
        }

        // Check if order is still pending payment
        if ($order->payment_status !== 'pending') {
            return redirect()->route('order.show', $order)->with('error', 'Order already paid or cancelled');
        }

        // Generate GCash payment link
        // In production, this would call the actual GCash API to generate a payment link
        $gcashPaymentLink = $this->generateGCashPaymentLink($order);

        // Redirect directly to GCash (or GCash app if available)
        return redirect()->away($gcashPaymentLink);
    }

    /**
     * Generate GCash payment link - Direct to GCash
     */
    private function generateGCashPaymentLink($order)
    {
        // In production: Call real GCash Payment API
        // For now: Generate a mock GCash payment link
        
        $amount = number_format($order->total_amount, 2);
        $reference = $order->order_number;
        $merchantId = env('GCASH_MERCHANT_ID', 'ARTCONNECT001');
        $callbackUrl = route('payment.gcash.callback');
        
        // This would be the actual GCash payment gateway URL in production
        // GCash would provide this endpoint and API credentials
        $gcashPaymentUrl = "https://payment.gcash.com/api/checkout?" . http_build_query([
            'merchant_id' => $merchantId,
            'amount' => $amount,
            'reference_number' => $reference,
            'customer_contact' => auth()->user()->phone,
            'callback_url' => $callbackUrl,
            'return_url' => route('order.show', $order),
            'cancel_url' => route('payment.gcash.failed', $order),
        ]);
        
        // For testing: Use the actual GCash form with direct redirection
        // This simulates opening GCash app/portal
        $testingUrl = route('payment.gcash.form', $order) . "?direct=true";
        
        // Return the appropriate URL based on environment
        return env('APP_ENV') === 'production' ? $gcashPaymentUrl : $testingUrl;
    }

    /**
     * Show GCash payment form (for user to confirm payment)
     */
    public function showGCashForm(Order $order)
    {
        if ($order->buyer_id !== auth()->id()) {
            return redirect()->route('order.index')->with('error', 'Unauthorized');
        }

        if ($order->payment_status !== 'pending') {
            return redirect()->route('order.show', $order)->with('error', 'Order already paid or cancelled');
        }

        return view('payment.gcash_form', compact('order'));
    }

    /**
     * GCash payment callback/verification
     */
    public function gcashCallback(Request $request)
    {
        $referenceNumber = $request->input('reference_number');
        $orderId = $request->input('order_id');
        $amount = $request->input('amount');
        $signature = $request->input('signature');
        $status = $request->input('status');

        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Verify the payment with GCash
        if ($status === 'success') {
            $this->gcashService->recordPayment($order, $referenceNumber, $amount, 'paid');
            $order->update(['status' => 'confirmed']);
            
            return redirect()->route('order.show', $order)->with('success', 'Payment completed! Your order has been confirmed.');
        } else {
            $this->gcashService->recordPayment($order, $referenceNumber, $amount, 'failed');
            return redirect()->route('order.checkout', $order)->with('error', 'Payment failed. Please try again.');
        }
    }

    /**
     * Mock GCash payment simulation (for testing)
     */
    public function mockGCashPayment(Request $request, Order $order)
    {
        // Validate order
        if ($order->buyer_id !== auth()->id()) {
            return redirect()->route('order.index')->with('error', 'Unauthorized');
        }

        // Get GCash number from request
        $gcashNumber = $request->input('gcash_number');

        // Simulate successful payment
        $referenceNumber = 'GCASH-' . strtoupper(uniqid());
        
        $this->gcashService->recordPayment(
            $order,
            $referenceNumber,
            $order->total_amount,
            'paid'
        );

        $order->update([
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'shipping_address' => $request->input('address') ?? $order->shipping_address,
        ]);

        // Send SMS notification to buyer's GCash number
        $this->sendGCashNotification($gcashNumber, $order, $referenceNumber);

        // Show payment success notification instead of redirecting
        return view('payment.success', [
            'order' => $order,
            'amount' => $order->total_amount,
            'referenceNumber' => $referenceNumber,
        ]);
    }

    /**
     * Send GCash SMS notification
     */
    private function sendGCashNotification($phoneNumber, Order $order, $referenceNumber)
    {
        // Format phone number (ensure it has country code)
        $phone = $phoneNumber;
        if (!str_starts_with($phone, '+63')) {
            $phone = '+63' . ltrim($phone, '0');
        }

        // SMS message
        $message = "PAYMENT SUCCESSFULLY\nOrder: {$order->order_number}\nAmount: ₱" . number_format($order->total_amount, 2) . "\nRef: {$referenceNumber}\nArt Connect Store";

        // In production, integrate with SMS provider (Twilio, Semaphore, etc.)
        // For now, we log it
        \Log::info("GCash SMS sent to {$phone}: {$message}");

        // TODO: Implement actual SMS sending via SMS gateway
        // Example with Twilio:
        // $twilio = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        // $twilio->messages->create($phone, [
        //     'from' => env('TWILIO_FROM'),
        //     'body' => $message
        // ]);
    }

    /**
     * Handle payment failure
     */
    public function paymentFailed(Order $order)
    {
        if ($order->buyer_id !== auth()->id()) {
            return redirect()->route('order.index')->with('error', 'Unauthorized');
        }

        return redirect()->route('order.checkout', $order)->with('error', 'Payment was cancelled. Please try again.');
    }

    /**
     * Check payment status
     */
    public function checkPaymentStatus(Order $order)
    {
        if ($order->buyer_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'payment_status' => $order->payment_status,
            'order_status' => $order->status,
            'paid_at' => $order->paid_at,
        ]);
    }
}
