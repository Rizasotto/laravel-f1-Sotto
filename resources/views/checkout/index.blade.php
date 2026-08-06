@extends('layouts.app')

@section('title', 'Checkout')

@section('extra-styles')
<style>
    /* Checkout Wrapper */
    .checkout-wrapper {
        background: #f8f9fa;
        min-height: calc(100vh - 100px);
        padding: 30px 0;
    }

    .checkout-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        margin-bottom: 30px;
        border-radius: 8px;
    }

    .checkout-header h1 {
        font-size: 32px;
        margin-bottom: 5px;
    }

    /* Checkout Container */
    .checkout-container {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 30px;
        margin-bottom: 40px;
    }

    /* Checkout Form */
    .checkout-form {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .checkout-section {
        margin-bottom: 30px;
    }

    .checkout-section:last-child {
        margin-bottom: 0;
    }

    .checkout-section-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-step {
        display: inline-block;
        width: 28px;
        height: 28px;
        background: #667eea;
        color: white;
        border-radius: 50%;
        text-align: center;
        line-height: 28px;
        font-weight: bold;
        font-size: 14px;
    }

    .section-divider {
        height: 1px;
        background: #eee;
        margin: 25px 0;
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
        font-size: 13px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.2s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    /* Payment Methods */
    .payment-methods {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 10px;
        margin-bottom: 20px;
    }

    .payment-method {
        position: relative;
    }

    .payment-method input[type="radio"] {
        display: none;
    }

    .payment-method-label {
        display: block;
        padding: 15px;
        border: 2px solid #ddd;
        border-radius: 6px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }

    .payment-method input[type="radio"]:checked + .payment-method-label {
        border-color: #667eea;
        background: #667eea;
        color: white;
    }

    .payment-method-name {
        font-weight: 700;
        color: inherit;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Payment Details */
    .payment-details {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-top: 15px;
    }

    /* Checkout Summary */
    .order-summary {
        background: white;
        border-radius: 12px;
        padding: 25px;
        height: fit-content;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        position: sticky;
        top: 20px;
    }

    .summary-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .summary-items {
        margin-bottom: 20px;
        max-height: 300px;
        overflow-y: auto;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #eee;
        font-size: 13px;
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .item-name {
        color: #666;
    }

    .item-price {
        font-weight: 600;
        color: #333;
    }

    .summary-divider {
        height: 1px;
        background: #eee;
        margin: 15px 0;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
        color: #666;
    }

    .summary-row-value {
        font-weight: 600;
        color: #333;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        font-size: 18px;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 20px;
    }

    /* Buttons */
    .checkout-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-place-order {
        padding: 14px;
        background: #10b981;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .btn-place-order:hover {
        background: #059669;
        transform: translateY(-2px);
    }

    .btn-place-order:disabled {
        background: #ccc;
        cursor: not-allowed;
        transform: none;
    }

    .btn-back {
        padding: 12px;
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s ease;
    }

    .btn-back:hover {
        background: #f0f0f0;
    }

    /* Trust Badges */
    .trust-badges {
        display: flex;
        gap: 15px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eee;
        justify-content: center;
        font-size: 24px;
    }

    .badge-title {
        font-size: 10px;
        color: #999;
        text-align: center;
        margin-top: 5px;
    }

    /* Progress Steps */
    .progress-steps {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
        justify-content: space-between;
    }

    .progress-step {
        flex: 1;
        text-align: center;
    }

    .progress-step-number {
        display: inline-block;
        width: 32px;
        height: 32px;
        background: #ddd;
        color: #999;
        border-radius: 50%;
        line-height: 32px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .progress-step.active .progress-step-number {
        background: #667eea;
        color: white;
    }

    .progress-step.completed .progress-step-number {
        background: #10b981;
        color: white;
    }

    .progress-step-label {
        font-size: 12px;
        color: #999;
        font-weight: 600;
    }

    .progress-step.active .progress-step-label,
    .progress-step.completed .progress-step-label {
        color: #333;
    }

    /* Empty Checkout */
    .empty-checkout {
        background: white;
        border-radius: 12px;
        padding: 60px 40px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .empty-checkout-icon {
        font-size: 64px;
        margin-bottom: 20px;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .checkout-container {
            grid-template-columns: 1fr;
        }

        .order-summary {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .payment-methods {
            grid-template-columns: repeat(2, 1fr);
        }

        .progress-steps {
            gap: 10px;
        }

        .checkout-header h1 {
            font-size: 24px;
        }
    }
</style>
@endsection

@section('content')
<div class="checkout-wrapper">
    <div class="checkout-header">
        <h1>💳 Secure Checkout</h1>
        <p>Complete your order with our secure payment gateway</p>
    </div>

    <div class="max-w-7xl mx-auto px-4">
        <!-- Progress Steps -->
        <div class="progress-steps">
            <div class="progress-step completed">
                <div class="progress-step-number">✓</div>
                <div class="progress-step-label">Cart Review</div>
            </div>
            <div class="progress-step active">
                <div class="progress-step-number">2</div>
                <div class="progress-step-label">Checkout</div>
            </div>
            <div class="progress-step">
                <div class="progress-step-number">3</div>
                <div class="progress-step-label">Confirmation</div>
            </div>
        </div>

        <div class="checkout-container">
            <!-- Checkout Form -->
            <div class="checkout-form">
                <form action="{{ route('order.confirm', $order) }}" method="POST" id="checkoutForm">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <!-- Shipping Information -->
                    <div class="checkout-section">
                        <h2 class="checkout-section-title">
                            <span class="section-step">1</span>
                            Shipping Address
                        </h2>

                        <div class="form-row">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="first_name" required placeholder="John">
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="last_name" required placeholder="Doe">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" required value="{{ auth()->user()->email ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" required placeholder="+63 912 345 6789">
                        </div>

                        <div class="form-group">
                            <label>Street Address</label>
                            <input type="text" name="address" required placeholder="123 Main St">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" required placeholder="Manila">
                            </div>
                            <div class="form-group">
                                <label>Postal Code</label>
                                <input type="text" name="postal_code" required placeholder="1000">
                            </div>
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <!-- Payment Information -->
                    <div class="checkout-section">
                        <h2 class="checkout-section-title">
                            <span class="section-step">2</span>
                            Payment Method
                        </h2>
                        
                        <div class="payment-methods">
                            <!-- Credit Card -->
                            <div class="payment-method">
                                <input type="radio" id="payment-card" name="payment_method" value="credit_card" checked>
                                <label for="payment-card" class="payment-method-label">
                                    <div class="payment-method-name">CREDIT CARD</div>
                                </label>
                            </div>

                            <!-- Debit Card -->
                            <div class="payment-method">
                                <input type="radio" id="payment-debit" name="payment_method" value="debit_card">
                                <label for="payment-debit" class="payment-method-label">
                                    <div class="payment-method-name">DEBIT CARD</div>
                                </label>
                            </div>

                            <!-- GCash -->
                            <div class="payment-method">
                                <input type="radio" id="payment-gcash" name="payment_method" value="gcash">
                                <label for="payment-gcash" class="payment-method-label">
                                    <div class="payment-method-name">GCASH</div>
                                </label>
                            </div>

                            <!-- PayPal -->
                            <div class="payment-method">
                                <input type="radio" id="payment-paypal" name="payment_method" value="paypal">
                                <label for="payment-paypal" class="payment-method-label">
                                    <div class="payment-method-name">PAYPAL</div>
                                </label>
                            </div>

                            <!-- Bank Transfer -->
                            <div class="payment-method">
                                <input type="radio" id="payment-bank" name="payment_method" value="bank_transfer">
                                <label for="payment-bank" class="payment-method-label">
                                    <div class="payment-method-name">BANK TRANSFER</div>
                                </label>
                            </div>

                            <!-- Installment -->
                            <div class="payment-method">
                                <input type="radio" id="payment-installment" name="payment_method" value="installment">
                                <label for="payment-installment" class="payment-method-label">
                                    <div class="payment-method-name">INSTALLMENT</div>
                                </label>
                            </div>
                        </div>

                        <!-- Card Details (shown for card payment) -->
                        <div class="payment-details" id="cardDetails" style="display: block;">
                            <div class="form-group">
                                <label>Cardholder Name</label>
                                <input type="text" name="cardholder_name" placeholder="John Doe">
                            </div>

                            <div class="form-group">
                                <label>Card Number</label>
                                <input type="text" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19">
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Expiry Date</label>
                                    <input type="text" name="card_expiry" placeholder="MM/YY">
                                </div>
                                <div class="form-group">
                                    <label>CVV</label>
                                    <input type="text" name="card_cvv" placeholder="123" maxlength="4">
                                </div>
                            </div>
                        </div>

                        <!-- GCash Details -->
                        <div class="payment-details" id="gcashDetails" style="display: none;">
                            <div class="form-group">
                                <label>GCash Number</label>
                                <input type="tel" name="gcash_number" placeholder="09XX XXX XXXX">
                            </div>
                            <p style="font-size: 12px; color: #666;">You'll receive payment confirmation at your GCash number.</p>
                        </div>

                        <!-- PayPal Details -->
                        <div class="payment-details" id="paypalDetails" style="display: none;">
                            <p style="font-size: 12px; color: #666;">You'll be redirected to PayPal to complete your payment securely.</p>
                        </div>

                        <!-- Bank Transfer Details -->
                        <div class="payment-details" id="bankDetails" style="display: none;">
                            <p style="font-size: 12px; color: #666; margin-bottom: 10px;"><strong>Bank Transfer Details:</strong></p>
                            <p style="font-size: 12px; color: #666;">Account Name: Art Connect Platform</p>
                            <p style="font-size: 12px; color: #666;">Account Number: 12345678901</p>
                            <p style="font-size: 12px; color: #666;">Bank: Metrobank</p>
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <!-- Order Notes -->
                    <div class="checkout-section">
                        <h2 class="checkout-section-title">
                            <span class="section-step">3</span>
                            Order Notes (Optional)
                        </h2>

                        <div class="form-group">
                            <label>Special Requests</label>
                            <textarea name="notes" placeholder="Any special instructions for the seller or delivery?" rows="4"></textarea>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="checkout-section">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 13px;">
                            <input type="checkbox" name="terms" required>
                            <span>I agree to the <a href="#" style="color: #667eea; text-decoration: none;">Terms & Conditions</a> and <a href="#" style="color: #667eea; text-decoration: none;">Privacy Policy</a></span>
                        </label>
                    </div>

                    <!-- Action Buttons -->
                    <div class="checkout-buttons">
                        <button type="submit" class="btn-place-order" id="placeOrderBtn">🛍️ Place Order</button>
                        <a href="{{ route('cart.index') }}" class="btn-back" style="display: block; text-align: center; text-decoration: none;">Back to Cart</a>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <div class="summary-title">Order Summary</div>

                <div class="summary-items">
                    @php
                        // Show items from the order being checked out
                        $orderItems = $order->items()->with('artwork')->get();
                    @endphp

                    @forelse($orderItems as $item)
                    <div class="summary-item">
                        <div class="item-name">{{ Str::limit($item->artwork->title, 25) }} (x{{ $item->quantity }})</div>
                        <div class="item-price">₱{{ number_format($item->price * $item->quantity, 0) }}</div>
                    </div>
                    @empty
                    <div class="summary-item">
                        <div class="item-name">No items in order</div>
                    </div>
                    @endforelse
                </div>

                <div class="summary-divider"></div>

                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span class="summary-row-value" id="subtotalAmount">₱0.00</span>
                </div>

                <div class="summary-row">
                    <span>Shipping Fee:</span>
                    <span class="summary-row-value">₱50.00</span>
                </div>

                <div class="summary-row">
                    <span>Tax (5%):</span>
                    <span class="summary-row-value" id="taxAmount">₱0.00</span>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-total">
                    <span>Total:</span>
                    <span id="totalAmount">₱0.00</span>
                </div>

                <!-- Trust Badges -->
                <div class="trust-badges">
                    <div>
                        <div>🔒</div>
                        <div class="badge-title">Secure</div>
                    </div>
                    <div>
                        <div>✓</div>
                        <div class="badge-title">Verified</div>
                    </div>
                    <div>
                        <div>🚚</div>
                        <div class="badge-title">Tracked</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Payment method toggle
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // Hide all payment details
        document.getElementById('cardDetails').style.display = 'none';
        document.getElementById('gcashDetails').style.display = 'none';
        document.getElementById('paypalDetails').style.display = 'none';
        document.getElementById('bankDetails').style.display = 'none';

        // Show selected payment details
        if (this.value === 'credit_card' || this.value === 'debit_card') {
            document.getElementById('cardDetails').style.display = 'block';
        } else if (this.value === 'gcash') {
            document.getElementById('gcashDetails').style.display = 'block';
        } else if (this.value === 'paypal') {
            document.getElementById('paypalDetails').style.display = 'block';
        } else if (this.value === 'bank_transfer') {
            document.getElementById('bankDetails').style.display = 'block';
        }

        // Auto-submit when payment method is selected
        handlePaymentMethodSelection(this.value);
    });
});

// Handle payment method selection - redirect immediately
function handlePaymentMethodSelection(paymentMethod) {
    setTimeout(function() {
        if (paymentMethod === 'gcash') {
            // Redirect to GCash payment page
            console.log('Redirecting to GCash...');
            const orderId = document.querySelector('input[name="order_id"]').value;
            window.location.href = '/payment/gcash/process/' + orderId;
        } else {
            // For card, bank, and other methods, submit the form
            console.log('Submitting order for payment method: ' + paymentMethod);
            document.getElementById('checkoutForm').submit();
        }
    }, 300); // Small delay to ensure UI update
}

// Calculate totals
function calculateTotals() {
    // For now using hardcoded values - in production this would come from server
    const subtotal = 8500; // Example amount
    const shipping = 50;
    const tax = subtotal * 0.05;
    const total = subtotal + shipping + tax;

    document.getElementById('subtotalAmount').textContent = '₱' + subtotal.toFixed(2);
    document.getElementById('taxAmount').textContent = '₱' + tax.toFixed(2);
    document.getElementById('totalAmount').textContent = '₱' + total.toFixed(2);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', calculateTotals);

// Form submission - Handle manual submission
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    
    // If GCash is selected and form is submitted manually, redirect
    if (paymentMethod === 'gcash') {
        e.preventDefault();
        console.log('Redirecting to GCash payment page...');
        const orderId = document.querySelector('input[name="order_id"]').value;
        window.location.href = '/payment/gcash/process/' + orderId;
        return false;
    }
    
    // For other payment methods, disable button and proceed
    const btn = document.getElementById('placeOrderBtn');
    btn.disabled = true;
    btn.textContent = '⏳ Processing...';
});
</script>
@endsection
