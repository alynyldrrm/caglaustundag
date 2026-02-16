<?php $__env->startSection('title'); ?>
    <?php echo e($type->multiple_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content-title'); ?>
    <div class="col">
        <h2 class="page-title">
            <?php echo e($type->multiple_name); ?>

        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <a href="<?php echo e(route('admin.value.create', $type->id)); ?>" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 5l0 14"></path>
                <path d="M5 12l14 0"></path>
            </svg>
            Yeni <?php echo e($type->single_name); ?> Ekle
        </a>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-0 col-lg-10"></div>
                    <div class="col-12 col-lg-2">
                        <form class="form-group" id="langForm" method="GET"
                            action="<?php echo e(route('admin.value.index', $type->id)); ?>">
                            <label for="lang" class="form-label">Dil</label>
                            <select name="lang" id="langSelect" class="form-select">
                                <?php $__currentLoopData = $langs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php echo e(request('lang') == $lang->id ? 'selected' : ''); ?>

                                        value="<?php echo e($lang->id); ?>">
                                        <?php echo e($lang->text); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-vcenter table-mobile-md card-table">
                    <thead>
                        <tr>
                            <th>Ad</th>
                            <?php if($type->model == 'App\Models\Value'): ?>
                                <th>Menü</th>
                            <?php endif; ?>
                            <?php if($type->model == 'App\Models\ContactSetting'): ?>
                                <th>Telefon</th>
                            <?php endif; ?>
                            <th>Eklenme Tarihi</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody id="valueList">
                        <?php $__empty_1 = true; $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr data-id="<?php echo e($value->id); ?>">
                                <td data-label="Ad">
                                    <div class="text-muted"><?php echo e($value->name); ?></div>
                                </td>
                             <?php if($type->model == 'App\Models\Value'): ?>
                                    <td data-label="Menü">
                                        <?php
                                            $menuText = '';
                                            if (isset($value->menus)) {
                                                foreach ($value->menus as $m) {
                                                    if ($m->menu) {
                                                        $menuText .="<a href='" . route('admin.menu.edit', $m->menu->id) ."'>" .
                                                            $m->menu->name .
                                                            '</a><br>';
                                                    }
                                                }
                                            }

                                        ?>
                                        <div class="text-muted"><?php echo $menuText; ?></div>
                                    </td>
                                <?php endif; ?>
                                <?php if($type->model == 'App\Models\ContactSetting'): ?>
                                    <td><?php echo e($value->phone ?? '-'); ?></td>
                                <?php endif; ?>
                                <td data-label="Tarih">
                                    <div class="text-muted">
                                        <?php echo e(Carbon\Carbon::parse($value->created_at)->format('d.m.Y')); ?>

                                    </div>
                                </td>
                                <td>
                                    <div class="btn-list flex-nowrap">
                                        <?php if($type->model == 'App\Models\Form'): ?>
                                            <a href="<?php echo e(route('admin.form.show', $value->id)); ?>" class="btn btn-warning">
                                                Cevapları Listele
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?php echo e(route('admin.value.edit', [$value->id, $type->id])); ?>"
                                            class="btn btn-secondary">
                                            Düzenle
                                        </a>
                                        <a href="<?php echo e(route('admin.value.destroy', [$value->id, $type->id])); ?>"
                                            onclick="return confirm('Silmek istediğinize emin misiniz?')"
                                            class="btn btn-danger">
                                            Sil
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center">
                                    Kayıt Bulunamadı
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            
            <?php if(count($values) > 0): ?>
                <ul class="pagination justify-center justify-content-lg-end">
                    <li class="page-item">
                        <a class="page-link" href="<?php echo e($values->previousPageUrl()); ?>" tabindex="-1" aria-disabled="true">
                            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M15 6l-6 6l6 6"></path>
                            </svg>
                        </a>
                    </li>
                    <?php
                        $x = 0;
                    ?>
                    <?php for($i = 1; $i <= $values->lastPage(); $i++): ?>
                        <?php if($i == 1 || $i == $values->lastPage() || ($i >= $values->currentPage() - 1 && $i <= $values->currentPage() + 1)): ?>
                            <li class="page-item <?php echo e(request('page') == $i ? 'active' : null); ?>">
                                <a class="page-link " href="<?php echo e($values->url($i)); ?>"><?php echo e($i); ?></a>
                            </li>
                        <?php elseif($i == $values->lastPage() - 1): ?>
                            <li class="page-item pe-none">
                                <a class="page-link" href="#">...</a>
                            </li>
                        <?php endif; ?>
                        <?php if($values->currentPage() - 1 >= 3): ?>
                            <?php if($x == 0): ?>
                                <li class="page-item pe-none">
                                    <a class="page-link" href="#">...</a>
                                </li>
                            <?php endif; ?>
                            <?php
                                $x = 1;
                            ?>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo e($values->nextPageUrl()); ?>">
                            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M9 6l6 6l-6 6"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="page-item <?php echo e(request('all') ? 'active' : ''); ?>">
                        <a class="page-link" href="<?php echo e(route('admin.value.index', [$type->id, 'all' => true])); ?>">
                            Tümü
                        </a>
                    </li>
                </ul>
            <?php endif; ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="/assets/admin/dist/custom-js/sortable.js"></script>
    <script>
        const langSelect = document.getElementById('langSelect');
        const langForm = document.getElementById('langForm');
        langSelect.addEventListener('change', () => {
            langForm.submit();
        });

        let list = document.getElementById('valueList');
        var sortable = Sortable.create(list, {
            animation: 150,
            onChange: function(evt) {
                let currentOrder = sortable.toArray();
                $.ajax({
                    method: "GET",
                    url: "<?php echo e(route('admin.value.sort', $type->id)); ?>",
                    data: {
                        data: currentOrder
                    }
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/admin/values/index.blade.php ENDPATH**/ ?>