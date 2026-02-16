<?php $__env->startSection('title'); ?>
    <?php echo e($value->name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="/assets/admin/dist/libs/dropzone/dist/dropzone.css?1684106062" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content-title'); ?>
    <div class="col">
        <h2 class="page-title">
            <?php echo e($value->name); ?> kaydını düzenle
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="dropdown">
            <a href="<?php echo e(route('admin.value.create', $value->type->id)); ?>" class="btn btn-primary">
                Yeni <?php echo e($value->type->single_name); ?> Oluştur
            </a>
        </div>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="dropdown">
            <button class="btn btn-primart dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <?php echo e($value->language->text); ?>

            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php $__currentLoopData = $brothers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a class="dropdown-item"
                        href="<?php echo e(route('admin.value.edit', [$b->id, $type->id])); ?>"><?php echo e($b->language->text); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <form method="POST" action="<?php echo e(route('admin.value.update', $value->id)); ?>" autocomplete="off" class="card"
        enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="card-header">
            <div class="card-title">
                <?php echo e($value->name); ?> kaydını düzenle
            </div>
        </div>
        <div class="card-body">
            <div class="row gy-2">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="name" class="form-label">Adı</label>
                        <input type="text" required class="form-control" value="<?php echo e($value->name); ?>" id="name"
                            name="value_name">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="name" class="form-label">Menü</label>
                        <select type="text" name="menu_id[]" class="form-select" placeholder="Menü Seçiniz"
                            id="menu_id" value="" multiple>
                            <?php $__currentLoopData = $selectableMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $selected = '';
                                    if ($value->menus) {
                                        foreach ($value->menus as $m) {
                                            if ($m->menu->id == $menu->id) {
                                                $selected = 'selected';
                                            }
                                        }
                                    }
                                ?>
                                <option value="<?php echo e($menu->id); ?>" <?php echo e($selected); ?>><?php echo e($menu->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <?php echo $__env->make('admin.partials.cms.createInputs', [
                    'fields' => $value->type->fields,
                    'FieldValues' => $detail,
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </div>
    </form>

    <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal modal-blur fade" id="uploadFileModal-<?php echo e($file->key); ?>" tabindex="-1" style="display: none;"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo e($file->name); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="dropzone" id="dropzone-<?php echo e($file->key); ?>">
                            <div class="fallback">
                                <input name="file" type="file" />
                            </div>
                            <div class="dz-message">
                                <h3 class="dropzone-msg-title">Dosyalarınızı Sürükleyin</h3>
                                <span class="dropzone-msg-desc"><?php echo e($file->name); ?> için dosya yükle</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Kapat</button>
                        
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="/assets/admin/dist/libs/tinymce/tinymce.min.js" defer></script>
    <script src="/assets/admin/dist/libs/dropzone/dist/dropzone-min.js" defer></script>
    <script src="/assets/admin/dist/libs/tom-select/dist/js/tom-select.base.min.js" defer></script>
    <script src="/assets/admin/dist/custom-js/sortable.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var menu_id;
            window.TomSelect && (new TomSelect(menu_id = document.getElementById('menu_id'), {
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
            const fillFileContainer = (selector, data) => {
                let fileContainer = document.getElementById(`file-selector-${selector}`);
                let fileHiddenInputsContainer = document.getElementById(`file-hidden-inputs-${selector}`);
                let defaultLanguage = languages.find(l => l.is_default);
                let showedFiles = data.filter(d => d.language_id === defaultLanguage.id);
                let imageExts = ["png", "jpg", "jpeg", "jfif", "webp"];
                let html = "";
                let svgicon = `
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file w-100 h-50" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                </svg>`;
                showedFiles.forEach(element => {
                    html += `
                    <div class="d-flex flex-column align-items-center border p-2" id="file-dom-selector-${element.id}" data-id="${element.id}">
                        <div class="h-100 d-flex align-items-center">
                            ${imageExts.includes(element.extension) ? `<img class="img-fluid" width="85" src="${element.path}"></img>` : svgicon}
                        </div>
                        <p>${element.original_name}</p>
                        <div class="">
                            <a href="#" class="btn btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrows-move m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M18 9l3 3l-3 3"></path>
                                    <path d="M15 12h6"></path>
                                    <path d="M6 9l-3 3l3 3"></path>
                                    <path d="M3 12h6"></path>
                                    <path d="M9 18l3 3l3 -3"></path>
                                    <path d="M12 15v6"></path>
                                    <path d="M15 6l-3 -3l-3 3"></path>
                                    <path d="M12 3v6"></path>
                                </svg>
                            </a>
                            <button type="button" data-selector="${element.id}" class="btn btn-danger remove-file">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 7l16 0"></path>
                                    <path d="M10 11l0 6"></path>
                                    <path d="M14 11l0 6"></path>
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    `;
                });

                fileContainer.innerHTML = fileContainer.innerHTML + html;
                let inputs = "";
                data.forEach(item => {
                    inputs +=
                        `<input name="fields[${selector}][${languages.find(l => l.id === item.language_id).key}][]" value="${item.id}" id="hidden-file-input-${item.id}" />`;
                });
                fileHiddenInputsContainer.innerHTML = fileHiddenInputsContainer.innerHTML + inputs;
            }

            $(document).on("click", ".remove-file", function() {
                if (!confirm("Silmek istediğinize emin misini?")) {
                    return;
                }
                let dataFieldType = this.getAttribute('data-field-type');
                let fieldName = this.getAttribute('data-field-name');
                let id = this.getAttribute('data-selector');
                let fileElement = document.getElementById("file-dom-selector-" + id);
                let fileHiddenInput = document.getElementById("hidden-file-input-" + id);
                fileElement.remove();
                fileHiddenInput.remove();
                let url = `<?php echo e(route('admin.removeFile')); ?>/${id}`
                $.ajax({
                    url: url,
                    method: "GET",
                    success: function(res) {
                        if (dataFieldType == "single") {
                            document.getElementById('showDropzoneButton-' + fieldName).classList
                                .remove('disabled');
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });

            <?php $__currentLoopData = $editors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $editor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                let options_<?php echo e($key); ?> = {
                    language: 'tr',
                    selector: '#tinymce-<?php echo e($editor->key); ?>',
                    height: 300,
                    plugins: 'searchreplace autolink directionality visualblocks visualchars image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount charmap emoticons  autosave codeeditor',
                    toolbar: "undo redo print spellcheckdialog formatpainter | blocks fontfamily fontsize | bold italic underline forecolor backcolor | link image | alignleft aligncenter alignright alignjustify | codeeditor ",
                    codeeditor_themes_pack: "twilight merbivore dawn kuroir",
                    codeeditor_wrap_mode: true,
                    codeeditor_font_size: 12,
                    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }'
                }
                if (localStorage.getItem("tablerTheme") === 'dark') {
                    options.skin = 'oxide-dark';
                    options.content_css = 'dark';
                }
                tinyMCE.init(options_<?php echo e($key); ?>);
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                var Dropzone_<?php echo e($file->key); ?> = new Dropzone("#dropzone-<?php echo e($file->key); ?>", {
                    autoProcessQueue: true,
                    url: "<?php echo e(route('admin.saveFiles', ['selector' => $file->key])); ?>",
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'edit_mode': true,
                        'value_id': <?php echo e($value->id); ?>,
                    },
                    paramName: "file",
                    <?php if($file->type == 'input|file|single'): ?>
                        maxFiles: 1,
                    <?php endif; ?>
                    parallelUploads: 10,
                    timeout: 0,
                    addRemoveLinks: true,
                    uploadMultiple: true,
                    acceptedFiles: "<?php echo e($file->values != '' ? $file->values : '.jpeg,.jpg,.png'); ?>",
                    dictDefaultMessage: 'Yüklemek istediğiniz dosyaları buraya bırakın',
                    dictFallbackMessage: "Tarayıcınız sürükle bırak yüklemelerini desteklemiyor",
                    dictFileTooBig: "Dosya boyutu çok büyük. Yükleyebileceğiniz en büyük dosya boyutu: 50 Mb.",
                    dictInvalidFileType: "Desteklenmeyen dosya tipi!",
                    dictResponseError: "Sunucu hatası.",
                    dictCancelUpload: "Yüklemeyi İptal Et",
                    dictUploadCanceled: "Yükleme iptal edildi",
                    dictCancelUploadConfirmation: "Bu yüklemeyi iptal etmek istediğinizden emin misiniz ?",
                    dictRemoveFile: "Dosyayı Sil",
                    dictMaxFilesExceeded: "Başka dosya yükleyemezsiniz.",
                    maxFilesize: 50, // MB
                    accept: function(file, done) {
                        done();
                    },
                    successmultiple: function(file, response) {
                        fillFileContainer(response.selector, response.files);
                    }
                });

                let list_<?php echo e($file->key); ?> = document.getElementById('file-selector-<?php echo e($file->key); ?>');
                var sortable_<?php echo e($file->key); ?> = Sortable.create(list_<?php echo e($file->key); ?>, {
                    animation: 150,
                    onChange: function(evt) {
                        let currentOrder_<?php echo e($file->key); ?> = sortable_<?php echo e($file->key); ?>.toArray();
                        $.ajax({
                            method: "GET",
                            url: "<?php echo e(route('admin.file.sort')); ?>",
                            data: {
                                data: currentOrder_<?php echo e($file->key); ?>

                            }
                        });
                    }
                });
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/admin/values/edit.blade.php ENDPATH**/ ?>