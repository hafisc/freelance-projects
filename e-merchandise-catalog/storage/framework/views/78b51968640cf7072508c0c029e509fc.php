<?php $__env->startSection('title', 'Login Admin/Panitia'); ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="max-width: 500px;">
    <div class="card">
        <div class="card-body" style="text-align: center;">
            <h1 style="margin-bottom: 2rem; color: var(--primary);">Login Admin/Panitia</h1>
            
            <form action="<?php echo e(route('admin.login.post')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; text-align: left;">Email</label>
                    <input type="email" name="email" class="form-control" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; text-align: left;">Password</label>
                    <input type="password" name="password" class="form-control" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>

                <?php if($errors->any()): ?>
                    <div class="alert alert-error"><?php echo e($errors->first()); ?></div>
                <?php endif; ?>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
            </form>

            <p style="margin-top: 2rem; color: #666;">
                <a href="<?php echo e(route('home')); ?>" style="color: var(--primary);">← Kembali ke Beranda</a>
            </p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Project\Freelance Projects\merch\resources\views/auth/admin-login.blade.php ENDPATH**/ ?>