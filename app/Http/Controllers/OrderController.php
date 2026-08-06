<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Artwork;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $statuses = ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'];
        $currentStatus = $request->query('status');
        
        $query = auth()->user()->orders();
        
        if ($currentStatus && in_array($currentStatus, $statuses)) {
            $query->where('status', $currentStatus);
        } else {
            $currentStatus = null;
        }
        
        $orders = $query->latest()->paginate(10);
        return view('orders.index', compact('orders', 'statuses', 'currentStatus'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $orderItems = $order->items()->with('artwork')->get();
        
        return view('orders.show', compact('order', 'orderItems'));
    }

    public function checkout(Order $order)
    {
        $this->authorize('update', $order);
        return view('checkout.index', compact('order'));
    }

    public function buyNow(Request $request)
    {
        $artworkId = $request->input('artwork_id');
        $quantity = $request->input('quantity', 1);

        $artwork = Artwork::findOrFail($artworkId);

        // Verify stock availability
        if ($artwork->stock < $quantity) {
            return redirect()->back()->with('error', 'Insufficient stock available!');
        }

        $totalAmount = $artwork->price * $quantity;

        $order = auth()->user()->orders()->create([
            'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999),
            'status' => 'pending',
            'total_amount' => $totalAmount,
            'payment_status' => 'pending',
        ]);

        $order->items()->create([
            'artwork_id' => $artwork->id,
            'artist_id' => $artwork->user_id,
            'quantity' => $quantity,
            'price' => $artwork->price,
            'subtotal' => $artwork->price * $quantity,
        ]);

        return redirect()->route('order.checkout', $order)->with('success', 'Ready for checkout! Please complete your purchase.');
    }

    public function createFromCart()
    {
        $cart = auth()->user()->cart;
        
        if (!$cart || $cart->items()->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        $totalAmount = $cart->items()->with('artwork')->get()->sum(fn($item) => $item->artwork->price * $item->quantity);
        
        $order = auth()->user()->orders()->create([
            'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999),
            'status' => 'pending',
            'total_amount' => $totalAmount,
            'payment_status' => 'pending',
        ]);

        foreach ($cart->items as $item) {
            $subtotal = $item->artwork->price * $item->quantity;
            $order->items()->create([
                'artwork_id' => $item->artwork_id,
                'artist_id' => $item->artwork->user_id,
                'quantity' => $item->quantity,
                'price' => $item->artwork->price,
                'subtotal' => $subtotal,
            ]);
        }

        $cart->items()->delete();

        return redirect()->route('order.checkout', $order)->with('success', 'Order created! Please proceed to checkout.');
    }

    public function confirm(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        
        $validated = $request->validate([
            'payment_method' => 'required|string',
            'address' => 'required|string',
        ]);

        $order->update([
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'shipping_address' => $validated['address'],
        ]);

        return redirect()->route('order.show', $order)->with('success', 'Order confirmed!');
    }

    public function cancel(Order $order)
    {
        $this->authorize('update', $order);
        
        $order->update(['status' => 'cancelled']);
        return response()->json(['success' => true]);
    }

    public function ship(Order $order)
    {
        $this->authorize('update', $order);
        
        $order->update(['status' => 'shipped', 'shipped_at' => now()]);
        return response()->json(['success' => true]);
    }

    public function deliver(Order $order)
    {
        $this->authorize('update', $order);
        
        $order->update(['status' => 'delivered', 'delivered_at' => now()]);
        return response()->json(['success' => true]);
    }

    public function getArtistOrders()
    {
        $orders = Order::whereHas('items', function ($query) {
            $query->whereHas('artwork', function ($q) {
                $q->where('user_id', auth()->id());
            });
        })->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }
}
