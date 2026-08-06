<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;

class ArtistDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'artworks' => $user->artworks()->count(),
            'sales' => $user->orders_as_artist()->count(),
            'revenue' => 0,
            'views' => $user->artworks()->sum('views'),
        ];

        // Get recent order items for this artist's artworks
        $recentOrders = OrderItem::whereHas('artwork', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with(['artwork', 'order.buyer'])
            ->latest()
            ->take(5)
            ->get();

        $recentArtworks = $user->artworks()
            ->latest()
            ->take(6)
            ->get();

        return view('artist.dashboard', compact('stats', 'recentOrders', 'recentArtworks', 'user'));
    }
}
