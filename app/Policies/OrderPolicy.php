<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine if the user can view the order
     */
    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->buyer_id;
    }

    /**
     * Determine if the user can update the order
     */
    public function update(User $user, Order $order): bool
    {
        return $user->id === $order->buyer_id && $order->status === 'pending';
    }

    /**
     * Determine if the user can delete the order
     */
    public function delete(User $user, Order $order): bool
    {
        return $user->id === $order->buyer_id && in_array($order->status, ['pending', 'cancelled']);
    }

    /**
     * Determine if the user can cancel the order
     */
    public function cancel(User $user, Order $order): bool
    {
        return $user->id === $order->buyer_id && in_array($order->status, ['pending', 'confirmed']);
    }

    /**
     * Determine if the user can ship the order (only artists can ship their items)
     */
    public function ship(User $user, Order $order): bool
    {
        return $order->items()->whereHas('artwork', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->exists();
    }

    /**
     * Determine if the user can deliver the order
     */
    public function deliver(User $user, Order $order): bool
    {
        return $order->items()->whereHas('artwork', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->exists();
    }
}
