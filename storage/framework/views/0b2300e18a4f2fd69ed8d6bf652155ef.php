<?php $__env->startSection('title', 'Sistem Kullanıcıları'); ?>
<?php $__env->startSection('content-title'); ?>
    <div class="col">
        <h2 class="page-title">
            Kullanıcılar
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <a href="<?php echo e(route('admin.user.create')); ?>" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 5l0 14"></path>
                <path d="M5 12l14 0"></path>
            </svg>
            Kullanıcı Ekle
        </a>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter table-mobile-md card-table">
                <thead>
                    <tr>
                        <th>Ad</th>
                        <th>E-Mail</th>
                        <th>Telefon</th>
                        <th>Rol</th>
                        <th>Eklenme Tarihi</th>
                        <th class="w-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="Ad">
                                <div class="text-muted"><?php echo e($user->name); ?></div>
                            </td>
                            <td data-label="E-mail">
                                <div class="text-muted"><?php echo e($user->email); ?></div>
                            </td>
                            <td data-label="Telefon">
                                <div class="text-muted"><?php echo e($user->phone); ?></div>
                            </td>
                            <td data-label="Rol">
                                <div class="text-muted"><?php echo e(isset($user->roles[0]) ? $user->roles[0]->name : '-'); ?></div>
                            </td>
                            <td data-label="Eklenme Tarihi">
                                <div class="text-muted"><?php echo e(Carbon\Carbon::parse($user->created_at)->format('d.m.Y')); ?></div>
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a href="<?php echo e(route('admin.user.edit', $user->id)); ?>" class="btn btn-secondary">
                                        Düzenle
                                    </a>
                                    <?php if(auth()->user()->id != $user->id): ?>
                                        <button
                                            onclick="confirm('Silmek istediğinize emin misiniz?') ? window.location.href = '<?php echo e(route('admin.user.destroy', $user->id)); ?>' : ''"
                                            class="btn btn-danger">
                                            Sil
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center">
                                Kayıt Bulunamadı
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/admin/users/index.blade.php ENDPATH**/ ?>