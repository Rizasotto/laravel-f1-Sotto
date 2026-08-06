@extends('layouts.app')

@section('title', 'Marketplace')

@section('extra-styles')
<style>
    /* Main Container */
    .marketplace-wrapper {
        background: #f8f9fa;
        min-height: calc(100vh - 100px);
        padding: 30px 0;
    }

    .marketplace-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        margin-bottom: 30px;
        border-radius: 8px;
    }

    .marketplace-header h1 {
        font-size: 32px;
        margin-bottom: 10px;
    }

    .marketplace-header p {
        font-size: 14px;
        opacity: 0.9;
    }

    /* Top Actions */
    .marketplace-actions {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
        flex-wrap: wrap;
        align-items: center;
    }

    .search-container {
        flex: 1;
        min-width: 250px;
    }

    .search-container input {
        width: 100%;
        padding: 12px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 25px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .search-container input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .view-toggle {
        display: flex;
        gap: 10px;
    }

    .view-btn {
        padding: 8px 16px;
        border: 2px solid #ddd;
        background: white;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .view-btn.active {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }

    /* Filters */
    .filters-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-bottom: 25px;
    }

    .filters-header {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .filter-group {
        margin-bottom: 0;
    }

    .filter-group h3 {
        font-size: 13px;
        margin-bottom: 10px;
        font-weight: 700;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        cursor: pointer;
        color: #666;
    }

    .filter-group input[type="checkbox"],
    .filter-group input[type="radio"] {
        margin-right: 8px;
        cursor: pointer;
    }

    .filter-group select,
    .filter-group input[type="text"],
    .filter-group input[type="number"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 12px;
        transition: all 0.2s ease;
    }

    .filter-group input:focus,
    .filter-group select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .filter-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .btn-filter {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s ease;
    }

    .btn-filter-primary {
        background: #667eea;
        color: white;
    }

    .btn-filter-primary:hover {
        background: #764ba2;
    }

    .btn-filter-secondary {
        background: #f0f0f0;
        color: #333;
    }

    .btn-filter-secondary:hover {
        background: #e0e0e0;
    }

    /* Products Grid */
    .section-header {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .product-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.2);
    }

    .product-image-container {
        position: relative;
        height: 250px;
        overflow: hidden;
        background: #f0f0f0;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .product-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #ff6b6b;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .wishlist-btn {
        position: absolute;
        top: 10px;
        left: 10px;
        width: 40px;
        height: 40px;
        background: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        font-size: 20px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .wishlist-btn:hover {
        background: #ff6b6b;
        color: white;
        transform: scale(1.1);
    }

    .product-info {
        padding: 15px;
    }

    .product-title {
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
        font-size: 15px;
    }

    .product-artist {
        color: #666;
        font-size: 12px;
        margin-bottom: 8px;
    }

    .product-rating {
        color: #ffc107;
        font-size: 12px;
        margin-bottom: 8px;
    }

    .product-price {
        font-size: 18px;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 10px;
    }

    .product-stock {
        font-size: 12px;
        color: #999;
        margin-bottom: 10px;
    }

    .product-actions {
        display: flex;
        gap: 8px;
    }

    .product-actions form {
        flex: 1;
        display: flex;
    }

    .btn-view, .btn-add, .btn-info {
        flex: 1;
        padding: 8px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .product-actions form .btn-add {
        width: 100%;
        margin: 0;
    }

    .btn-view {
        background: #667eea;
        color: white;
    }

    .btn-view:hover {
        background: #764ba2;
    }

    .btn-add {
        background: #10b981;
        color: white;
    }

    .btn-add:hover {
        background: #059669;
    }

    .btn-buy-now {
        background: #667eea;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 8px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.2s ease;
        width: 100%;
        margin: 0;
    }

    .btn-buy-now:hover {
        background: #764ba2;
    }

    .btn-info {
        background: #f0f0f0;
        color: #666;
    }

    .btn-info:hover {
        background: #e0e0e0;
    }

    /* Recommendations Section */
    .recommendations-section {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-bottom: 40px;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 30px;
    }

    .pagination-btn {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: white;
        color: #667eea;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .pagination-btn:hover {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }

    .pagination-btn.active {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 40px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 15px;
    }

    .empty-state h3 {
        font-size: 18px;
        color: #333;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #999;
        margin-bottom: 20px;
    }

    /* Browse Sections */
    .browse-sections {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .section-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .section-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .section-icon {
        font-size: 40px;
        margin-bottom: 10px;
    }

    .section-card h3 {
        font-size: 16px;
        color: #333;
        margin-bottom: 8px;
    }

    .section-card p {
        font-size: 12px;
        color: #666;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }

        .filters-grid {
            grid-template-columns: 1fr;
        }

        .product-image-container {
            height: 200px;
        }

        .marketplace-header h1 {
            font-size: 24px;
        }
    }
</style>
@endsection

@section('content')
<div class="marketplace-wrapper">
    <!-- Header -->
    <div class="marketplace-header">
        <h1>🎨 Art Marketplace</h1>
        <p>Discover unique artworks from talented artists around the world</p>
    </div>

    <div class="max-w-7xl mx-auto px-4">
        <!-- Top Actions -->
        <div class="marketplace-actions">
            <div class="search-container">
                <form action="{{ route('marketplace.index') }}" method="GET" style="display: flex; gap: 10px;">
                    <input type="text" name="search" placeholder="Search artworks, artists..." value="{{ $search ?? '' }}" style="flex: 1;">
                    <button type="submit" style="padding: 12px 25px; background: #667eea; color: white; border: none; border-radius: 25px; cursor: pointer; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.background='#764ba2'" onmouseout="this.style.background='#667eea'">🔍 Search</button>
                </form>
            </div>
            <div class="view-toggle">
                <button class="view-btn active" onclick="toggleView('grid')">🔲 Grid</button>
                <button class="view-btn" onclick="toggleView('list')">📋 List</button>
            </div>
        </div>

        <script>
        function toggleView(view) {
            const gridBtn = document.querySelectorAll('.view-btn')[0];
            const listBtn = document.querySelectorAll('.view-btn')[1];
            const productsGrid = document.querySelector('.products-grid');

            if (view === 'grid') {
                gridBtn.classList.add('active');
                listBtn.classList.remove('active');
                productsGrid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(220px, 1fr))';
            } else {
                listBtn.classList.add('active');
                gridBtn.classList.remove('active');
                productsGrid.style.gridTemplateColumns = '1fr';
                // Make cards display as rows
                document.querySelectorAll('.product-card').forEach(card => {
                    card.style.display = 'flex';
                    card.style.alignItems = 'stretch';
                });
                const imageContainers = document.querySelectorAll('.product-image-container');
                imageContainers.forEach(img => {
                    img.style.width = '200px';
                    img.style.height = '150px';
                    img.style.minWidth = '200px';
                });
                const productInfo = document.querySelectorAll('.product-info');
                productInfo.forEach(info => {
                    info.style.flex = '1';
                    info.style.display = 'flex';
                    info.style.flexDirection = 'column';
                    info.style.justifyContent = 'space-between';
                });
            }
        }
        </script>

        <!-- Filters -->
        <div class="filters-container">
            <div class="filters-header">🔍 Filters & Sort</div>
            <form method="GET" action="{{ route('marketplace.index') }}" id="filterForm">
                <div class="filters-grid">
                    <!-- Category Filter -->
                    <div class="filter-group">
                        <h3>Category</h3>
                        <select name="category" onchange="document.getElementById('filterForm').submit()">
                            <option value="">All Categories</option>
                            <option value="painting" @selected($category === 'painting')>🎨 Painting</option>
                            <option value="digital" @selected($category === 'digital')>💻 Digital Art</option>
                            <option value="photography" @selected($category === 'photography')>📷 Photography</option>
                            <option value="sculpture" @selected($category === 'sculpture')>🗿 Sculpture</option>
                            <option value="mixed" @selected($category === 'mixed')>🎭 Mixed Media</option>
                        </select>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="filter-group">
                        <h3>Price Range</h3>
                        <label style="margin-bottom: 5px;">
                            <input type="checkbox" name="price_range[]" value="0-1000"> Under ₱1,000
                        </label>
                        <label style="margin-bottom: 5px;">
                            <input type="checkbox" name="price_range[]" value="1000-5000"> ₱1,000 - ₱5,000
                        </label>
                        <label style="margin-bottom: 5px;">
                            <input type="checkbox" name="price_range[]" value="5000-10000"> ₱5,000 - ₱10,000
                        </label>
                        <label>
                            <input type="checkbox" name="price_range[]" value="10000+"> Over ₱10,000
                        </label>
                    </div>

                    <!-- Sort Options -->
                    <div class="filter-group">
                        <h3>Sort By</h3>
                        <select name="sort" onchange="document.getElementById('filterForm').submit()">
                            <option value="newest" @selected($sort === 'newest')>⏰ Newest First</option>
                            <option value="popular" @selected($sort === 'popular')>🔥 Most Popular</option>
                            <option value="price_asc" @selected($sort === 'price_asc')>💰 Price: Low to High</option>
                            <option value="price_desc" @selected($sort === 'price_desc')>💰 Price: High to Low</option>
                            <option value="rating" @selected($sort === 'rating')>⭐ Highest Rated</option>
                        </select>
                    </div>

                    <!-- Style Filter -->
                    <div class="filter-group">
                        <h3>Style</h3>
                        <label style="margin-bottom: 5px;">
                            <input type="checkbox" name="style[]" value="abstract"> Abstract
                        </label>
                        <label style="margin-bottom: 5px;">
                            <input type="checkbox" name="style[]" value="realistic"> Realistic
                        </label>
                        <label style="margin-bottom: 5px;">
                            <input type="checkbox" name="style[]" value="contemporary"> Contemporary
                        </label>
                        <label>
                            <input type="checkbox" name="style[]" value="traditional"> Traditional
                        </label>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn-filter btn-filter-primary">Apply Filters</button>
                    <a href="{{ route('marketplace.index') }}" class="btn-filter btn-filter-secondary">Clear All</a>
                </div>
            </form>
        </div>

        <!-- Browse Sections -->
        <div class="section-header">📚 Browse Collections</div>
        <div class="browse-sections">
            <a href="{{ route('marketplace.index', ['sort' => 'popular']) }}" style="text-decoration: none; color: inherit;">
                <div class="section-card" style="cursor: pointer;">
                    <div class="section-icon">🔥</div>
                    <h3>Trending Now</h3>
                    <p>Hottest artworks this week</p>
                </div>
            </a>
            <a href="{{ route('marketplace.index', ['sort' => 'newest']) }}" style="text-decoration: none; color: inherit;">
                <div class="section-card" style="cursor: pointer;">
                    <div class="section-icon">✨</div>
                    <h3>New Arrivals</h3>
                    <p>Fresh pieces from artists</p>
                </div>
            </a>
            <a href="{{ route('marketplace.index', ['price_range' => ['10000+']]) }}" style="text-decoration: none; color: inherit;">
                <div class="section-card" style="cursor: pointer;">
                    <div class="section-icon">👑</div>
                    <h3>Premium Collection</h3>
                    <p>Exclusive high-value artworks</p>
                </div>
            </a>
            <a href="{{ route('marketplace.index', ['sort' => 'price_asc']) }}" style="text-decoration: none; color: inherit;">
                <div class="section-card" style="cursor: pointer;">
                    <div class="section-icon">🎁</div>
                    <h3>On Sale</h3>
                    <p>Special deals & discounts</p>
                </div>
            </a>
        </div>

        <!-- Featured Artworks -->
        <div class="section-header">✨ Featured Artworks</div>
        @if($artworks && $artworks->count() > 0)
            <div class="products-grid">
                @foreach($artworks as $artwork)
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="{{ str_contains($artwork->image_path, 'http') ? $artwork->image_path : (str_contains($artwork->image_path, 'artworks/') ? asset('storage/' . $artwork->image_path) : asset('storage/artworks/' . $artwork->image_path)) }}" alt="{{ $artwork->title }}" class="product-image" onerror="this.src='https://picsum.photos/seed/{{ $artwork->id }}/400/300'">
                        <span class="product-badge">FEATURED</span>
                        <button class="wishlist-btn" onclick="alert('Added to wishlist!');">♥</button>
                    </div>
                    <div class="product-info">
                        <div class="product-title">{{ $artwork->title }}</div>
                        <div class="product-artist">by {{ $artwork->artist->name ?? 'Unknown' }}</div>
                        <div class="product-rating">⭐ 4.8 ({{ rand(10, 100) }} reviews)</div>
                        <div class="product-price">₱{{ number_format($artwork->price, 0) }}</div>
                        <div class="product-stock">📦 {{ $artwork->stock ?? 1 }} in stock</div>
                        <div class="product-actions">
                            <a href="{{ route('marketplace.show', $artwork) }}" class="btn-view">View Details</a>
                            @if(auth()->check())
                                <form method="POST" action="{{ route('cart.add', $artwork->id) }}" style="flex: 1;">
                                    @csrf
                                    <button type="submit" class="btn-add">Add to Cart</button>
                                </form>
                                <form method="POST" action="{{ route('order.buy_now') }}" style="flex: 1;">
                                    @csrf
                                    <input type="hidden" name="artwork_id" value="{{ $artwork->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-buy-now">Buy Now</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn-info" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">Sign In</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($artworks->hasPages())
            <div class="pagination-container">
                @if($artworks->onFirstPage())
                    <span style="padding: 10px 15px; color: #ccc;">← Previous</span>
                @else
                    <a href="{{ $artworks->previousPageUrl() }}" class="pagination-btn">← Previous</a>
                @endif

                @foreach($artworks->getUrlRange(1, $artworks->lastPage()) as $page => $url)
                    @if($page == $artworks->currentPage())
                        <span class="pagination-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pagination-btn">{{ $page }}</a>
                    @endif
                @endforeach

                @if($artworks->hasMorePages())
                    <a href="{{ $artworks->nextPageUrl() }}" class="pagination-btn">Next →</a>
                @else
                    <span style="padding: 10px 15px; color: #ccc;">Next →</span>
                @endif
            </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-state-icon">🎨</div>
                <h3>No artworks found</h3>
                <p>Try adjusting your filters or search terms</p>
                <a href="{{ route('marketplace.index') }}" class="btn-view" style="display: inline-block; padding: 10px 25px; margin-top: 15px; text-decoration: none;">Clear Filters</a>
            </div>
        @endif

        <!-- Recommendations Section -->
        <div class="recommendations-section">
            <div class="section-header">💡 Recommended For You</div>
            <div class="products-grid">
                @php
                    $recommendations = [
                        ['id' => 1, 'title' => 'Abstract Serenity', 'artist' => 'Lisa Art Studio', 'price' => 3500, 'rating' => '4.9', 'image' => 'https://picsum.photos/seed/101/400/300'],
                        ['id' => 2, 'title' => 'Urban Landscape', 'artist' => 'Mike Photography', 'price' => 4200, 'rating' => '4.7', 'image' => 'https://picsum.photos/seed/102/400/300'],
                        ['id' => 3, 'title' => 'Nature\'s Beauty', 'artist' => 'Emma Nature', 'price' => 3800, 'rating' => '4.8', 'image' => 'https://picsum.photos/seed/103/400/300'],
                    ];
                @endphp
                @foreach($recommendations as $rec)
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="{{ $rec['image'] }}" alt="{{ $rec['title'] }}" class="product-image" onerror="this.src='https://picsum.photos/seed/{{ $rec['id'] }}/400/300'">
                        <button class="wishlist-btn">♥</button>
                    </div>
                    <div class="product-info">
                        <div class="product-title">{{ $rec['title'] }}</div>
                        <div class="product-artist">by {{ $rec['artist'] }}</div>
                        <div class="product-rating">⭐ {{ $rec['rating'] }}</div>
                        <div class="product-price">₱{{ number_format($rec['price'], 0) }}</div>
                        <div class="product-actions">
                            <button class="btn-view" onclick="alert('View full details');">View</button>
                            <button class="btn-add" onclick="alert('Please log in to add to cart');">Add to Cart</button>
                            <button class="btn-buy-now" onclick="alert('Please log in to buy now');">Buy Now</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
