<?php $__env->startSection('title', $product->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div>
                <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" style="width: 100%; border-radius: 12px;">
            </div>
            <div class="card-body">
                <h1 style="color: var(--primary); margin-bottom: 1rem;"><?php echo e($product->name); ?></h1>
                
                <div style="margin-bottom: 1rem;">
                    <?php if($product->is_promo && $product->promo_price): ?>
                        <span style="text-decoration: line-through; color: #999; font-size: 1.25rem;">Rp <?php echo e(number_format($product->price)); ?></span>
                        <div style="font-size: 2rem; color: var(--primary); font-weight: bold;">Rp <?php echo e(number_format($product->promo_price)); ?></div>
                    <?php else: ?>
                        <div style="font-size: 2rem; color: var(--primary); font-weight: bold;">Rp <?php echo e(number_format($product->price)); ?></div>
                    <?php endif; ?>
                </div>

                <p style="margin-bottom: 1rem;"><?php echo e($product->description); ?></p>

                <p style="margin-bottom: 1rem;">
                    <strong>Stok:</strong> <?php echo e($product->stock); ?>

                </p>

                <?php if($product->is_kaos && $product->sizes): ?>
                    <div style="margin-bottom: 1rem;">
                        <strong>Ukuran:</strong>
                        <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem;">
                            <?php $__currentLoopData = $product->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label style="cursor: pointer;">
                                    <input type="radio" name="size" value="<?php echo e($size); ?>" class="size-radio" style="display: none;">
                                    <span class="size-option" style="padding: 0.5rem 1rem; border: 2px solid #ddd; border-radius: 8px; display: inline-block;"><?php echo e($size); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div style="margin-bottom: 1rem;">
                    <label><strong>Jumlah:</strong></label>
                    <input type="number" id="quantity" value="1" min="1" max="<?php echo e($product->stock); ?>" style="width: 100px; padding: 0.5rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>

                <?php if(auth()->guard()->check()): ?>
                    <form action="<?php echo e(route('cart.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                        <input type="hidden" name="size" id="selectedSize">
                        <input type="hidden" name="quantity" id="hiddenQuantity">
                        <button type="submit" class="btn btn-secondary" style="width: 100%;" onclick="document.getElementById('hiddenQuantity').value = document.getElementById('quantity').value;">+ Tambah ke Keranjang</button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-secondary" style="width: 100%; display: block;">Login untuk Membeli</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if($related->count() > 0): ?>
        <h2 style="margin-top: 3rem; margin-bottom: 1rem;">Produk Terkait</h2>
        <div class="products-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;">
            <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card">
                    <img src="<?php echo e(asset('storage/' . $item->image)); ?>" alt="<?php echo e($item->name); ?>" style="width: 100%; height: 150px; object-fit: cover;">
                    <div class="card-body">
                        <h3 style="margin-bottom: 0.5rem;"><?php echo e($item->name); ?></h3>
                        <div style="color: var(--primary); font-weight: bold;">Rp <?php echo e(number_format($item->final_price)); ?></div>
                        <a href="<?php echo e(route('product.detail', $item->slug)); ?>" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem;">Lihat</a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.querySelectorAll('.size-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.size-option').forEach(opt => {
                opt.style.borderColor = '#ddd';
                opt.style.background = 'white';
            });
            if (this.checked) {
                this.nextElementSibling.style.borderColor = 'var(--primary)';
                this.nextElementSibling.style.background = 'var(--primary)';
                this.nextElementSibling.style.color = 'white';
                document.getElementById('selectedSize').value = this.value;
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Project\Freelance Projects\merch\resources\views/product-detail.blade.php ENDPATH**/ ?>