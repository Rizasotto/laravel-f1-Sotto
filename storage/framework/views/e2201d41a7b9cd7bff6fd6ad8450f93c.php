

<?php $__env->startSection('title', 'My Artworks'); ?>

<?php $__env->startSection('extra-styles'); ?>
<style>
    .artworks-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .artworks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }

    .artwork-card {
        background: white;
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }

    .artwork-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }

    .artwork-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background-color: #f0f0f0;
    }

    .artwork-info {
        padding: 15px;
    }

    .artwork-title {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .artwork-price {
        font-size: 16px;
        font-weight: bold;
        color: #10b981;
        margin-bottom: 8px;
    }

    .artwork-stats {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: #999;
        margin-bottom: 12px;
    }

    .artwork-status {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .status-active {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .status-inactive {
        background-color: #f8d7da;
        color: #842029;
    }

    .artwork-actions {
        display: flex;
        gap: 8px;
    }

    .artwork-actions .btn {
        flex: 1;
        padding: 6px;
        font-size: 12px;
    }

    .empty-state {
        background: white;
        padding: 60px;
        border-radius: 4px;
        text-align: center;
    }

    .empty-state p {
        color: #999;
        margin-bottom: 20px;
    }

    .pagination {
        margin-top: 30px;
        display: flex;
        justify-content: center;
        gap: 5px;
    }

    .pagination a, .pagination span {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        color: #333;
    }

    .pagination a:hover {
        background-color: #f0f0f0;
    }

    @media (max-width: 768px) {
        .artworks-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }

        .artworks-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="artworks-header">
    <h1>My Artworks</h1>
    <a href="<?php echo e(route('artist.artworks.create')); ?>" class="btn btn-primary">+ Create New Artwork</a>
</div>

<?php if($artworks->count() > 0): ?>
    <div class="artworks-grid">
        <?php $__currentLoopData = $artworks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $artwork): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="artwork-card">
            <img src="<?php echo e(asset('storage/' . $artwork->image_path)); ?>" alt="<?php echo e($artwork->title); ?>" class="artwork-image" onerror="this.src='https://picsum.photos/seed/<?php echo e($artwork->id); ?>/400/300'">>
            
            <div class="artwork-info">
                <div class="artwork-title"><?php echo e($artwork->title); ?></div>
                <div class="artwork-price">₱<?php echo e(number_format($artwork->price, 2)); ?></div>
                
                <div class="artwork-status status-<?php echo e($artwork->status); ?>">
                    <?php echo e(strtoupper($artwork->status)); ?>

                </div>

                <div class="artwork-stats">
                    <span>👁 <?php echo e($artwork->views); ?></span>
                    <span>📦 <?php echo e($artwork->stock); ?></span>
                    <span>🛒 <?php echo e($artwork->orderItems()->count()); ?></span>
                </div>

                <div class="artwork-actions">
                    <a href="<?php echo e(route('artist.artworks.edit', $artwork)); ?>" class="btn btn-secondary">Edit</a>
                    <form method="POST" action="<?php echo e(route('artwork.destroy', $artwork)); ?>" style="flex: 1;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this artwork?')" style="width: 100%;">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php echo e($artworks->links()); ?>

<?php else: ?>
    <div class="empty-state">
        <p style="font-size: 18px; margin-bottom: 20px;">🎨 No artworks yet</p>
        <p>Start creating your first artwork!</p>
        <a href="<?php echo e(route('artist.artworks.create')); ?>" class="btn btn-primary">Create Your First Artwork</a>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\laravel-f1-Sotto - Copy\resources\views/artist/artworks/index.blade.php ENDPATH**/ ?>