<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'CMB Merch'); ?></title>
    
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
    <?php if(!request()->is('admin*')): ?>
    <header class="main-header">
        <div class="container header-container">
            <a href="<?php echo e(route('home')); ?>" class="logo">
                <span class="logo-accent">CMB</span> Merch
            </a>
            <nav class="nav-links">
                <a href="<?php echo e(route('home')); ?>" class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Beranda</a>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('customer.orders')); ?>" class="nav-link <?php echo e(request()->routeIs('customer.orders') ? 'active' : ''); ?>">Pesanan</a>
                    <a href="<?php echo e(route('cart.index')); ?>" class="nav-link cart-link <?php echo e(request()->routeIs('cart.index') ? 'active' : ''); ?>">
                        Keranjang
                        <?php 
                            $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count(); 
                        ?> 
                        <?php if($cartCount > 0): ?> 
                            <span class="cart-badge"><?php echo e($cartCount); ?></span> 
                        <?php endif; ?>
                    </a>
                    <a href="<?php echo e(route('customer.profile')); ?>" class="nav-link <?php echo e(request()->routeIs('customer.profile') ? 'active' : ''); ?>">Profil</a>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline-form">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-outline btn-sm">Logout</button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-secondary btn-sm">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <?php endif; ?>

    <main class="main-content">
        <?php if(session('success')): ?>
            <div class="container">
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="container">
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; 2024 Cresta Mandala Bhakti Merch. All rights reserved.</p>
        </div>
    </footer>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH E:\Project\Freelance Projects\merch\resources\views/layouts/app.blade.php ENDPATH**/ ?>