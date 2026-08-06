@extends('layouts.app')

@section('title', 'Checkout')

@section('extra-styles')
<style>
    .checkout-container {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 30px;
        max-width: 900px;
    }

    .checkout-form {
        background: white;
        padding: 30px;
        border-radius: 4px;
    }

    .checkout-form h2 {
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 14px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        font-family: inherit;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .checkout-summary {
        background: white;
        padding: 20px;
        border-radius: 4px;
        height: fit-content;
    }

    .checkout-summary h3 {
        margin-bottom: 20px;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-summary {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #eee;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .summary-row.total {
        font-size: 18px;
        font-weight: bold;
        color: #ee4d2b;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .action-buttons .btn {
        flex: 1;
        text-align: center;
        padding: 12px;
    }

    @media (max-width: 768px) {
        .checkout-container {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<h1>Checkout</h1>

<div class="checkout-container">
    <form method="POST" action="{{ route('order.create_from_cart') }}" class="checkout-form">
        @csrf
        
        <h2>Shipping Information</h2>

        <div class="form-group">
            <label>Name</label>
            <input type="text" value="{{ auth()->user()->name }}" disabled style="background-color: #f5f5f5;">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" value="{{ auth()->user()->email }}" disabled style="background-color: #f5f5f5;">
        </div>

        <div class="form-group">
            <label for="phone">Phone Number *</label>
            <input type="text" id="phone" name="phone" required value="{{ old('phone', auth()->user()->phone) }}">
            @error('phone')
                <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="shipping_address">Shipping Address *</label>
            <textarea id="shipping_address" name="shipping_address" required>{{ old('shipping_address', auth()->user()->address) }}</textarea>
            @error('shipping_address')
                <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="background-color: #f0f0f0; padding: 15px; border-radius: 4px; margin-top: 20px;">
            <strong>Payment Method:</strong> Cash on Delivery (COD)
            <p style="font-size: 12px; color: #666; margin-top: 10px;">Pay upon delivery</p>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px; padding: 12px;">Place Order</button>
    </form>

    <div class="checkout-summary">
        <h3>Order Summary</h3>

        @foreach($order->items as $item)
        <div class="order-item">
            <div>
                <div style="font-weight: 600; margin-bottom: 5px;">{{ $item->artwork->title }}</div>
                <div style="color: #999; font-size: 12px;">Qty: {{ $item->quantity }}</div>
            </div>
            <div>₱{{ number_format($item->subtotal, 2) }}</div>
        </div>
        @endforeach

        <div class="order-summary">
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>₱{{ number_format($order->total_amount, 2) }}</span>
            </div>
            <div class="summary-row">
                <span>Shipping:</span>
                <span>₱50.00</span>
            </div>
            <div class="summary-row">
                <span>Tax (5%):</span>
                <span>₱{{ number_format($order->total_amount * 0.05, 2) }}</span>
            </div>
            <div class="summary-row total">
                <span>Total:</span>
                <span>₱{{ number_format($order->total_amount + 50 + ($order->total_amount * 0.05), 2) }}</span>
            </div>
        </div>

        <a href="{{ route('cart.index') }}" class="btn btn-secondary" style="width: 100%; margin-top: 20px; text-align: center;">Back to Cart</a>
    </div>
</div>
@endsection
