@extends('layouts.app')

@section('title', $artwork->title)

@section('extra-styles')
<style>
    .artwork-detail {
        background: white;
        padding: 30px;
        border-radius: 4px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-bottom: 40px;
    }

    .artwork-image {
        width: 100%;
        height: 500px;
        object-fit: cover;
        border-radius: 4px;
        background-color: #f0f0f0;
    }

    .artwork-details h1 {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .artwork-artist {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        font-size: 14px;
        color: #666;
    }

    .artwork-artist a {
        color: #10b981;
        text-decoration: none;
    }

    .artwork-stats {
        display: flex;
        gap: 30px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #ddd;
    }

    .stat {
        text-align: center;
    }

    .stat-value {
        font-size: 20px;
        font-weight: bold;
        color: #10b981;
    }

    .stat-label {
        font-size: 12px;
        color: #999;
    }

    .artwork-description {
        margin: 20px 0;
        line-height: 1.6;
        color: #555;
    }

    .artwork-meta {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .artwork-meta-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        font-size: 14px;
    }

    .artwork-price {
        font-size: 40px;
        font-weight: bold;
        color: #10b981;
        margin: 20px 0;
    }

    .stock-status {
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .stock-status.in-stock {
        background-color: #d4edda;
        color: #155724;
    }

    .stock-status.out-of-stock {
        background-color: #f8d7da;
        color: #721c24;
    }

    .action-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 20px;
    }

    .action-buttons form {
        width: 100%;
    }

    .action-buttons .form-with-input {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .quantity-input {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .action-buttons button {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 14px;
        color: white;
        background-color: #10b981;
    }

    .action-buttons button:hover {
        background-color: #059669;
    }

    .btn-buy-now {
        background-color: #667eea !important;
    }

    .btn-buy-now:hover {
        background-color: #5568d3 !important;
    }

    .related-artworks {
        margin-top: 50px;
    }

    .related-artworks h2 {
        margin-bottom: 20px;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 20px;
    }

    .related-card {
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }

    .related-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }

    .related-info {
        padding: 10px;
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .artwork-detail {
            grid-template-columns: 1fr;
        }

        .artwork-image {
            height: 300px;
        }

        .artwork-stats {
            flex-wrap: wrap;
        }
    }
</style>
@endsection

@section('content')
<div class="artwork-detail">
    <div>
        <img src="{{ str_contains($artwork->image_path, 'http') ? $artwork->image_path : (str_contains($artwork->image_path, 'artworks/') ? asset('storage/' . $artwork->image_path) : asset('storage/artworks/' . $artwork->image_path)) }}" alt="{{ $artwork->title }}" class="artwork-image" onerror="this.src='https://picsum.photos/seed/{{ $artwork->id }}/400/300'">
    </div>

    <div class="artwork-details">
        <h1>{{ $artwork->title }}</h1>

        <div class="artwork-artist">
            📌 by <a href="#">{{ $artwork->artist->name }}</a>
        </div>

        <div class="artwork-stats">
            <div class="stat">
                <div class="stat-value">{{ $artwork->views }}</div>
                <div class="stat-label">Views</div>
            </div>
            <div class="stat">
                <div class="stat-value">{{ $artwork->orderItems()->count() }}</div>
                <div class="stat-label">Sold</div>
            </div>
            <div class="stat">
                <div class="stat-value">⭐ 4.8</div>
                <div class="stat-label">Rating</div>
            </div>
        </div>

        <div class="artwork-description">
            <strong>Description:</strong><br>
            {{ $artwork->description }}
        </div>

        <div class="artwork-meta">
            <div class="artwork-meta-item">
                <span>Category:</span>
                <strong>{{ $artwork->category }}</strong>
            </div>
            <div class="artwork-meta-item">
                <span>Stock:</span>
                <strong>{{ $artwork->stock }} available</strong>
            </div>
            <div class="artwork-meta-item">
                <span>Created:</span>
                <strong>{{ $artwork->created_at->format('M d, Y') }}</strong>
            </div>
        </div>

        <div class="artwork-price">
            ₱{{ number_format($artwork->price, 2) }}
        </div>

        @if($artwork->stock > 0)
            <div class="stock-status in-stock">✓ In Stock - {{ $artwork->stock }} items available</div>
        @else
            <div class="stock-status out-of-stock">✗ Out of Stock</div>
        @endif

        @if($artwork->stock > 0)
            @if(auth()->check())
            <div class="action-buttons">
                <!-- Add to Cart Form -->
                <form method="POST" action="{{ route('cart.add', $artwork) }}" class="form-with-input">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1" max="{{ $artwork->stock }}" class="quantity-input" placeholder="Quantity">
                    <button type="submit">Add to Cart</button>
                </form>

                <!-- Buy Now Form -->
                <form method="POST" action="{{ route('order.buy_now') }}">
                    @csrf
                    <input type="hidden" name="artwork_id" value="{{ $artwork->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn-buy-now">Buy Now</button>
                </form>
            </div>
            @else
            <div style="padding: 15px; background-color: #fff3cd; border-radius: 4px; margin-bottom: 10px; font-size: 14px; text-align: center;">
                <a href="{{ route('login') }}" style="color: #856404; font-weight: 600;">Login</a> to add to cart or buy now
            </div>
            @endif
        @endif
    </div>
</div>

<script>
function handleBuyNow(event, maxStock) {
    // You could add a quantity selector here if needed
    // For now, it will buy 1 item directly
    event.target.closest('form').submit();
}
</script>

@if($relatedArtworks->count() > 0)
<div class="related-artworks">
    <h2>Related Artworks in {{ $artwork->category }}</h2>
    <div class="related-grid">
        @foreach($relatedArtworks as $related)
        <a href="{{ route('marketplace.show', $related) }}" style="text-decoration: none; color: inherit;">
            <div class="related-card">
                <img src="{{ str_contains($related->image_path, 'http') ? $related->image_path : (str_contains($related->image_path, 'artworks/') ? asset('storage/' . $related->image_path) : asset('storage/artworks/' . $related->image_path)) }}" alt="{{ $related->title }}" class="related-image" onerror="this.src='https://picsum.photos/seed/{{ $related->id }}/400/300'" >
                <div class="related-info">
                    <div style="font-weight: 600; margin-bottom: 5px;">{{ Str::limit($related->title, 15) }}</div>
                    <div style="color: #10b981; font-weight: bold;">₱{{ number_format($related->price, 2) }}</div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif
@endsection
