<?php $__env->startSection('title'); ?>
    <?php echo e($menu->name); ?> adlı menüyü düzenle
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content-title'); ?>
    <div class="col">
        <h2 class="page-title">
            <?php echo e($menu->name); ?> adlı menüyü düzenle
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="dropdown">
            <button class="btn btn-primart dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <?php echo e($menu->language->text); ?>

            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php $__currentLoopData = $brothers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a class="dropdown-item" href="<?php echo e(route('admin.menu.edit', $b->id)); ?>"><?php echo e($b->language->text); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form method="POST" action="<?php echo e(route('admin.menu.update', $menu->id)); ?>" autocomplete="off" class="card"
        enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="card-header">
            <div class="card-title">
                <?php echo e($menu->name); ?> adlı menüyü düzenle
            </div>
        </div>
        <div class="card-body">
            <div class="row gy-2">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="name" class="form-label">Ad</label>
                        <input type="text" class="form-control" value="<?php echo e($menu->name); ?>" id="name"
                            name="name">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="type_id" class="form-label">Tip</label>
                        <select type="text" class="form-select" id="type_id" name="type_id">
                            <option value="false">Yok</option>
                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php echo e($menu->type ? ($menu->type->id == $t->id ? 'selected' : '') : ''); ?>

                                    value="<?php echo e($t->id); ?>">
                                    <?php echo e($t->multiple_name); ?>

                                    <?php if($t->is_hidden): ?>
                                        <small>
                                            (Gizli)
                                        </small>
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="parent_id" class="form-label">Üst Menü</label>
                        <select type="text" class="form-select" id="parent_id" name="parent_id">
                            <option value="false">Yok</option>
                            <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php echo e($menu->parent_id == $m->id ? 'selected' : ''); ?> value="<?php echo e($m->id); ?>">
                                    <?php echo e($m->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="url" class="form-label">Url</label>
                        <input type="text" class="form-control" value="<?php echo e($menu->url); ?>" id="url"
                            name="url">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="is_hidden" class="form-label">Gizlimi </label>
                        <div class="d-flex gap-4">
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="radio" value="true"
                                    <?php echo e($menu->is_hidden ? 'checked' : ''); ?> name="is_hidden">
                                <span class="form-check-label">Evet</span>
                            </label>
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="radio" value="false"
                                    <?php echo e($menu->is_hidden ? '' : 'checked'); ?> name="is_hidden">
                                <span class="form-check-label">Hayır</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="description" class="form-label">Menü Açıklaması</label>
                        <textarea name="description" id="description" class="form-control"><?php echo e($menu->description); ?></textarea>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="imagePath" class="form-label">Resim</label>
                        <input type="file" <?php echo e($menu->imagePath ? 'disabled' : ''); ?> class="form-control" id="imagePath"
                            name="imagePath">
                    </div>
                    <?php if($menu->imagePath): ?>
                        <div
                            class="w-100 d-flex text-center flex-column justify-content-center align-items-center gap-3 mt-4">
                            <img class="img-fluid" style="max-width:200px;" src="/files/menuImages/<?php echo e($menu->imagePath); ?>"
                                alt="">
                            <a href="<?php echo e(route('admin.menu.destroyFile', ['image', $menu->id])); ?>"
                                class="btn btn-danger">Sil</a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="filePath" class="form-label">Dosya</label>
                        <input type="file" <?php echo e($menu->filePath ? 'disabled' : ''); ?> class="form-control"
                            id="filePath" name="filePath">
                    </div>
                    <?php if($menu->filePath): ?>
                        <div
                            class="w-100 d-flex text-center flex-column justify-content-center align-items-center gap-3 mt-4">
                            <a class="btn btn-warning" target="_blank"
                                href="/files/menuFiles/<?php echo e($menu->filePath); ?>">Göster</a>
                            <a href="<?php echo e(route('admin.menu.destroyFile', ['file', $menu->id])); ?>"
                                class="btn btn-danger">Sil</a>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="/assets/admin/dist/libs/tom-select/dist/js/tom-select.base.min.js?1684106062" defer></script>
    <script src="/assets/admin/dist/libs/tinymce/tinymce.min.js" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var parent_id, type_id;
            window.TomSelect && (new TomSelect(parent_id = document.getElementById('parent_id'), {
                copyClassesToDropdown: false,
                dropdownParent: 'body',
                controlInput: '<input>',
                render: {
                    item: function(data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data
                                .customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                    option: function(data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data
                                .customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                },
            }));
            window.TomSelect && (new TomSelect(type_id = document.getElementById('type_id'), {
                copyClassesToDropdown: false,
                dropdownParent: 'body',
                controlInput: '<input>',
                render: {
                    item: function(data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data
                                .customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                    option: function(data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data
                                .customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                },
            }));

            let options = {
                selector: '#description',
                height: 300,
                menubar: false,
                statusbar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }'
            }
            if (localStorage.getItem("tablerTheme") === 'dark') {
                options.skin = 'oxide-dark';
                options.content_css = 'dark';
            }
            tinyMCE.init(options);
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/admin/menu/edit.blade.php ENDPATH**/ ?>