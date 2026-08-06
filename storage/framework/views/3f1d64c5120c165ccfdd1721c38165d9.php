

<?php $__env->startSection('title', 'Welcome'); ?>

<?php $__env->startSection('extra-styles'); ?>
<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 120px 20px;
        text-align: center;
        margin-bottom: 60px;
        position: relative;
        overflow: hidden;
    }

    .hero-section h1 {
        font-size: 56px;
        margin-bottom: 20px;
        font-weight: bold;
        animation: slideInDown 0.8s ease-out;
    }

    .hero-section p {
        font-size: 20px;
        margin-bottom: 40px;
        opacity: 0.95;
        animation: slideInUp 0.8s ease-out;
    }

    .hero-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
        animation: fadeIn 1s ease-out;
    }

    .btn-hero {
        padding: 15px 40px;
        font-size: 16px;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary-hero {
        background: white;
        color: #667eea;
    }

    .btn-primary-hero:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .btn-secondary-hero {
        background: transparent;
        color: white;
        border: 2px solid white;
    }

    .btn-secondary-hero:hover {
        background: white;
        color: #667eea;
        transform: translateY(-3px);
    }

    /* Category Section */
    .category-section {
        background: #f8f9fa;
        padding: 60px 20px;
        margin-bottom: 60px;
    }

    .section-title {
        font-size: 36px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 50px;
        color: #333;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .category-card {
        background: white;
        padding: 30px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .category-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }

    .category-icon {
        font-size: 48px;
        margin-bottom: 15px;
    }

    .category-card h3 {
        font-size: 20px;
        margin-bottom: 10px;
        color: #333;
    }

    .category-card p {
        color: #666;
        font-size: 14px;
    }

    /* Featured Artworks */
    .featured-section {
        padding: 60px 20px;
        margin-bottom: 60px;
    }

    .artworks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 25px;
        max-width: 1300px;
        margin: 0 auto;
    }

    .artwork-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .artwork-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.2);
    }

    .artwork-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .artwork-card:hover .artwork-image {
        transform: scale(1.05);
    }

    .artwork-info {
        padding: 15px;
    }

    .artwork-title {
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
        font-size: 16px;
    }

    .artwork-artist {
        color: #666;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .artwork-rating {
        color: #ffc107;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .artwork-price {
        font-size: 18px;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 10px;
    }

    .artwork-actions {
        display: flex;
        gap: 8px;
    }

    .btn-view, .btn-wishlist {
        flex: 1;
        padding: 8px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-view {
        background: #667eea;
        color: white;
    }

    .btn-view:hover {
        background: #764ba2;
    }

    .btn-wishlist {
        background: #f0f0f0;
        color: #666;
    }

    .btn-wishlist:hover {
        background: #e0e0e0;
    }

    /* Popular Artists */
    .artists-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 60px 20px;
        margin-bottom: 60px;
    }

    .artists-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .artist-card {
        text-align: center;
        background: rgba(255,255,255,0.1);
        padding: 30px;
        border-radius: 12px;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .artist-card:hover {
        transform: translateY(-5px);
        background: rgba(255,255,255,0.15);
    }

    .artist-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 0 auto 15px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        object-fit: cover;
    }

    .artist-name {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .artist-specialty {
        font-size: 13px;
        opacity: 0.9;
        margin-bottom: 10px;
    }

    .artist-sales {
        font-size: 14px;
        opacity: 0.8;
    }

    .artist-button {
        margin-top: 15px;
        padding: 8px 20px;
        background: white;
        color: #667eea;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s ease;
    }

    .artist-button:hover {
        transform: scale(1.05);
    }

    /* Promotions Section */
    .promotions-section {
        background: #f8f9fa;
        padding: 60px 20px;
        margin-bottom: 60px;
    }

    .promotions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .promo-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-left: 5px solid #667eea;
        transition: all 0.3s ease;
    }

    .promo-card:hover {
        transform: translateX(8px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .promo-title {
        font-size: 20px;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .promo-desc {
        color: #666;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .promo-btn {
        padding: 10px 20px;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .promo-btn:hover {
        background: #764ba2;
    }

    /* Testimonials */
    .testimonials-section {
        padding: 60px 20px;
        margin-bottom: 60px;
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .testimonial-card {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-top: 4px solid #ffc107;
    }

    .testimonial-stars {
        color: #ffc107;
        font-size: 18px;
        margin-bottom: 15px;
    }

    .testimonial-text {
        color: #666;
        font-size: 14px;
        margin-bottom: 15px;
        line-height: 1.6;
        font-style: italic;
    }

    .testimonial-author {
        font-weight: bold;
        color: #333;
        margin-bottom: 3px;
    }

    .testimonial-role {
        color: #999;
        font-size: 12px;
    }

    /* Newsletter */
    .newsletter-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 60px 20px;
        margin-bottom: 60px;
        border-radius: 12px;
        margin-left: 20px;
        margin-right: 20px;
    }

    .newsletter-content {
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
    }

    .newsletter-content h2 {
        font-size: 32px;
        margin-bottom: 15px;
    }

    .newsletter-form {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }

    .newsletter-form input {
        flex: 1;
        padding: 12px 20px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
    }

    .newsletter-form button {
        padding: 12px 30px;
        background: #ffc107;
        color: #333;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .newsletter-form button:hover {
        background: #ffb300;
        transform: scale(1.02);
    }

    /* Footer Enhancements */
    .footer-section {
        background-color: #1f2937;
        color: #d1d5db;
        padding: 60px 20px 20px;
    }

    .footer-col h4 {
        color: white;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .footer-col a, .footer-col p {
        color: #d1d5db;
        text-decoration: none;
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        transition: color 0.3s ease;
    }

    .footer-col a:hover {
        color: #667eea;
    }

    /* Animations */
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 32px;
        }

        .hero-section p {
            font-size: 16px;
        }

        .hero-buttons {
            flex-direction: column;
        }

        .btn-hero {
            width: 100%;
        }

        .section-title {
            font-size: 28px;
        }

        .category-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .artworks-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .newsletter-form {
            flex-direction: column;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="hero-section">
    <div class="max-w-4xl mx-auto">
        <h1>🎨 Discover & Sell Amazing Artworks</h1>
        <p>Connect with a global community of artists and art collectors</p>
        <div class="hero-buttons">
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('marketplace.index')); ?>" class="btn-hero btn-primary-hero">Browse Marketplace</a>
                <?php if(auth()->user()->isArtist()): ?>
                    <a href="<?php echo e(route('artist.dashboard')); ?>" class="btn-hero btn-secondary-hero">My Studio Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(route('buyer.dashboard')); ?>" class="btn-hero btn-secondary-hero">My Collection</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?php echo e(route('register')); ?>" class="btn-hero btn-primary-hero">Join as Artist</a>
                <a href="<?php echo e(route('login')); ?>" class="btn-hero btn-secondary-hero">Browse Marketplace</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Browse by Category -->
<section class="category-section">
    <h2 class="section-title">Browse by Category</h2>
    <div class="category-grid">
        <div class="category-card">
            <div class="category-icon">🎨</div>
            <h3>Painting</h3>
            <p>Oil, acrylic, watercolor and more</p>
        </div>
        <div class="category-card">
            <div class="category-icon">💻</div>
            <h3>Digital Art</h3>
            <p>3D, illustrations & digital designs</p>
        </div>
        <div class="category-card">
            <div class="category-icon">🗿</div>
            <h3>Sculpture</h3>
            <p>Stone, wood, metal sculptures</p>
        </div>
        <div class="category-card">
            <div class="category-icon">📷</div>
            <h3>Photography</h3>
            <p>Professional & artistic photos</p>
        </div>
    </div>
</section>

<!-- Featured Artworks -->
<section class="featured-section">
    <h2 class="section-title">Featured Artworks</h2>
    <div class="artworks-grid">
        <?php
            $featured = [
                ['id' => 1, 'title' => 'Modern Abstract', 'artist' => 'Sarah Art Studio', 'price' => 4500, 'rating' => '4.8', 'image' => 'https://picsum.photos/400/300?random=201'],
                ['id' => 2, 'title' => 'Urban Landscape', 'artist' => 'Mike Photography', 'price' => 3200, 'rating' => '4.6', 'image' => 'https://picsum.photos/400/300?random=202'],
                ['id' => 3, 'title' => 'Digital Dreams', 'artist' => 'Lisa Designs', 'price' => 2800, 'rating' => '4.9', 'image' => 'https://picsum.photos/400/300?random=203'],
                ['id' => 4, 'title' => 'Nature Vision', 'artist' => 'Alex Brown', 'price' => 5100, 'rating' => '4.7', 'image' => 'https://picsum.photos/400/300?random=204'],
                ['id' => 5, 'title' => 'Sunset Vibes', 'artist' => 'Emma Colors', 'price' => 3500, 'rating' => '4.5', 'image' => 'https://picsum.photos/400/300?random=205'],
                ['id' => 6, 'title' => 'City Lights', 'artist' => 'Tom Urban', 'price' => 4200, 'rating' => '4.8', 'image' => 'https://picsum.photos/400/300?random=206'],
            ];
        ?>
        <?php $__currentLoopData = $featured; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $artwork): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="artwork-card">
                <img src="<?php echo e($artwork['image']); ?>" alt="<?php echo e($artwork['title']); ?>" class="artwork-image" onerror="this.src='https://picsum.photos/400/300?random=999'">
                <div class="artwork-info">
                    <div class="artwork-title"><?php echo e($artwork['title']); ?></div>
                    <div class="artwork-artist">by <?php echo e($artwork['artist']); ?></div>
                    <div class="artwork-rating">⭐ <?php echo e($artwork['rating']); ?> Rating</div>
                    <div class="artwork-price">₱<?php echo e(number_format($artwork['price'])); ?></div>
                    <div class="artwork-actions">
                        <button class="btn-view">View</button>
                        <button class="btn-wishlist">♥ Save</button>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>

<!-- Popular Artists -->
<section class="artists-section">
    <h2 class="section-title" style="color: white; margin-bottom: 50px;">Popular Artists</h2>
    <div class="artists-grid">
        <div class="artist-card">
            <div class="artist-avatar">🎨</div>
            <div class="artist-name">Sarah Chen</div>
            <div class="artist-specialty">Modern Painter</div>
            <div class="artist-sales">250+ Sales</div>
            <button class="artist-button" onclick="alert('Following Sarah Chen!')">Follow</button>
        </div>
        <div class="artist-card">
            <div class="artist-avatar">📷</div>
            <div class="artist-name">Mike Johnson</div>
            <div class="artist-specialty">Photographer</div>
            <div class="artist-sales">180+ Sales</div>
            <button class="artist-button" onclick="alert('Following Mike Johnson!')">Follow</button>
        </div>
        <div class="artist-card">
            <div class="artist-avatar">💻</div>
            <div class="artist-name">Lisa Wong</div>
            <div class="artist-specialty">Digital Designer</div>
            <div class="artist-sales">320+ Sales</div>
            <button class="artist-button" onclick="alert('Following Lisa Wong!')">Follow</button>
        </div>
        <div class="artist-card">
            <div class="artist-avatar">🗿</div>
            <div class="artist-name">Alex Sculptor</div>
            <div class="artist-specialty">Sculptor</div>
            <div class="artist-sales">95+ Sales</div>
            <button class="artist-button" onclick="alert('Following Alex Sculptor!')">Follow</button>
        </div>
    </div>
</section>

<!-- Daily Deals / Promotions -->
<section class="promotions-section">
    <h2 class="section-title">🎉 Daily Deals & Promotions</h2>
    <div class="promotions-grid">
        <div class="promo-card">
            <div class="promo-title">🔥 Flash Sale</div>
            <div class="promo-desc">Get up to 30% off on selected artworks. Limited time only!</div>
            <a href="<?php echo e(route('marketplace.index', ['price_range' => ['0-5000']])); ?>" class="promo-btn" style="text-decoration: none; color: inherit;">Shop Now</a>
        </div>
        <div class="promo-card">
            <div class="promo-title">🎁 Bundle Deal</div>
            <div class="promo-desc">Buy 3 artworks, get 20% discount on the total price</div>
            <a href="<?php echo e(route('marketplace.index')); ?>" class="promo-btn" style="text-decoration: none; color: inherit;">View Bundle</a>
        </div>
        <div class="promo-card">
            <div class="promo-title">⭐ Artist Spotlight</div>
            <div class="promo-desc">Featured artist week - Check out amazing new collections</div>
            <a href="<?php echo e(route('marketplace.index', ['sort' => 'newest'])); ?>" class="promo-btn" style="text-decoration: none; color: inherit;">Discover</a>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials-section">
    <h2 class="section-title">💬 Success Stories</h2>
    <div class="testimonials-grid">
        <div class="testimonial-card">
            <div class="testimonial-stars">★★★★★</div>
            <div class="testimonial-text">"This platform helped me reach collectors worldwide! The interface is intuitive and the commission rates are fantastic."</div>
            <div class="testimonial-author">Emma Rodriguez</div>
            <div class="testimonial-role">Digital Artist</div>
        </div>
        <div class="testimonial-card">
            <div class="testimonial-stars">★★★★★</div>
            <div class="testimonial-text">"I found incredible artworks from emerging artists I never would have discovered otherwise. Highly recommend!"</div>
            <div class="testimonial-author">James Mitchell</div>
            <div class="testimonial-role">Art Collector</div>
        </div>
        <div class="testimonial-card">
            <div class="testimonial-stars">★★★★★</div>
            <div class="testimonial-text">"Amazing community, excellent support team, and fantastic exposure for my work. Best platform for artists!"</div>
            <div class="testimonial-author">Sofia Angelica</div>
            <div class="testimonial-role">Sculptor</div>
        </div>
    </div>
</section>

<!-- Newsletter Signup -->
<section class="newsletter-section">
    <div class="newsletter-content">
        <h2>📧 Stay Updated</h2>
        <p>Get notified about new artworks, exclusive deals, and artist spotlights</p>
        <form class="newsletter-form">
            <input type="email" placeholder="Enter your email" required>
            <button type="submit">Subscribe</button>
        </form>
    </div>
</section>

<!-- Footer -->
<footer class="footer-section">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
        <div class="footer-col">
            <h4>About Us</h4>
            <a href="#">About Platform</a>
            <a href="#">Our Mission</a>
            <a href="#">Blog</a>
            <a href="#">Press</a>
        </div>
        <div class="footer-col">
            <h4>Support</h4>
            <a href="#">Help Center</a>
            <a href="#">Contact Us</a>
            <a href="#">FAQ</a>
            <a href="#">Report Issue</a>
        </div>
        <div class="footer-col">
            <h4>Legal</h4>
            <a href="#">Terms & Conditions</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Cookie Policy</a>
            <a href="#">Seller Terms</a>
        </div>
        <div class="footer-col">
            <h4>Follow Us</h4>
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="#">Instagram</a>
            <a href="#">YouTube</a>
        </div>
    </div>
    <div style="border-top: 1px solid #374151; padding-top: 20px; text-align: center; font-size: 13px;">
        <p>&copy; 2026 Platform. All rights reserved. | Empowering Artists & Collectors Worldwide 🎨</p>
    </div>
</footer>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\laravel-f1-Sotto - Copy\resources\views/landing.blade.php ENDPATH**/ ?>