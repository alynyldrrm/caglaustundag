<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="<?php echo e(route('admin.menu.index')); ?>">
                <img src="/assets/admin/logo.png" width="110" height="32" alt="Tabler"
                    class="navbar-brand-image">
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <span class="avatar avatar-sm"
                        style="background-image: url(/assets/admin/logo.png);background-size: contain;"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div><?php echo e(auth()->user()->name); ?></div>
                        <div class="mt-1 small text-muted"></div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="<?php echo e(route('logout')); ?>" class="dropdown-item">Çıkış Yap</a>
                </div>
            </div>
        </div>
        <?php echo $__env->make('admin.partials.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</aside>
<?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/admin/partials/header.blade.php ENDPATH**/ ?>