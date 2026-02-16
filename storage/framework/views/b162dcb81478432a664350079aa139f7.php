    <div class="collapse navbar-collapse navbar-transparent" id="sidebar-menu">
        <div class="navbar-nav pt-lg-3">
            <ul class="navbar-nav">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Menü Yönetimi')): ?>
                    <li class="nav-item <?php echo e(routeIsActive('admin.menu.index')); ?>">
                        <a class="nav-link" href="<?php echo e(route('admin.menu.index')); ?>">
                            <span class="nav-link-title">
                                Menüler
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('İçerik Yönetimi')): ?>
                    <?php $__currentLoopData = session('defaultDatas')['types']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!$type->is_hidden): ?>
                            <li class="nav-item <?php echo e(routeIsActive('admin.value.index', $type->id)); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.value.index', $type->id)); ?>">
                                    <span class="nav-link-title">
                                        <?php echo e($type->multiple_name); ?>

                                    </span>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Rol Yönetimi')): ?>
                    <li
                        class="nav-item <?php echo e(routeIsActive('admin.permissions.index')); ?> <?php echo e(routeIsActive('admin.permissions.edit')); ?>">
                        <a class="nav-link" href="<?php echo e(route('admin.permissions.index')); ?>">
                            <span class="nav-link-title">
                                Roller
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('İçerik Yönetimi')): ?>
                    <li class="nav-item <?php echo e(routeIsActive('admin.website-settings.edit')); ?>">
                        <a class="nav-link" href="<?php echo e(route('admin.website-settings.edit')); ?>">
                            <span class="nav-link-title">
                                Ayarlar
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Kullanıcı Yönetimi')): ?>
                    <li
                        class="nav-item <?php echo e(routeIsActive('admin.user.index')); ?> <?php echo e(routeIsActive('admin.user.create')); ?> <?php echo e(routeIsActive('admin.user.edit')); ?>">
                        <a class="nav-link" href="<?php echo e(route('admin.user.index')); ?>">
                            <span class="nav-link-title">
                                Kullanıcılar
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Dil Yönetimi')): ?>
                    <li
                        class="nav-item <?php echo e(routeIsActive('admin.language.index')); ?> <?php echo e(routeIsActive('admin.language.create')); ?> <?php echo e(routeIsActive('admin.language.edit')); ?>">
                        <a class="nav-link" href="<?php echo e(route('admin.language.index')); ?>">
                            <span class="nav-link-title">
                                Diller
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Tip Yönetimi')): ?>
                    <li
                        class="nav-item <?php echo e(routeIsActive('admin.type.index')); ?> <?php echo e(routeIsActive('admin.type.create')); ?> <?php echo e(routeIsActive('admin.type.edit')); ?>">
                        <a class="nav-link" href="<?php echo e(route('admin.type.index')); ?>">
                            <span class="nav-link-title">
                                Tipler
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Çeviri Yönetimi')): ?>
                    <li class="nav-item <?php echo e(routeIsActive('admin.translation.index')); ?>">
                        <a class="nav-link" href="<?php echo e(route('admin.translation.index')); ?>">
                            <span class="nav-link-title">
                                Çeviriler
                            </span>
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item mt-auto d-none d-lg-block border-top btn btn-primary">
                    <a class="nav-link" href="<?php echo e(route('logout')); ?>">
                        <span class="nav-link-title">
                            Çıkış Yap
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
<?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/admin/partials/menu.blade.php ENDPATH**/ ?>