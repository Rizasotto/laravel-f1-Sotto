<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: #10b981;
            text-decoration: none;
        }

        .navbar-menu {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .navbar-menu a {
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }

        .navbar-menu a:hover {
            color: #10b981;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: #10b981;
            color: white;
        }

        .btn-primary:hover {
            background-color: #059669;
        }

        .btn-secondary {
            background-color: #f0f0f0;
            color: #333;
        }

        .btn-secondary:hover {
            background-color: #e0e0e0;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .alert {
            padding: 16px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .page-content {
            min-height: calc(100vh - 200px);
            padding: 30px 0;
        }

        footer {
            background-color: #222;
            color: white;
            padding: 30px;
            text-align: center;
            margin-top: 50px;
        }

        .cart-badge {
            background-color: #10b981;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
    </style>

    <?php echo $__env->yieldContent('extra-styles'); ?>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="<?php echo e(route('home')); ?>" class="navbar-brand">🎨 ArtConnect</a>
            
            <div class="navbar-menu">
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->isArtist()): ?>
                        <a href="<?php echo e(route('marketplace.index')); ?>">Marketplace</a>
                        <a href="<?php echo e(route('artist.dashboard')); ?>">Dashboard</a>
                        <a href="<?php echo e(route('artist.artworks.index')); ?>">My Artworks</a>
                    <?php endif; ?>

                    <?php if(auth()->user()->isBuyer()): ?>
                        <a href="<?php echo e(route('marketplace.index')); ?>">Marketplace</a>
                        <a href="<?php echo e(route('buyer.dashboard')); ?>">Dashboard</a>
                        <a href="<?php echo e(route('cart.index')); ?>">Cart <span class="cart-badge" id="cart-count">0</span></a>
                    <?php endif; ?>

                    <?php if(auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>">Admin Dashboard</a>
                    <?php endif; ?>

                    <span><?php echo e(auth()->user()->name); ?></span>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-secondary">Logout</button>
                    </form>
                <?php endif; ?>

                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-secondary">Login</a>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul style="margin: 0;">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <footer>
        <p></p>
    </footer>

    <?php if(auth()->check() && auth()->user()->isBuyer()): ?>
    <script>
        function updateCartCount() {
            fetch('<?php echo e(route("cart.count")); ?>')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.count;
                });
        }
        updateCartCount();
    </script>
    <?php endif; ?>

    <?php echo $__env->yieldContent('extra-scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\laravel-f1-Sotto - Copy\resources\views/layouts/app.blade.php ENDPATH**/ ?>