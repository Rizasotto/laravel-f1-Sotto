<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artwork extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image_path',
        'price',
        'category',
        'status',
        'stock',
        'views',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'views' => 'integer',
    ];

    /**
     * Get the artist who owns this artwork
     */
    public function artist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the cart items for this artwork
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the order items for this artwork
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope for active artworks
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }
}
