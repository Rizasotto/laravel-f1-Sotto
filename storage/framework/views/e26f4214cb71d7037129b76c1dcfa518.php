

<?php $__env->startSection('title', 'GCash Payment - ' . $order->order_number); ?>

<?php $__env->startSection('content'); ?>
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px 20px; margin-bottom: 30px;">
    <div style="max-width: 800px; margin: 0 auto; text-align: center;">
        <h1 style="font-size: 32px; margin: 0; margin-bottom: 10px;">GCash Payment</h1>
        <p style="opacity: 0.9; margin: 0;">Complete your payment securely with GCash</p>
    </div>
</div>

<div style="max-width: 800px; margin: 0 auto; padding: 40px 20px;">
    <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <!-- Order Details -->
        <div style="margin-bottom: 30px;">
            <h2 style="font-size: 20px; margin-bottom: 20px; color: #333;">Order Details</h2>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                    <p style="font-size: 12px; color: #666; margin: 0 0 5px 0;">Order Number</p>
                    <p style="font-size: 18px; font-weight: 700; color: #333; margin: 0;"><?php echo e($order->order_number); ?></p>
                </div>
                
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                    <p style="font-size: 12px; color: #666; margin: 0 0 5px 0;">Total Amount</p>
                    <p style="font-size: 18px; font-weight: 700; color: #667eea; margin: 0;">₱<?php echo e(number_format($order->total_amount, 2)); ?></p>
                </div>
            </div>

            <div style="border-top: 1px solid #eee; padding-top: 20px;">
                <h3 style="font-size: 14px; margin: 0 0 15px 0; color: #333;">Items</h3>
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                    <span style="color: #666;"><?php echo e($item->artwork->title); ?> (Q: <?php echo e($item->quantity); ?>)</span>
                    <span style="font-weight: 600; color: #333;">₱<?php echo e(number_format($item->price * $item->quantity, 2)); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div style="border-top: 1px solid #eee; padding-top: 20px;">
            <!-- GCash Payment Instructions -->
            <h2 style="font-size: 18px; margin-bottom: 20px; color: #333;">📱 Send Payment via GCash</h2>
            
            <div style="background: #e7f5e7; border-left: 4px solid #10b981; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                <p style="margin: 0 0 10px 0; font-size: 14px; color: #2d5e3a; line-height: 1.7;">
                    <strong>1. Open your GCash app</strong><br>
                    <strong>2. Send money to:</strong> ART CONNECT SHOP<br>
                    <strong>3. Amount:</strong> ₱<?php echo e(number_format($order->total_amount, 2)); ?><br>
                    <strong>4. Reference:</strong> <?php echo e($order->order_number); ?>

                </p>
            </div>
            
            <form action="<?php echo e(route('payment.gcash.mock')); ?>" method="POST" id="gcashForm">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
                <input type="hidden" name="amount" value="<?php echo e($order->total_amount); ?>">

                <!-- GCash Number Input -->
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Your GCash Number</label>
                    <input type="tel" id="gcashNumber" name="gcash_number" placeholder="09XX XXX XXXX" 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;" 
                           pattern="[0-9]{4}[0-9]{3}[0-9]{4}" required>
                    <p style="font-size: 12px; color: #666; margin: 8px 0 0 0;">✓ We'll send confirmation to this number</p>
                </div>

                <!-- Action Buttons -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <a href="<?php echo e(route('order.checkout', $order)); ?>" 
                       style="padding: 12px; background: white; color: #667eea; border: 2px solid #667eea; 
                              border-radius: 6px; text-align: center; text-decoration: none; font-weight: 600; 
                              transition: all 0.2s;">
                        Cancel
                    </a>
                    <button type="button" id="proceedPaymentBtn"
                            style="padding: 12px; background: #10b981; color: white; border: none; border-radius: 6px; 
                                   font-weight: 600; cursor: pointer; font-size: 16px; transition: all 0.2s;">
                        ✓ Proceed to Pay
                    </button>
                </div>
            </form>

            <!-- Confirmation Modal -->
            <div id="confirmationModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                                              background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; 
                                              justify-content: center;">
                <div style="background: white; border-radius: 12px; padding: 30px; max-width: 500px; width: 90%; 
                           box-shadow: 0 8px 32px rgba(0,0,0,0.2);">
                    <h2 style="font-size: 22px; margin: 0 0 15px 0; color: #333; text-align: center;">Confirm Payment</h2>
                    
                    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 25px;">
                        <div style="text-align: center;">
                            <p style="font-size: 12px; color: #666; margin: 0 0 10px 0;">Amount to Pay</p>
                            <p style="font-size: 32px; font-weight: 700; color: #10b981; margin: 0;">₱<?php echo e(number_format($order->total_amount, 2)); ?></p>
                            <p style="font-size: 13px; color: #666; margin: 10px 0 0 0;">Order: <?php echo e($order->order_number); ?></p>
                        </div>
                    </div>

                    <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; border-radius: 6px; 
                               margin-bottom: 25px;">
                        <p style="font-size: 14px; color: #856404; margin: 0; line-height: 1.6;">
                            <strong>⚠️ Please confirm:</strong><br>
                            • You have sent the money via GCash<br>
                            • The amount is correct<br>
                            • The reference number is <?php echo e($order->order_number); ?>

                        </p>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <button type="button" id="cancelConfirmBtn"
                                style="padding: 12px; background: white; color: #666; border: 2px solid #ddd; 
                                       border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 14px; 
                                       transition: all 0.2s;">
                            Cancel
                        </button>
                        <button type="button" id="confirmPaymentBtn"
                                style="padding: 12px; background: #10b981; color: white; border: none; 
                                       border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 14px; 
                                       transition: all 0.2s;">
                            ✓ Confirm Payment
                        </button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<style>
    button:hover {
        background: #5568d3 !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.3) !important;
    }

    a:hover {
        border-color: #5568d3 !important;
        color: #5568d3 !important;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2) !important;
    }

    #confirmationModal {
        animation: slideUp 0.3s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    const proceedPaymentBtn = document.getElementById('proceedPaymentBtn');
    const confirmationModal = document.getElementById('confirmationModal');
    const confirmPaymentBtn = document.getElementById('confirmPaymentBtn');
    const cancelConfirmBtn = document.getElementById('cancelConfirmBtn');
    const gcashForm = document.getElementById('gcashForm');
    const gcashNumberInput = document.getElementById('gcashNumber');

    // Show confirmation modal when "Proceed to Pay" is clicked
    proceedPaymentBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Validate GCash number first
        if (!gcashNumberInput.value.trim()) {
            alert('Please enter your GCash number.');
            return;
        }

        // Validate phone format
        if (!gcashNumberInput.checkValidity()) {
            alert('Please enter a valid GCash number (09XXXXXXXXX).');
            return;
        }

        // Show modal
        confirmationModal.style.display = 'flex';
    });

    // Confirm payment - submit the form
    confirmPaymentBtn.addEventListener('click', function() {
        confirmationModal.style.display = 'none';
        gcashForm.submit();
    });

    // Cancel confirmation
    cancelConfirmBtn.addEventListener('click', function() {
        confirmationModal.style.display = 'none';
    });

    // Close modal when clicking outside
    confirmationModal.addEventListener('click', function(e) {
        if (e.target === confirmationModal) {
            confirmationModal.style.display = 'none';
        }
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\laravel-f1-Sotto - Copy\resources\views/payment/gcash_form.blade.php ENDPATH**/ ?>