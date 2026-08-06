# GCash Payment Integration Guide

## Overview
This guide explains how to use the GCash payment integration in the Art Connect platform. Customers can now pay for their artwork orders directly using GCash.

## Setup Instructions

### 1. Environment Configuration
Add the following to your `.env` file:

```env
GCASH_MERCHANT_ID=your_merchant_id
GCASH_API_KEY=your_api_key
GCASH_MERCHANT_SECRET=your_merchant_secret
GCASH_SANDBOX_MODE=true # Set to false for production
```

### 2. Database Migration
Run the migration to create the payments table:

```bash
php artisan migrate
```

This migration will:
- Create a `payments` table to store payment records
- Add GCash-related columns to the `orders` table
- Store payment methods, reference numbers, and payment statuses

### 3. Payment Flow

#### Customer Journey:
1. Customer adds artworks to cart
2. Clicks "Checkout"
3. Fills in shipping information
4. Selects **GCash** as payment method
5. Clicks "Place Order"
6. Redirected to GCash payment page
7. Enters their GCash number
8. Confirms payment
9. Order is confirmed and payment recorded

## How It Works

### Components

#### A. PaymentController (`app/Http/Controllers/PaymentController.php`)
- `processGCash()` - Displays GCash payment form
- `mocK GCashPayment()` - Simulates successful payment (for testing)
- `gcashCallback()` - Handles payment verification
- `checkPaymentStatus()` - API endpoint to check payment status

#### B. GCashPaymentService (`app/Services/GCashPaymentService.php`)
- Handles GCash API communication
- Generates payment links
- Verifies payments
- Records transactions
- Creates HMAC signatures for security

#### C. Payment Model (`app/Models/Payment.php`)
- Stores payment transaction details
- Tracks payment status and references
- Links to orders

#### D. Views
- `resources/views/payment/gcash_form.blade.php` - GCash payment form and instructions

### Payment Methods

The checkout now supports multiple payment methods:
- 💳 Credit Card
- 🏧 Debit Card
- 📱 **GCash** (NEW)
- 🅿️ PayPal
- 🏦 Bank Transfer
- 📅 3-Month Installment

## GCash Account Details (Demo)

For testing, use these mock GCash details:
- **GCash Number:** 0917 123 4567
- **Recipient:** Art Connect Shop
- **Reference:** Order number (e.g., ORD-1234567890-5678)

## Implementation Steps for Production

### 1. Register with GCash
Contact GCash business support to get:
- Merchant ID
- API Key
- Merchant Secret

### 2. Update Configuration
Update `config/payment.php` with actual credentials:

```php
'gcash' => [
    'merchant_id' => env('GCASH_MERCHANT_ID'),
    'api_key' => env('GCASH_API_KEY'),
    'merchant_secret' => env('GCASH_MERCHANT_SECRET'),
    'sandbox_mode' => false, // Production
],
```

### 3. Enable Real API Integration
In `PaymentController.php`, replace the mock payment with real GCash API:

```php
public function processGCash(Request $request, Order $order)
{
    // Generate real GCash payment link
    $response = $this->gcashService->createPaymentLink($order);
    if (!$response) {
        return redirect()->back()->with('error', 'Failed to create payment');
    }
    
    // Redirect to GCash payment URL
    return redirect($response['payment_url']);
}
```

### 4. Set Up Webhooks
Configure GCash webhooks to automatically verify payments:
- Webhook URL: `https://yoursite.com/payment/gcash/callback`
- Events: payment.completed, payment.failed

## Testing the Integration

### 1. Test Scenario - Successful Payment
```bash
1. Navigate to checkout
2. Select GCash payment method
3. Enter a test GCash number (09XX XXX XXXX)
4. Click "Confirm Payment"
5. Check order status - should be "confirmed"
```

### 2. Verify Payment Recording
Check the database:
```sql
SELECT * FROM payments WHERE order_id = YOUR_ORDER_ID;
SELECT payment_status, gcash_reference_number FROM orders WHERE id = YOUR_ORDER_ID;
```

## Security Features

- ✅ HMAC signature verification
- ✅ Order authorization checks
- ✅ Reference number validation
- ✅ Transaction logging
- ✅ User authentication required
- ✅ HTTPS recommended for production

## Error Handling

### Common Errors

| Error | Cause | Solution |
|-------|-------|----------|
| "Order not found" | Invalid order ID | Check order exists |
| "Unauthorized" | User doesn't own order | Ensure logged in with correct account |
| "Payment failed" | GCash transaction declined | Retry with valid GCash account |
| "Order already paid" | Duplicate payment attempt | Check order status before retrying |

## API Endpoints

### Check Payment Status
```
GET /payment/status/{order_id}
Response: { payment_status, order_status, paid_at }
```

### Process GCash Payment
```
GET /payment/gcash/process/{order_id}
Displays: GCash payment form
```

### Mock Payment Callback (Testing)
```
POST /payment/gcash/mock
Body: { order_id, amount, address }
```

## Database Schema

### Orders Table (Updated)
```sql
ALTER TABLE orders ADD COLUMN payment_method VARCHAR(50);
ALTER TABLE orders ADD COLUMN gcash_reference_number VARCHAR(100);
ALTER TABLE orders ADD COLUMN paid_at TIMESTAMP;
```

### Payments Table (New)
```sql
CREATE TABLE payments (
    id BIGINT PRIMARY KEY,
    order_id BIGINT,
    amount DECIMAL(12,2),
    payment_method VARCHAR(50),
    reference_number VARCHAR(100) UNIQUE,
    status VARCHAR(50),
    paid_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id)
);
```

## Customer Support Information

### What Customers See:
1. GCash option in checkout
2. GCash recipient details
3. Amount to send
4. Step-by-step payment instructions
5. Order confirmation on successful payment

### Payment Confirmation:
- Email notification sent to customer
- GCash notification to their registered number
- Order status updates to "confirmed"
- Shipping address saved automatically

## Troubleshooting

### Payment Gateway Not Responding
- Check API credentials in `.env`
- Verify sandbox mode setting
- Check GCash API status

### Webhook Not Working
- Verify webhook URL is publicly accessible
- Check firewall/security settings
- Enable HTTPS
- Test webhook manually

### Payment Recorded but Order Not Confirmed
- Check logs in `storage/logs/`
- Verify order status in database
- Manually trigger confirmation if needed

## Support Contact

For technical issues with GCash integration:
- Email: support@artconnect.ph
- Documentation: GCash Business Documentation
- GCash Support: support@gcash.com

## Version History

- **v1.0.0** (2024-04-12) - Initial GCash integration
  - Payment form
  - Mock payment processing
  - Real API ready (requires credentials)
  - Database schema updates

---

**Last Updated:** April 12, 2024
**Integration Status:** ✅ Ready for Testing / Pending Production Credentials
