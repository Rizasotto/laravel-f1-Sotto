@extends('layouts.app')

@section('title', 'My Orders')

@section('extra-styles')
<style>
    .orders-container {
        background: white;
        border-radius: 4px;
        padding: 20px;
    }

    .orders-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .filter-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .filter-buttons a {
        padding: 8px 16px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        color: #333;
        font-size: 14px;
        transition: all 0.3s;
    }

    .filter-buttons a:hover,
    .filter-buttons a.active {
        background-color: #10b981;
        color: white;
        border-color: #10b981;
    }

    .order-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .order-card {
        border: 1px solid #eee;
        border-radius: 4px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .order-card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .order-header {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 20px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .order-info {
        font-size: 14px;
    }

    .order-info-label {
        color: #999;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .order-number {
        font-weight: bold;
        font-size: 14px;
    }

    .order-date {
        color: #666;
        font-size: 13px;
    }

    .order-amount {
        text-align: right;
        font-size: 18px;
        font-weight: bold;
        color: #10b981;
    }

    .order-items {
        margin-bottom: 15px;
    }

    .order-item-preview {
        display: flex;
        gap: 10px;
        align-items: center;
        padding: 10px 0;
        font-size: 13px;
    }

    .order-item-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
    }

    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .order-status {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-confirmed {
        background-color: #cfe2ff;
        color: #084298;
    }

    .status-shipped {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .status-delivered {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #842029;
    }

    .empty-orders {
        text-align: center;
        padding: 40px;
    }

    .empty-orders p {
        color: #999;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .order-header {
            grid-template-columns: 1fr;
        }

        .order-amount {
            text-align: left;
        }

        .order-footer {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
    }
</style>
@endsection

@section('content')
<div class="orders-container">
    <div class="orders-header">
        <h2>My Orders</h2>
        <div class="filter-buttons">
            <a href="{{ route('order.index') }}" @class(['active' => !$currentStatus])>All</a>
            @foreach($statuses as $status)
            <a href="?status={{ $status }}" @class(['active' => $currentStatus === $status])>{{ ucfirst($status) }}</a>
            @endforeach
        </div>
    </div>

    @if($orders->count() > 0)
        <div class="order-list">
            @foreach($orders as $order)
            <a href="{{ route('order.show', $order) }}" style="text-decoration: none; color: inherit;">
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <div class="order-info-label">Order Number</div>
                            <div class="order-number">{{ $order->order_number }}</div>
                            <div class="order-date">{{ $order->created_at->format('M d, Y') }}</div>
                        </div>
                        <div class="order-info">
                            <div class="order-info-label">Status</div>
                            <div class="order-status status-{{ $order->status }}">
                                {{ strtoupper($order->status) }}
                            </div>
                        </div>
                        <div class="order-info">
                            <div class="order-info-label">Total Amount</div>
                            <div class="order-amount">₱{{ number_format($order->total_amount, 2) }}</div>
                        </div>
                    </div>

                    <div class="order-items">
                        @foreach($order->items->take(2) as $item)
                        <div class="order-item-preview">
                            <img src="{{ str_contains($item->artwork->image_path, 'http') ? $item->artwork->image_path : (str_contains($item->artwork->image_path, 'artworks/') ? asset('storage/' . $item->artwork->image_path) : asset('storage/artworks/' . $item->artwork->image_path)) }}" alt="{{ $item->artwork->title }}" class="order-item-image" onerror="this.src='https://picsum.photos/seed/{{ $item->artwork->id }}/400/300'">
                            <div>
                                <div>{{ Str::limit($item->artwork->title, 30) }}</div>
                                <div style="color: #999;">Qty: {{ $item->quantity }}</div>
                            </div>
                        </div>
                        @endforeach
                        @if($order->items->count() > 2)
                        <div style="color: #999; font-size: 12px; padding-top: 10px;">
                            +{{ $order->items->count() - 2 }} more item(s)
                        </div>
                        @endif
                    </div>

                    <div class="order-footer">
                        <span>{{ count($order->items) }} item(s)</span>
                        <span class="btn btn-secondary">View Details →</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        {{ $orders->links() }}
    @else
        <div class="empty-orders">
            <p style="font-size: 18px; margin-bottom: 20px;">📦 No orders yet</p>
            <p>Start shopping to place your first order!</p>
            <a href="{{ route('marketplace.index') }}" class="btn btn-primary">Browse Artworks</a>
        </div>
    @endif
</div>
@endsection
