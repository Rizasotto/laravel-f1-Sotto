<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuyerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $totalOrders = $user->orders()->count();
        $totalSpent = $user->orders()->sum('total_amount') ?? 0;
        $pendingOrders = $user->orders()->whereIn('status', ['pending', 'confirmed'])->count();
        $deliveredOrders = $user->orders()->where('status', 'delivered')->count();

        $recentOrders = $user->orders()
            ->latest()
            ->take(5)
            ->get();

        return view('buyer.dashboard', compact('totalOrders', 'totalSpent', 'pendingOrders', 'deliveredOrders', 'recentOrders', 'user'));
    }
}
