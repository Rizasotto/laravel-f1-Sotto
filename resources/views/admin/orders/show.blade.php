@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.orders') }}" class="text-emerald-600 hover:text-emerald-700 text-sm">← Back to Orders</a>
        <h1 class="text-3xl font-bold text-gray-800 mt-2">Order #{{ $order->order_number }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Order Information</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-500 text-sm">Buyer</p>
                        <p class="font-semibold text-gray-800">{{ $order->buyer->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Status</p>
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-sm font-semibold">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Order Date</p>
                        <p class="font-semibold text-gray-800">{{ $order->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Payment Status</p>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Order Items</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-emerald-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Artwork</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Artist</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Quantity</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Price</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->orderItems as $item)
                            <tr class="border-b border-gray-100">
                                <td class="px-4 py-3 text-sm text-gray-800">{{ $item->artwork->title }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $item->artist->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-800">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-sm text-gray-800">₱{{ number_format($item->price, 2) }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-800">₱{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">No items in this order</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div>
            <div class="bg-white rounded-lg shadow p-6 sticky top-24">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Order Summary</h3>
                
                <div class="space-y-3 mb-6 pb-6 border-b border-gray-200">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold text-gray-800">₱{{ number_format($order->subtotal ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-semibold text-gray-800">₱{{ number_format($order->shipping_amount ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tax</span>
                        <span class="font-semibold text-gray-800">₱{{ number_format($order->tax_amount ?? 0, 2) }}</span>
                    </div>
                </div>

                <div class="flex justify-between mb-6">
                    <span class="text-lg font-bold text-gray-800">Total</span>
                    <span class="text-lg font-bold text-emerald-600">₱{{ number_format($order->total_amount, 2) }}</span>
                </div>

                <a href="{{ route('admin.orders') }}" class="block w-full bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-center hover:bg-gray-300 transition">
                    Back to Orders
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
