@extends('admin.layout')
@section('title')
    {{ $value->name }}
@endsection
@section('css')
    <link href="/assets/admin/dist/libs/dropzone/dist/dropzone.css?1684106062" rel="stylesheet" />
@endsection

@section('content-title')
    <div class="col">
        <h2 class="page-title">
            {{ $value->name }} kaydını düzenle
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="dropdown">
            <a href="{{ route('admin.value.create', $value->type->id) }}" class="btn btn-primary">
                Yeni {{ $value->type->single_name }} Oluştur
            </a>
        </div>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="dropdown">
            <button class="btn btn-primart dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                {{ $value->language->text }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach ($brothers as $b)
                    <a class="dropdown-item"
                        href="{{ route('admin.value.edit', [$b->id, $type->id]) }}">{{ $b->language->text }}</a>
                @endforeach
            </div>
        </div>
    </div>
@endsection


@section('content')
    <form method="POST" action="{{ route('admin.value.update', $value->id) }}" autocomplete="off" class="card"
        enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <div class="card-title">
                {{ $value->name }} kaydını düzenle
            </div>
        </div>
        <div class="card-body">
            <div class="row gy-2">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="name" class="form-label">Adı</label>
                        <input type="text" required class="form-control" value="{{ $value->name }}" id="name"
                            name="value_name">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="name" class="form-label">Menü</label>
                        <select type="text" name="menu_id[]" class="form-select" placeholder="Menü Seçiniz"
                            id="menu_id" value="" multiple>
                            @foreach ($selectableMenus as $menu)
                                @php
                                    $selected = '';
                                    if ($value->menus) {
                                        foreach ($value->menus as $m) {
                                            if ($m->menu->id == $menu->id) {
                                                $selected = 'selected';
                                            }
                                        }
                                    }
                                @endphp
                                <option value="{{ $menu->id }}" {{ $selected }}>{{ $menu->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @include('admin.partials.cms.createInputs', [
                    'fields' => $value->type->fields,
                    'FieldValues' => $detail,
                ])
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </div>
    </form>

    @foreach ($files as $file)
        <div class="modal modal-blur fade" id="uploadFileModal-{{ $file->key }}" tabindex="-1" style="display: none;"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $file->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="dropzone" id="dropzone-{{ $file->key }}">
                            <div class="fallback">
                                <input name="file" type="file" />
                            </div>
                            <div class="dz-message">
                                <h3 class="dropzone-msg-title">Dosyalarınızı Sürükleyin</h3>
                                <span class="dropzone-msg-desc">{{ $file->name }} için dosya yükle</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Kapat</button>
                        {{-- <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button> --}}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('js')
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
                let url = `{{ route('admin.removeFile') }}/${id}`
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

            @foreach ($editors as $key => $editor)
                let options_{{ $key }} = {
                    language: 'tr',
                    selector: '#tinymce-{{ $editor->key }}',
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
                tinyMCE.init(options_{{ $key }});
            @endforeach
            @foreach ($files as $file)
                var Dropzone_{{ $file->key }} = new Dropzone("#dropzone-{{ $file->key }}", {
                    autoProcessQueue: true,
                    url: "{{ route('admin.saveFiles', ['selector' => $file->key]) }}",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'edit_mode': true,
                        'value_id': {{ $value->id }},
                    },
                    paramName: "file",
                    @if ($file->type == 'input|file|single')
                        maxFiles: 1,
                    @endif
                    parallelUploads: 10,
                    timeout: 0,
                    addRemoveLinks: true,
                    uploadMultiple: true,
                    acceptedFiles: "{{ $file->values != '' ? $file->values : '.jpeg,.jpg,.png' }}",
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

                let list_{{ $file->key }} = document.getElementById('file-selector-{{ $file->key }}');
                var sortable_{{ $file->key }} = Sortable.create(list_{{ $file->key }}, {
                    animation: 150,
                    onChange: function(evt) {
                        let currentOrder_{{ $file->key }} = sortable_{{ $file->key }}.toArray();
                        $.ajax({
                            method: "GET",
                            url: "{{ route('admin.file.sort') }}",
                            data: {
                                data: currentOrder_{{ $file->key }}
                            }
                        });
                    }
                });
            @endforeach
        })
    </script>
@endsection
