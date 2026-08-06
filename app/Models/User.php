<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get user's cart
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * Get user's orders (as buyer)
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    /**
     * Get user's artworks
     */
    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }

    /**
     * Get orders for this artist's artworks
     */
    public function orders_as_artist()
    {
        return Order::whereHas('items', function ($query) {
            $query->whereHas('artwork', function ($q) {
                $q->where('user_id', $this->id);
            });
        });
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is artist
     */
    public function isArtist()
    {
        return $this->role === 'artist';
    }

    /**
     * Check if user is buyer
     */
    public function isBuyer()
    {
        return $this->role === 'buyer';
    }

    /**
     * Scope for admin users
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope for artist users
     */
    public function scopeArtists($query)
    {
        return $query->where('role', 'artist');
    }

    /**
     * Scope for buyer users
     */
    public function scopeBuyers($query)
    {
        return $query->where('role', 'buyer');
    }
}