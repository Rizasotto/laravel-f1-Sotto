

<?php $__env->startSection('title', 'My Orders'); ?>

<?php $__env->startSection('extra-styles'); ?>
<style>
    .orders-container {
        background: white;
        border-radius: 4px;
        padding: 20px;
    }

    .orders-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .filter-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .filter-buttons a {
        padding: 8px 16px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        color: #333;
        font-size: 14px;
        transition: all 0.3s;
    }

    .filter-buttons a:hover,
    .filter-buttons a.active {
        background-color: #10b981;
        color: white;
        border-color: #10b981;
    }

    .order-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .order-card {
        border: 1px solid #eee;
        border-radius: 4px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .order-card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .order-header {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 20px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .order-info {
        font-size: 14px;
    }

    .order-info-label {
        color: #999;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .order-number {
        font-weight: bold;
        font-size: 14px;
    }

    .order-date {
        color: #666;
        font-size: 13px;
    }

    .order-amount {
        text-align: right;
        font-size: 18px;
        font-weight: bold;
        color: #10b981;
    }

    .order-items {
        margin-bottom: 15px;
    }

    .order-item-preview {
        display: flex;
        gap: 10px;
        align-items: center;
        padding: 10px 0;
        font-size: 13px;
    }

    .order-item-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
    }

    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .order-status {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-confirmed {
        background-color: #cfe2ff;
        color: #084298;
    }

    .status-shipped {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .status-delivered {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #842029;
    }

    .empty-orders {
        text-align: center;
        padding: 40px;
    }

    .empty-orders p {
        color: #999;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .order-header {
            grid-template-columns: 1fr;
        }

        .order-amount {
            text-align: left;
        }

        .order-footer {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="orders-container">
    <div class="orders-header">
        <h2>My Orders</h2>
        <div class="filter-buttons">
            <a href="<?php echo e(route('order.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => !$currentStatus]); ?>">All</a>
            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="?status=<?php echo e($status); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => $currentStatus === $status]); ?>"><?php echo e(ucfirst($status)); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <?php if($orders->count() > 0): ?>
        <div class="order-list">
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('order.show', $order)); ?>" style="text-decoration: none; color: inherit;">
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <div class="order-info-label">Order Number</div>
                            <div class="order-number"><?php echo e($order->order_number); ?></div>
                            <div class="order-date"><?php echo e($order->created_at->format('M d, Y')); ?></div>
                        </div>
                        <div class="order-info">
                            <div class="order-info-label">Status</div>
                            <div class="order-status status-<?php echo e($order->status); ?>">
                                <?php echo e(strtoupper($order->status)); ?>

                            </div>
                        </div>
                        <div class="order-info">
                            <div class="order-info-label">Total Amount</div>
                            <div class="order-amount">₱<?php echo e(number_format($order->total_amount, 2)); ?></div>
                        </div>
                    </div>

                    <div class="order-items">
                        <?php $__currentLoopData = $order->items->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="order-item-preview">
                            <img src="<?php echo e(str_contains($item->artwork->image_path, 'http') ? $item->artwork->image_path : (str_contains($item->artwork->image_path, 'artworks/') ? asset('storage/' . $item->artwork->image_path) : asset('storage/artworks/' . $item->artwork->image_path))); ?>" alt="<?php echo e($item->artwork->title); ?>" class="order-item-image" onerror="this.src='https://picsum.photos/seed/<?php echo e($item->artwork->id); ?>/400/300'">
                            <div>
                                <div><?php echo e(Str::limit($item->artwork->title, 30)); ?></div>
                                <div style="color: #999;">Qty: <?php echo e($item->quantity); ?></div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($order->items->count() > 2): ?>
                        <div style="color: #999; font-size: 12px; padding-top: 10px;">
                            +<?php echo e($order->items->count() - 2); ?> more item(s)
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="order-footer">
                        <span><?php echo e(count($order->items)); ?> item(s)</span>
                        <span class="btn btn-secondary">View Details →</span>
                    </div>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php echo e($orders->links()); ?>

    <?php else: ?>
        <div class="empty-orders">
            <p style="font-size: 18px; margin-bottom: 20px;">📦 No orders yet</p>
            <p>Start shopping to place your first order!</p>
            <a href="<?php echo e(route('marketplace.index')); ?>" class="btn btn-primary">Browse Artworks</a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\laravel-f1-Sotto - Copy\resources\views/orders/index.blade.php ENDPATH**/ ?>