@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('extra-styles')
<style>
    /* Cart Wrapper */
    .cart-wrapper {
        background: #f8f9fa;
        min-height: calc(100vh - 100px);
        padding: 30px 0;
    }

    .cart-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        margin-bottom: 30px;
        border-radius: 8px;
    }

    .cart-header h1 {
        font-size: 32px;
        margin-bottom: 5px;
    }

    /* Cart Layout */
    .cart-container {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 30px;
        margin-bottom: 40px;
    }

    /* Cart Items Section */
    .cart-items {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .cart-items-title {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .cart-item {
        display: grid;
        grid-template-columns: 120px 1fr auto;
        gap: 20px;
        align-items: center;
        padding: 20px;
        border: 1px solid #eee;
        border-radius: 8px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .cart-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .cart-item-image {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
    }

    .cart-item-info {
        flex: 1;
    }

    .cart-item-info h3 {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .cart-item-artist {
        font-size: 13px;
        color: #666;
        margin-bottom: 8px;
    }

    .cart-item-price {
        font-size: 16px;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 10px;
    }

    .cart-item-quantity-section {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quantity-btn {
        width: 32px;
        height: 32px;
        border: 1px solid #ddd;
        background: white;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.2s ease;
    }

    .quantity-btn:hover {
        background: #f0f0f0;
        border-color: #667eea;
    }

    .quantity-input {
        width: 50px;
        padding: 6px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-align: center;
        font-weight: 600;
    }

    .cart-item-subtotal {
        text-align: right;
    }

    .subtotal-label {
        font-size: 12px;
        color: #999;
        margin-bottom: 5px;
    }

    .subtotal-amount {
        font-size: 18px;
        font-weight: bold;
        color: #10b981;
    }

    .cart-item-remove {
        text-align: center;
    }

    .btn-remove {
        padding: 8px 12px;
        background: #f8d7da;
        color: #721c24;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 12px;
        transition: all 0.2s ease;
    }

    .btn-remove:hover {
        background: #f5c6cb;
    }

    /* Cart Summary Sidebar */
    .cart-summary {
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

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
        color: #666;
    }

    .summary-item-value {
        font-weight: 600;
        color: #333;
    }

    .summary-divider {
        height: 1px;
        background: #eee;
        margin: 15px 0;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        font-size: 18px;
        font-weight: bold;
        color: #667eea;
    }

    .promo-code-section {
        margin-bottom: 20px;
    }

    .promo-code-section label {
        font-size: 12px;
        font-weight: 600;
        color: #333;
        display: block;
        margin-bottom: 8px;
    }

    .promo-code-input {
        display: flex;
        gap: 8px;
    }

    .promo-code-input input {
        flex: 1;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 12px;
    }

    .promo-code-input button {
        padding: 8px 12px;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 12px;
        transition: all 0.2s ease;
    }

    .promo-code-input button:hover {
        background: #764ba2;
    }

    .cart-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-action {
        padding: 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
        text-decoration: none;
        text-align: center;
    }

    .btn-checkout {
        background: #10b981;
        color: white;
    }

    .btn-checkout:hover {
        background: #059669;
        transform: translateY(-2px);
    }

    .btn-continue {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }

    .btn-continue:hover {
        background: #f0f0f0;
    }

    .btn-clear {
        background: #f8d7da;
        color: #721c24;
    }

    .btn-clear:hover {
        background: #f5c6cb;
    }

    /* Empty Cart */
    .empty-cart-container {
        background: white;
        border-radius: 12px;
        padding: 60px 40px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .empty-cart-icon {
        font-size: 64px;
        margin-bottom: 20px;
    }

    .empty-cart-title {
        font-size: 20px;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .empty-cart-text {
        color: #666;
        margin-bottom: 25px;
        font-size: 14px;
    }

    /* Responsive */
    @media (max-width: 968px) {
        .cart-container {
            grid-template-columns: 1fr;
        }

        .cart-summary {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .cart-item {
            grid-template-columns: 80px 1fr;
            gap: 15px;
        }

        .cart-item-image {
            width: 80px;
            height: 80px;
        }

        .cart-item-subtotal {
            grid-column: 2;
            text-align: left;
            margin-top: 10px;
        }

        .cart-item-remove {
            grid-column: 2;
            text-align: left;
            margin-top: 10px;
        }
    }
</style>
@endsection

@section('content')
<div class="cart-wrapper">
    <div class="cart-header">
        <h1>🛒 Shopping Cart</h1>
        <p>Review and manage your artworks before checkout</p>
    </div>

    <div class="max-w-7xl mx-auto px-4">
        <div class="cart-container">
            <!-- Cart Items -->
            <div class="cart-items">
                <div class="cart-items-title">
                    Your Items ({{ $items->count() ?? 0 }})
                </div>

                @if($items && $items->count() > 0)
                    @foreach($items as $item)
                    <div class="cart-item">
                        <img src="{{ str_contains($item->artwork->image_path, 'http') ? $item->artwork->image_path : (str_contains($item->artwork->image_path, 'artworks/') ? asset('storage/' . $item->artwork->image_path) : asset('storage/artworks/' . $item->artwork->image_path)) }}" alt="{{ $item->artwork->title }}" class="cart-item-image" onerror="this.src='https://picsum.photos/seed/{{ $item->artwork->id }}/400/300'">
                        
                        <div class="cart-item-info">
                            <h3>{{ $item->artwork->title }}</h3>
                            <div class="cart-item-artist">by {{ $item->artwork->artist->name }}</div>
                            <div class="cart-item-price">₱{{ number_format($item->artwork->price, 2) }}</div>
                        </div>

                        <div class="cart-item-subtotal">
                            <div class="subtotal-label">Subtotal</div>
                            <div class="subtotal-amount">₱{{ number_format($item->artwork->price * ($item->quantity ?? 1), 2) }}</div>
                        </div>

                        <div class="cart-item-remove">
                            <form method="POST" action="{{ route('cart.remove', $item->id) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-remove">Remove</button>
                            </form>
                        </div>
                    </div>
                    @endforeach

                    <!-- Cart Summary -->
                    <div class="cart-summary">
                        <div class="summary-title">Order Summary</div>

                        <div class="summary-item">
                            <span>Subtotal:</span>
                            <span class="summary-item-value">₱{{ number_format($total ?? 0, 2) }}</span>
                        </div>

                        <div class="summary-item">
                            <span>Shipping Fee:</span>
                            <span class="summary-item-value">₱50.00</span>
                        </div>

                        <div class="summary-item">
                            <span>Tax (5%):</span>
                            <span class="summary-item-value">₱{{ number_format(($total ?? 0) * 0.05, 2) }}</span>
                        </div>

                        <div class="summary-divider"></div>

                        <div class="summary-total">
                            <span>Total:</span>
                            <span>₱{{ number_format(($total ?? 0) + 50 + (($total ?? 0) * 0.05), 2) }}</span>
                        </div>

                        <div class="promo-code-section">
                            <label>Have a promo code?</label>
                            <div class="promo-code-input">
                                <input type="text" placeholder="Enter code">
                                <button>Apply</button>
                            </div>
                        </div>

                        <div class="cart-actions">
                            <a href="{{ route('checkout') }}" class="btn-action btn-checkout">🛍️ Proceed to Checkout</a>
                            <a href="{{ route('marketplace.index') }}" class="btn-action btn-continue">Continue Shopping</a>
                            <form method="POST" action="{{ route('cart.clear') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn-action btn-clear" style="width: 100%;">Clear Cart</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="empty-cart-container">
                        <div class="empty-cart-icon">🛒</div>
                        <h2 class="empty-cart-title">Your cart is empty</h2>
                        <p class="empty-cart-text">No artworks added to your cart yet. Start exploring and add your favorite pieces!</p>
                        <a href="{{ route('marketplace.index') }}" class="btn-action btn-checkout">Browse Marketplace</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
