@extends('admin.layout')

@section('content-title')
    <div class="col">
        <h2 class="page-title">
            Yeni Menü Ekle
        </h2>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.menu.store') }}" autocomplete="off" class="card"
        enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <div class="card-title">
                Yeni Menü Ekle
            </div>
        </div>
        <div class="card-body">
            <div class="row gy-2">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="name" class="form-label">Ad</label>
                        <input type="text" class="form-control" value="" id="name" name="name">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="type_id" class="form-label">Tipi</label>
                        <select type="text" class="form-select" id="type_id" name="type_id">
                            <option value="false">Yok</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">
                                    {{ $type->multiple_name }}
                                    @if ($type->is_hidden)
                                        <small>
                                            (Gizli)
                                        </small>
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="parent_id" class="form-label">Üst Menü</label>
                        <select type="text" class="form-select" id="parent_id" name="parent_id">
                            <option value="false">Yok</option>
                            @foreach ($menus as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="url" class="form-label">Url</label>
                        <input type="text" class="form-control" value="" id="url" name="url">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="is_hidden" class="form-label">Gizlimi </label>
                        <div class="d-flex gap-4">
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="radio" value="true" name="is_hidden">
                                <span class="form-check-label">Evet</span>
                            </label>
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="radio" value="false" checked="true"
                                    name="is_hidden">
                                <span class="form-check-label">Hayır</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="description" class="form-label">Menü Açıklaması</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="imagePath" class="form-label">Resim</label>
                        <input type="file" class="form-control" id="imagePath" name="imagePath">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="filePath" class="form-label">Dosya</label>
                        <input type="file" class="form-control" id="filePath" name="filePath">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </div>
    </form>
@endsection

@section('js')
    <script src="/assets/admin/dist/libs/tinymce/tinymce.min.js" defer></script>
    <script src="/assets/admin/dist/libs/tom-select/dist/js/tom-select.base.min.js" defer></script>
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
@endsection
