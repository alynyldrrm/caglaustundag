<?php
    $imageExts = ['png', 'jpg', 'jpeg', 'jfif', 'webp'];
    $svgicon = '
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file w-100 h-50" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
            </svg>';
?>
<?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $attributes = '';
        $values = explode(',', $field->values);
        $attr = explode(',', $field->attr);
        foreach ($attr as $att) {
            $attributes .= $att . ' ';
        }
        $inputParams = explode('|', $field->type);

    ?>
    <div class="col-12">
        <div class="form-group">
            <label for="<?php echo e($field->key); ?>" class="form-label"><?php echo e($field->name); ?></label>
            <?php if($inputParams[0] == 'input'): ?>
                <?php if($inputParams[1] == 'text'): ?>
                    <input type="text" class="form-control"
                        value="<?php echo e(isset($FieldValues) ? (isset($FieldValues['fields'][$field->key]) ? $FieldValues['fields'][$field->key] : '') : ''); ?>"
                        id="<?php echo e($field->key); ?>" name="fields[<?php echo e($field->key); ?>]" <?php echo e($attributes); ?>>
                <?php elseif($inputParams[1] == 'number'): ?>
                    <input type="number" class="form-control"
                        value="<?php echo e(isset($FieldValues) ? (isset($FieldValues['fields'][$field->key]) ? $FieldValues['fields'][$field->key] : '') : ''); ?>"
                        id="<?php echo e($field->key); ?>" name="fields[<?php echo e($field->key); ?>]" <?php echo e($attributes); ?>>
                <?php elseif($inputParams[1] == 'email'): ?>
                    <input type="email" class="form-control"
                        value="<?php echo e(isset($FieldValues) ? (isset($FieldValues['fields'][$field->key]) ? $FieldValues['fields'][$field->key] : '') : ''); ?>"
                        id="<?php echo e($field->key); ?>" name="fields[<?php echo e($field->key); ?>]" <?php echo e($attributes); ?>>
                <?php elseif($inputParams[1] == 'password'): ?>
                    <input type="password" class="form-control"
                        value="<?php echo e(isset($FieldValues) ? (isset($FieldValues['fields'][$field->key]) ? $FieldValues['fields'][$field->key] : '') : ''); ?>"
                        id="<?php echo e($field->key); ?>" name="fields[<?php echo e($field->key); ?>]" <?php echo e($attributes); ?>>
                <?php elseif($inputParams[1] == 'url'): ?>
                    <input type="url" class="form-control"
                        value="<?php echo e(isset($FieldValues) ? (isset($FieldValues['fields'][$field->key]) ? $FieldValues['fields'][$field->key] : '') : ''); ?>"
                        id="<?php echo e($field->key); ?>" name="fields[<?php echo e($field->key); ?>]" <?php echo e($attributes); ?>>
                <?php elseif($inputParams[1] == 'date'): ?>
                    <input type="date" class="form-control"
                        value="<?php echo e(isset($FieldValues) ? (isset($FieldValues['fields'][$field->key]) ? Carbon\Carbon::parse($FieldValues['fields'][$field->key])->format('Y-m-d') : '') : ''); ?>"
                        id="<?php echo e($field->key); ?>" name="fields[<?php echo e($field->key); ?>]" <?php echo e($attributes); ?>>
                <?php elseif($inputParams[1] == 'checkbox'): ?>
                    <div class="d-flex gap-4">
                        <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $checked = '';
                                if (isset($FieldValues) && isset($FieldValues['fields'][$field->key]) && $FieldValues['fields'][$field->key] == $value) {
                                    $checked = 'checked';
                                }
                            ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fields[<?php echo e($field->key); ?>]"
                                    value="<?php echo e($value); ?>" <?php echo e($checked); ?>

                                    id="<?php echo e($value); ?>-<?php echo e($key); ?>" <?php echo e($attributes); ?>>
                                <label class="form-check-label" for="<?php echo e($value); ?>-<?php echo e($key); ?>">
                                    <?php echo e($value); ?>

                                </label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php elseif($inputParams[1] == 'radio'): ?>
                    <div class="d-flex gap-4">
                        <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $checked = '';
                                if (isset($FieldValues) && isset($FieldValues['fields'][$field->key]) && $FieldValues['fields'][$field->key] == $value) {
                                    $checked = 'checked';
                                }
                            ?>
                            <div class="form-check">
                                <input class="form-check-input" <?php echo e($checked); ?> type="radio"
                                    name="fields[<?php echo e($field->key); ?>]" value="<?php echo e($value); ?>"
                                    id="<?php echo e($value); ?>-<?php echo e($key); ?>" <?php echo e($attributes); ?>>
                                <label class="form-check-label" for="<?php echo e($value); ?>-<?php echo e($key); ?>">
                                    <?php echo e($value); ?>

                                </label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php elseif($inputParams[1] == 'file' && $inputParams[2] == 'single'): ?>
                    <div class="d-flex align-items-center gap-4">
                        <div class="d-none" id="file-hidden-inputs-<?php echo e($field->key); ?>">
                            <?php if(isset($FieldValues['fields'][$field->key]) && $FieldValues['fields'][$field->key] != null): ?>
                                <?php $__currentLoopData = $FieldValues['fields'][$field->key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <input name="fields[<?php echo e($field->key); ?>][<?php echo e($image['language']['key']); ?>][]"
                                        value="<?php echo e($image['id']); ?>" id="hidden-file-input-<?php echo e($image['id']); ?>" />
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <div class="file-container align-items-stretch row row-cols-auto gap-3"
                            id="file-selector-<?php echo e($field->key); ?>">
                            <?php if(isset($FieldValues['fields'][$field->key]) && $FieldValues['fields'][$field->key] != null): ?>
                                <?php $__currentLoopData = $FieldValues['fields'][$field->key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="d-flex flex-column align-items-center border p-2"
                                        id="file-dom-selector-<?php echo e($image['id']); ?>" data-id="<?php echo e($image['id']); ?>">
                                        <div class="h-100 d-flex align-items-center">
                                            <?php if(in_array($image['extension'], $imageExts)): ?>
                                                <img class="img-fluid" width="85" src="<?php echo e($image['path']); ?>" />
                                            <?php else: ?>
                                                <?php echo $svgicon; ?>

                                            <?php endif; ?>
                                        </div>
                                        <p><?php echo e($image['original_name']); ?></p>
                                        <div class="">
                                            <a href="#" class="btn btn-secondary">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-arrows-move m-0" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
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
                                            <button type="button" data-field-type="single"
                                                data-field-name="<?php echo e($field->key); ?>"
                                                data-selector="<?php echo e($image['id']); ?>" class="btn btn-danger remove-file">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-trash m-0" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
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
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <?php
                            $disabled = '';
                            if (isset($FieldValues['fields'][$field->key]) && $FieldValues['fields'][$field->key] != '' && count($FieldValues['fields'][$field->key]) > 0) {
                                $disabled = 'disabled';
                            }
                        ?>
                        <a href="#" id="showDropzoneButton-<?php echo e($field->key); ?>"
                            class="btn btn-primary <?php echo e($disabled); ?>" data-bs-toggle="modal"
                            data-bs-target="#uploadFileModal-<?php echo e($field->key); ?>">
                            <svg style="margin:0 !important;" xmlns="http://www.w3.org/2000/svg" class="icon"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                        </a>
                    </div>
                <?php elseif($inputParams[1] == 'file' && $inputParams[2] == 'multiple'): ?>
                    <div class="d-flex align-items-center gap-4">
                        <div class="d-none" id="file-hidden-inputs-<?php echo e($field->key); ?>">
                            <?php if(isset($FieldValues['fields'][$field->key]) && $FieldValues['fields'][$field->key] != null): ?>
                                <?php $__currentLoopData = $FieldValues['fields'][$field->key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <input name="fields[<?php echo e($field->key); ?>][<?php echo e($image['language']['key']); ?>][]"
                                        value="<?php echo e($image['id']); ?>" id="hidden-file-input-<?php echo e($image['id']); ?>" />
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <div class="file-container  align-items-stretch row row-cols-auto gap-3"
                            id="file-selector-<?php echo e($field->key); ?>">
                            <?php if(isset($FieldValues['fields'][$field->key]) && $FieldValues['fields'][$field->key] != null): ?>
                                <?php $__currentLoopData = $FieldValues['fields'][$field->key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="d-flex flex-column align-items-center border p-2"
                                        id="file-dom-selector-<?php echo e($image['id']); ?>" data-id="<?php echo e($image['id']); ?>">
                                        <div class="h-100 d-flex align-items-center">
                                            <?php if(in_array($image['extension'], $imageExts)): ?>
                                                <img class="img-fluid" width="85" src="<?php echo e($image['path']); ?>" />
                                            <?php else: ?>
                                                <?php echo $svgicon; ?>

                                            <?php endif; ?>
                                        </div>
                                        <p><?php echo e($image['original_name']); ?></p>
                                        <div class="">
                                            <a href="#" class="btn btn-secondary">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-arrows-move m-0"
                                                    width="24" height="24" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
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
                                            <button type="button" data-selector="<?php echo e($image['id']); ?>"
                                                class="btn btn-danger remove-file">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-trash m-0" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
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
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>

                        <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#uploadFileModal-<?php echo e($field->key); ?>">
                            <svg style="margin:0 !important;" xmlns="http://www.w3.org/2000/svg" class="icon"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if($inputParams[0] == 'textarea'): ?>
                <?php
                    $textAreaValue = '';
                    if (isset($FieldValues) && isset($FieldValues['fields'][$field->key])) {
                        $textAreaValue = $FieldValues['fields'][$field->key];
                    }
                ?>
                <?php if($inputParams[1] == 'textarea'): ?>
                    <textarea name="fields[<?php echo e($field->key); ?>]" id="<?php echo e($field->key); ?>" <?php echo e($attributes); ?> class="form-control"><?php echo $textAreaValue; ?></textarea>
                <?php elseif($inputParams[1] == 'editor'): ?>
                    <textarea name="fields[<?php echo e($field->key); ?>]" id="tinymce-<?php echo e($field->key); ?>" name="fields[<?php echo e($field->key); ?>]"
                        <?php echo e($attributes); ?>><?php echo $textAreaValue; ?></textarea>
                <?php endif; ?>
            <?php endif; ?>
            <?php if($inputParams[0] == 'select'): ?>
                <select name="fields[<?php echo e($field->key); ?>]" id="<?php echo e($field->key); ?>" <?php echo e($attributes); ?>

                    class="form-select">
                    <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $selected = '';
                            if (isset($FieldValues) && isset($FieldValues['fields'][$field->key]) && $FieldValues['fields'][$field->key] == $v) {
                                $selected = 'selected';
                            }
                        ?>
                        <option value="<?php echo e($v); ?>" <?php echo e($selected); ?>><?php echo e($v); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/admin/partials/cms/createInputs.blade.php ENDPATH**/ ?>