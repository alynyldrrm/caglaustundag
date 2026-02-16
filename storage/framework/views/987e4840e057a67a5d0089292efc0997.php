<?php $__env->startSection('title'); ?>
    <?php echo e($type->single_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content-title'); ?>
    <div class="col">
        <h2 class="page-title">
            <?php echo e($setting->name); ?> kaydını düzenle
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="dropdown">
            <a href="<?php echo e(route('admin.value.create', $setting->type->id)); ?>" class="btn btn-primary">
                Yeni <?php echo e($setting->type->single_name); ?> Oluştur
            </A>
        </div>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="dropdown">
            <button class="btn btn-primart dropdown-toggle" type="button" id="" data-bs-toggle="dropdown"
                aria-expanded="false">
                <?php echo e($setting->language->text); ?>

            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                <?php $__currentLoopData = $brothers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a class="dropdown-item"
                            href="<?php echo e(route('admin.value.edit', [$b->id, $type->id])); ?>"><?php echo e($b->language->text); ?></a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form method="POST" action="<?php echo e(route('admin.contact-settings.update', $setting->id)); ?>" autocomplete="off"
        class="card">
        <?php echo csrf_field(); ?>
        <div class="card-header">
            <div class="card-title">
                <?php echo e($setting->name); ?> kaydını düzenle
            </div>
        </div>
        <div class="card-body">
            <div class="row gy-2">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="title" class="form-label">Adı</label>
                        <input type="text" class="form-control" value="<?php echo e($setting->name); ?>" id="name"
                            name="name">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="city" class="form-label">İl</label>
                        <input type="text" class="form-control" value="<?php echo e($setting->city); ?>" id="city"
                            name="city">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="town" class="form-label">İlçe</label>
                        <input type="text" class="form-control" value="<?php echo e($setting->town); ?>" id="town"
                            name="town">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="phone" class="form-label">Telefon</label>
                        <input type="text" class="form-control" value="<?php echo e($setting->phone); ?>" id="phone"
                            name="phone">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="text" class="form-label">E-Mail</label>
                        <input type="email" class="form-control" value="<?php echo e($setting->email); ?>" id="email"
                            name="email">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="text" class="form-label">Adres</label>
                        <textarea name="address" id="address" class="form-control"><?php echo e($setting->address); ?></textarea>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="text" class="form-label">Harita Yerleştirme Kodu</label>
                        <textarea name="iframe_code" id="iframe_code" class="form-control"><?php echo e($setting->iframe_code); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/admin/contactSettings/edit.blade.php ENDPATH**/ ?>