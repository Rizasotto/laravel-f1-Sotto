

<?php $__env->startSection('title', 'Marketplace'); ?>

<?php $__env->startSection('extra-styles'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
                <form action="<?php echo e(route('marketplace.index')); ?>" method="GET" style="display: flex; gap: 10px;">
                    <input type="text" name="search" placeholder="Search artworks, artists..." value="<?php echo e($search ?? ''); ?>" style="flex: 1;">
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
            <form method="GET" action="<?php echo e(route('marketplace.index')); ?>" id="filterForm">
                <div class="filters-grid">
                    <!-- Category Filter -->
                    <div class="filter-group">
                        <h3>Category</h3>
                        <select name="category" onchange="document.getElementById('filterForm').submit()">
                            <option value="">All Categories</option>
                            <option value="painting" <?php if($category === 'painting'): echo 'selected'; endif; ?>>🎨 Painting</option>
                            <option value="digital" <?php if($category === 'digital'): echo 'selected'; endif; ?>>💻 Digital Art</option>
                            <option value="photography" <?php if($category === 'photography'): echo 'selected'; endif; ?>>📷 Photography</option>
                            <option value="sculpture" <?php if($category === 'sculpture'): echo 'selected'; endif; ?>>🗿 Sculpture</option>
                            <option value="mixed" <?php if($category === 'mixed'): echo 'selected'; endif; ?>>🎭 Mixed Media</option>
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
                            <option value="newest" <?php if($sort === 'newest'): echo 'selected'; endif; ?>>⏰ Newest First</option>
                            <option value="popular" <?php if($sort === 'popular'): echo 'selected'; endif; ?>>🔥 Most Popular</option>
                            <option value="price_asc" <?php if($sort === 'price_asc'): echo 'selected'; endif; ?>>💰 Price: Low to High</option>
                            <option value="price_desc" <?php if($sort === 'price_desc'): echo 'selected'; endif; ?>>💰 Price: High to Low</option>
                            <option value="rating" <?php if($sort === 'rating'): echo 'selected'; endif; ?>>⭐ Highest Rated</option>
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
                    <a href="<?php echo e(route('marketplace.index')); ?>" class="btn-filter btn-filter-secondary">Clear All</a>
                </div>
            </form>
        </div>

        <!-- Browse Sections -->
        <div class="section-header">📚 Browse Collections</div>
        <div class="browse-sections">
            <a href="<?php echo e(route('marketplace.index', ['sort' => 'popular'])); ?>" style="text-decoration: none; color: inherit;">
                <div class="section-card" style="cursor: pointer;">
                    <div class="section-icon">🔥</div>
                    <h3>Trending Now</h3>
                    <p>Hottest artworks this week</p>
                </div>
            </a>
            <a href="<?php echo e(route('marketplace.index', ['sort' => 'newest'])); ?>" style="text-decoration: none; color: inherit;">
                <div class="section-card" style="cursor: pointer;">
                    <div class="section-icon">✨</div>
                    <h3>New Arrivals</h3>
                    <p>Fresh pieces from artists</p>
                </div>
            </a>
            <a href="<?php echo e(route('marketplace.index', ['price_range' => ['10000+']])); ?>" style="text-decoration: none; color: inherit;">
                <div class="section-card" style="cursor: pointer;">
                    <div class="section-icon">👑</div>
                    <h3>Premium Collection</h3>
                    <p>Exclusive high-value artworks</p>
                </div>
            </a>
            <a href="<?php echo e(route('marketplace.index', ['sort' => 'price_asc'])); ?>" style="text-decoration: none; color: inherit;">
                <div class="section-card" style="cursor: pointer;">
                    <div class="section-icon">🎁</div>
                    <h3>On Sale</h3>
                    <p>Special deals & discounts</p>
                </div>
            </a>
        </div>

        <!-- Featured Artworks -->
        <div class="section-header">✨ Featured Artworks</div>
        <?php if($artworks && $artworks->count() > 0): ?>
            <div class="products-grid">
                <?php $__currentLoopData = $artworks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $artwork): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="<?php echo e(str_contains($artwork->image_path, 'http') ? $artwork->image_path : (str_contains($artwork->image_path, 'artworks/') ? asset('storage/' . $artwork->image_path) : asset('storage/artworks/' . $artwork->image_path))); ?>" alt="<?php echo e($artwork->title); ?>" class="product-image" onerror="this.src='https://picsum.photos/seed/<?php echo e($artwork->id); ?>/400/300'">
                        <span class="product-badge">FEATURED</span>
                        <button class="wishlist-btn" onclick="alert('Added to wishlist!');">♥</button>
                    </div>
                    <div class="product-info">
                        <div class="product-title"><?php echo e($artwork->title); ?></div>
                        <div class="product-artist">by <?php echo e($artwork->artist->name ?? 'Unknown'); ?></div>
                        <div class="product-rating">⭐ 4.8 (<?php echo e(rand(10, 100)); ?> reviews)</div>
                        <div class="product-price">₱<?php echo e(number_format($artwork->price, 0)); ?></div>
                        <div class="product-stock">📦 <?php echo e($artwork->stock ?? 1); ?> in stock</div>
                        <div class="product-actions">
                            <a href="<?php echo e(route('marketplace.show', $artwork)); ?>" class="btn-view">View Details</a>
                            <?php if(auth()->check()): ?>
                                <form method="POST" action="<?php echo e(route('cart.add', $artwork->id)); ?>" style="flex: 1;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn-add">Add to Cart</button>
                                </form>
                                <form method="POST" action="<?php echo e(route('order.buy_now')); ?>" style="flex: 1;">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="artwork_id" value="<?php echo e($artwork->id); ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-buy-now">Buy Now</button>
                                </form>
                            <?php else: ?>
                                <a href="<?php echo e(route('login')); ?>" class="btn-info" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">Sign In</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <?php if($artworks->hasPages()): ?>
            <div class="pagination-container">
                <?php if($artworks->onFirstPage()): ?>
                    <span style="padding: 10px 15px; color: #ccc;">← Previous</span>
                <?php else: ?>
                    <a href="<?php echo e($artworks->previousPageUrl()); ?>" class="pagination-btn">← Previous</a>
                <?php endif; ?>

                <?php $__currentLoopData = $artworks->getUrlRange(1, $artworks->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $artworks->currentPage()): ?>
                        <span class="pagination-btn active"><?php echo e($page); ?></span>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>" class="pagination-btn"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if($artworks->hasMorePages()): ?>
                    <a href="<?php echo e($artworks->nextPageUrl()); ?>" class="pagination-btn">Next →</a>
                <?php else: ?>
                    <span style="padding: 10px 15px; color: #ccc;">Next →</span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">🎨</div>
                <h3>No artworks found</h3>
                <p>Try adjusting your filters or search terms</p>
                <a href="<?php echo e(route('marketplace.index')); ?>" class="btn-view" style="display: inline-block; padding: 10px 25px; margin-top: 15px; text-decoration: none;">Clear Filters</a>
            </div>
        <?php endif; ?>

        <!-- Recommendations Section -->
        <div class="recommendations-section">
            <div class="section-header">💡 Recommended For You</div>
            <div class="products-grid">
                <?php
                    $recommendations = [
                        ['id' => 1, 'title' => 'Abstract Serenity', 'artist' => 'Lisa Art Studio', 'price' => 3500, 'rating' => '4.9', 'image' => 'https://picsum.photos/seed/101/400/300'],
                        ['id' => 2, 'title' => 'Urban Landscape', 'artist' => 'Mike Photography', 'price' => 4200, 'rating' => '4.7', 'image' => 'https://picsum.photos/seed/102/400/300'],
                        ['id' => 3, 'title' => 'Nature\'s Beauty', 'artist' => 'Emma Nature', 'price' => 3800, 'rating' => '4.8', 'image' => 'https://picsum.photos/seed/103/400/300'],
                    ];
                ?>
                <?php $__currentLoopData = $recommendations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="<?php echo e($rec['image']); ?>" alt="<?php echo e($rec['title']); ?>" class="product-image" onerror="this.src='https://picsum.photos/seed/<?php echo e($rec['id']); ?>/400/300'">
                        <button class="wishlist-btn">♥</button>
                    </div>
                    <div class="product-info">
                        <div class="product-title"><?php echo e($rec['title']); ?></div>
                        <div class="product-artist">by <?php echo e($rec['artist']); ?></div>
                        <div class="product-rating">⭐ <?php echo e($rec['rating']); ?></div>
                        <div class="product-price">₱<?php echo e(number_format($rec['price'], 0)); ?></div>
                        <div class="product-actions">
                            <button class="btn-view" onclick="alert('View full details');">View</button>
                            <button class="btn-add" onclick="alert('Please log in to add to cart');">Add to Cart</button>
                            <button class="btn-buy-now" onclick="alert('Please log in to buy now');">Buy Now</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\laravel-f1-Sotto - Copy\resources\views/marketplace/index.blade.php ENDPATH**/ ?>