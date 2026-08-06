<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Artwork;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->cart ?? auth()->user()->cart()->create();
        $items = $cart->items()->with('artwork')->get();
        
        $total = $items->sum(fn($item) => $item->artwork->price * $item->quantity);
        
        return view('cart.index', compact('items', 'total'));
    }

    public function add($artworkId)
    {
        $artwork = Artwork::findOrFail($artworkId);
        $cart = auth()->user()->cart ?? auth()->user()->cart()->create();
        
        $cartItem = $cart->items()->where('artwork_id', $artworkId)->first();
        
        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            $cart->items()->create([
                'artwork_id' => $artworkId,
                'quantity' => 1,
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Added to cart!');
    }

    public function update(Request $request, CartItem $item)
    {
        $this->authorize('update', $item->cart);
        
        $validated = $request->validate(['quantity' => 'required|integer|min:1']);
        $item->update($validated);
        
        return response()->json(['success' => true]);
    }

    public function remove(CartItem $item)
    {
        $this->authorize('delete', $item->cart);
        $item->delete();
        
        return response()->json(['success' => true]);
    }

    public function clear()
    {
        $cart = auth()->user()->cart;
        if ($cart) {
            $cart->items()->delete();
        }
        
        return response()->json(['success' => true]);
    }

    public function getCount()
    {
        $cart = auth()->user()->cart;
        $count = $cart ? $cart->items()->count() : 0;
        
        return response()->json(['count' => $count]);
    }
}
