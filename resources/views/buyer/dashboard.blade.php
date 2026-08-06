@extends('layouts.app')

@section('title', 'Buyer Dashboard')

@section('extra-styles')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 40px;
        border-radius: 4px;
        margin-bottom: 30px;
    }

    .dashboard-header h1 {
        font-size: 32px;
        margin-bottom: 10px;
    }

    .dashboard-header p {
        font-size: 14px;
        opacity: 0.9;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .stat-value {
        font-size: 32px;
        font-weight: bold;
        color: #10b981;
    }

    .stat-label {
        font-size: 14px;
        color: #999;
        margin-top: 8px;
    }

    .section-title {
        font-size: 20px;
        font-weight: bold;
        margin: 30px 0 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eee;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .recent-orders {
        background: white;
        border-radius: 4px;
        padding: 20px;
    }

    .order-card {
        border: 1px solid #eee;
        border-radius: 4px;
        padding: 15px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .order-card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .order-card:last-child {
        margin-bottom: 0;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .order-number {
        font-weight: bold;
        font-size: 14px;
    }

    .order-date {
        font-size: 12px;
        color: #999;
    }

    .order-status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-pending {
        background-color: #fff3cd;
        color: #856404;
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

    .order-items {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 10px;
        padding-top: 10px;
        border-top: 1px solid #eee;
    }

    .order-item-thumb {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
    }

    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 10px;
        border-top: 1px solid #eee;
    }

    .order-total {
        font-weight: bold;
        color: #10b981;
    }

    .empty-state {
        background: white;
        padding: 40px;
        border-radius: 4px;
        text-align: center;
    }

    .empty-state p {
        color: #999;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .order-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-header">
    <h1>Welcome, {{ auth()->user()->name }}!</h1>
    <p>Track your orders and purchases</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $totalOrders }}</div>
        <div class="stat-label">Total Orders</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $pendingOrders }}</div>
        <div class="stat-label">Pending Orders</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $deliveredOrders }}</div>
        <div class="stat-label">Delivered</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">₱{{ number_format($totalSpent, 2) }}</div>
        <div class="stat-label">Total Spent</div>
    </div>
</div>

<div class="section-title">Continue Shopping</div>
<div class="action-buttons">
    <a href="{{ route('marketplace.index') }}" class="btn btn-primary">Browse Artworks</a>
    <a href="{{ route('cart.index') }}" class="btn btn-secondary">View Cart</a>
    <a href="{{ route('order.index') }}" class="btn btn-secondary">View All Orders</a>
</div>

<div class="section-title">Recent Orders</div>

@if($recentOrders->count() > 0)
<div class="recent-orders">
    @foreach($recentOrders as $order)
    <a href="{{ route('order.show', $order) }}" style="text-decoration: none; color: inherit;">
        <div class="order-card">
            <div class="order-header">
                <div>
                    <div class="order-number">{{ $order->order_number }}</div>
                    <div class="order-date">{{ $order->created_at->format('M d, Y') }}</div>
                </div>
                <span class="order-status-badge badge-{{ $order->status }}">{{ strtoupper($order->status) }}</span>
            </div>

            <div class="order-items">
                @foreach($order->items->take(4) as $item)
                <img src="{{ str_contains($item->artwork->image_path, 'http') ? $item->artwork->image_path : (str_contains($item->artwork->image_path, 'artworks/') ? asset('storage/' . $item->artwork->image_path) : asset('storage/artworks/' . $item->artwork->image_path)) }}" alt="{{ $item->artwork->title }}" class="order-item-thumb" title="{{ $item->artwork->title }}" onerror="this.src='https://picsum.photos/seed/{{ $item->artwork->id }}/400/300'">
                @endforeach
                @if($order->items->count() > 4)
                <div style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background-color: #f0f0f0; border-radius: 4px; font-size: 12px; font-weight: bold;">
                    +{{ $order->items->count() - 4 }}
                </div>
                @endif
            </div>

            <div class="order-footer">
                <span>{{ $order->items->count() }} item(s)</span>
                <span class="order-total">₱{{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>
    </a>
    @endforeach
</div>
@else
<div class="empty-state">
    <p style="font-size: 16px; margin-bottom: 20px;">📦 No orders yet</p>
    <p>Start shopping to place your first order!</p>
    <a href="{{ route('marketplace.index') }}" class="btn btn-primary">Browse Artworks</a>
</div>
@endif
@endsection
