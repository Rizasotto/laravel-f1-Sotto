@extends('layouts.app')

@section('title', 'Order Details')

@section('extra-styles')
<style>
    .order-detail-container {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 30px;
        margin-bottom: 30px;
    }

    .order-detail {
        background: white;
        border-radius: 4px;
        padding: 30px;
    }

    .order-status-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #eee;
    }

    .order-timeline {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        position: relative;
    }

    .order-timeline::before {
        content: '';
        position: absolute;
        top: 15px;
        left: 50px;
        right: 50px;
        height: 2px;
        background-color: #ddd;
        z-index: 0;
    }

    .timeline-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        z-index: 1;
        position: relative;
    }

    .timeline-step.completed .timeline-dot {
        background-color: #28a745;
        color: white;
    }

    .timeline-step.pending .timeline-dot {
        background-color: #ddd;
    }

    .timeline-dot {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .timeline-label {
        white-space: nowrap;
        font-size: 12px;
        text-align: center;
    }

    .timeline-date {
        font-size: 11px;
        color: #999;
        margin-top: 5px;
    }

    .section-title {
        font-size: 18px;
        font-weight: bold;
        margin-top: 30px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    .section-title:first-child {
        margin-top: 0;
    }

    .info-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .info-item {
        font-size: 14px;
    }

    .info-label {
        color: #999;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .info-value {
        font-weight: 600;
    }

    .order-items-list {
        margin-top: 20px;
    }

    .order-item {
        display: grid;
        grid-template-columns: 100px 1fr 100px;
        gap: 20px;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-item-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 4px;
    }

    .order-item-info h4 {
        margin-bottom: 5px;
        font-size: 14px;
    }

    .order-item-info p {
        font-size: 12px;
        color: #999;
    }

    .order-summary-card {
        background: white;
        border-radius: 4px;
        padding: 20px;
        height: fit-content;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #eee;
    }

    .order-summary-card h3 {
        margin: 0 0 20px 0;
        font-size: 18px;
        font-weight: 700;
        color: #333;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 15px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        font-size: 14px;
        color: #666;
        padding-bottom: 12px;
        border-bottom: 1px solid #f0f0f0;
    }

    .summary-item span:last-child {
        font-weight: 600;
        color: #333;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        padding: 15px 0;
        border-top: 2px solid #eee;
        border-bottom: 2px solid #eee;
        font-size: 18px;
        font-weight: 700;
        color: #10b981;
    }

    .summary-total span:last-child {
        color: #10b981;
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 20px;
    }

    .action-buttons form {
        width: 100%;
    }

    .action-buttons a,
    .action-buttons button {
        width: 100%;
        padding: 11px 16px;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        font-size: 14px;
        text-align: center;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .action-buttons .btn-success {
        background-color: #10b981;
        color: white;
    }

    .action-buttons .btn-success:hover {
        background-color: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .action-buttons .btn-warning {
        background-color: #f59e0b;
        color: white;
    }

    .action-buttons .btn-warning:hover {
        background-color: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .action-buttons .btn-danger {
        background-color: #ef4444;
        color: white;
    }

    .action-buttons .btn-danger:hover {
        background-color: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .action-buttons .btn-secondary {
        background-color: #6b7280;
        color: white;
    }

    .action-buttons .btn-secondary:hover {
        background-color: #4b5563;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
    }

    .badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .badge-paid {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .badge-confirmed {
        background-color: #cfe2ff;
        color: #084298;
    }

    .badge-shipped {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .badge-delivered {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    @media (max-width: 768px) {
        .order-detail-container {
            grid-template-columns: 1fr;
        }

        .info-group {
            grid-template-columns: 1fr;
        }

        .order-item {
            grid-template-columns: 80px 1fr;
        }

        .order-item-image {
            width: 80px;
            height: 80px;
        }

        .order-timeline {
            flex-direction: column;
            gap: 20px;
        }

        .order-timeline::before {
            left: 15px;
            top: 0;
            right: auto;
            width: 2px;
            height: calc(100% - 40px);
        }
    }
</style>
@endsection

@section('content')
<div class="order-detail-container">
    <div class="order-detail">
        <div class="order-status-header">
            <div>
                <h2>{{ $order->order_number }}</h2>
                <p style="color: #999; margin-top: 5px;">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
            </div>
            <span class="badge badge-{{ $order->status }}">{{ strtoupper($order->status) }}</span>
        </div>

        <div class="section-title">Order Status</div>
        <div class="order-timeline">
            <div class="timeline-step @if(in_array($order->status, ['confirmed', 'shipped', 'delivered'])) completed @endif">
                <div class="timeline-dot">✓</div>
                <div class="timeline-label">Confirmed</div>
                <div class="timeline-date">@if($order->confirmed_at) {{ $order->confirmed_at->format('M d') }} @endif</div>
            </div>
            <div class="timeline-step @if(in_array($order->status, ['shipped', 'delivered'])) completed @endif">
                <div class="timeline-dot">📦</div>
                <div class="timeline-label">Shipped</div>
                <div class="timeline-date">@if($order->shipped_at) {{ $order->shipped_at->format('M d') }} @endif</div>
            </div>
            <div class="timeline-step @if($order->status === 'delivered') completed @endif">
                <div class="timeline-dot">🚚</div>
                <div class="timeline-label">Delivered</div>
                <div class="timeline-date">@if($order->delivered_at) {{ $order->delivered_at->format('M d') }} @endif</div>
            </div>
        </div>

        <div class="section-title">Shipping Information</div>
        <div class="info-group">
            <div class="info-item">
                <div class="info-label">Recipient</div>
                <div class="info-value">{{ $order->buyer->name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Phone</div>
                <div class="info-value">{{ $order->phone }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $order->buyer->email }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Payment Status</div>
                <div class="info-value"><span class="badge badge-{{ $order->payment_status }}">{{ strtoupper($order->payment_status) }}</span></div>
            </div>
        </div>

        <div style="background-color: #f9f9f9; padding: 15px; border-radius: 4px; margin-top: 20px;">
            <div class="info-label">Shipping Address</div>
            <div style="line-height: 1.6; margin-top: 10px;">{{ $order->shipping_address }}</div>
        </div>

        <div class="section-title">Order Items</div>
        <div class="order-items-list">
            @foreach($order->items as $item)
            <div class="order-item">
                <img src="{{ str_contains($item->artwork->image_path, 'http') ? $item->artwork->image_path : (str_contains($item->artwork->image_path, 'artworks/') ? asset('storage/' . $item->artwork->image_path) : asset('storage/artworks/' . $item->artwork->image_path)) }}" alt="{{ $item->artwork->title }}" class="order-item-image" onerror="this.src='https://picsum.photos/seed/{{ $item->artwork->id }}/400/300'">
                
                <div class="order-item-info">
                    <h4>{{ $item->artwork->title }}</h4>
                    <p>by {{ $item->artist->name }}</p>
                    <p>Qty: {{ $item->quantity }} × ₱{{ number_format($item->price, 2) }}</p>
                </div>

                <div style="text-align: right;">
                    <div style="font-size: 12px; color: #999;">Subtotal</div>
                    <div style="font-size: 18px; font-weight: bold; color: #10b981;">₱{{ number_format($item->subtotal, 2) }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Sidebar -->
    <div class="order-summary-card">
        <h3 style="margin-bottom: 20px;">Order Summary</h3>

        <div class="summary-item">
            <span>Subtotal:</span>
            <span>₱{{ number_format($order->total_amount, 2) }}</span>
        </div>
        <div class="summary-item">
            <span>Shipping:</span>
            <span>₱50.00</span>
        </div>
        <div class="summary-item">
            <span>Tax (5%):</span>
            <span>₱{{ number_format($order->total_amount * 0.05, 2) }}</span>
        </div>
        <div class="summary-total">
            <span>Total:</span>
            <span>₱{{ number_format($order->total_amount + 50 + ($order->total_amount * 0.05), 2) }}</span>
        </div>

        <div class="action-buttons">
            @if($order->status === 'pending' && $order->buyer_id === auth()->id())
            <a href="{{ route('payment.gcash.process', $order) }}" class="btn btn-warning">📱 Proceed to Payment</a>
            @endif

            @if($order->status === 'pending' && $order->buyer_id === auth()->id())
            <form method="POST" action="{{ route('order.confirm', $order) }}" style="width: 100%;">
                @csrf
                <button type="submit" class="btn btn-success" style="width: 100%;">✓ Confirm Order</button>
            </form>
            @endif

            @if($order->status === 'pending' && $order->buyer_id === auth()->id())
            <form method="POST" action="{{ route('order.cancel', $order) }}" style="width: 100%;">
                @csrf
                <button type="submit" class="btn btn-danger" style="width: 100%;">✗ Cancel Order</button>
            </form>
            @endif

            <a href="{{ route('order.index') }}" class="btn btn-secondary">← Back to Orders</a>
        </div>
    </div>
</div>
@endsection
