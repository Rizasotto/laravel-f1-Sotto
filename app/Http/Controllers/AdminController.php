<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Artwork;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalArtworks = Artwork::count();
        $totalRevenue = Order::where('status', 'delivered')
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalOrders',
            'totalArtworks',
            'totalRevenue'
        ));
    }

    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,artist,buyer'
        ]);

        $user->update(['role' => $validated['role']]);

        return redirect()->route('admin.show_user', $user->id)
            ->with('success', 'User role updated successfully');
    }

    public function orders()
    {
        $orders = Order::with(['buyer', 'orderItems'])
            ->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $order->load(['buyer', 'orderItems.artwork', 'orderItems.artist']);
        return view('admin.orders.show', compact('order'));
    }

    public function artworks()
    {
        $artworks = Artwork::with(['artist'])
            ->paginate(15);
        return view('admin.artworks.index', compact('artworks'));
    }

    public function toggleArtworkStatus(Request $request, Artwork $artwork)
    {
        $artwork->update([
            'status' => $artwork->status === 'active' ? 'inactive' : 'active'
        ]);

        return redirect()->route('admin.artworks')
            ->with('success', 'Artwork status updated');
    }

    public function deleteArtwork(Request $request, Artwork $artwork)
    {
        $artwork->delete();
        return redirect()->route('admin.artworks')
            ->with('success', 'Artwork deleted successfully');
    }
}
