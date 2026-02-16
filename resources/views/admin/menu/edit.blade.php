@extends('admin.layout')
@section('title')
    {{ $menu->name }} adlı menüyü düzenle
@endsection

@section('content-title')
    <div class="col">
        <h2 class="page-title">
            {{ $menu->name }} adlı menüyü düzenle
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="dropdown">
            <button class="btn btn-primart dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                {{ $menu->language->text }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach ($brothers as $b)
                    <a class="dropdown-item" href="{{ route('admin.menu.edit', $b->id) }}">{{ $b->language->text }}</a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.menu.update', $menu->id) }}" autocomplete="off" class="card"
        enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <div class="card-title">
                {{ $menu->name }} adlı menüyü düzenle
            </div>
        </div>
        <div class="card-body">
            <div class="row gy-2">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="name" class="form-label">Ad</label>
                        <input type="text" class="form-control" value="{{ $menu->name }}" id="name"
                            name="name">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="type_id" class="form-label">Tip</label>
                        <select type="text" class="form-select" id="type_id" name="type_id">
                            <option value="false">Yok</option>
                            @foreach ($types as $t)
                                <option {{ $menu->type ? ($menu->type->id == $t->id ? 'selected' : '') : '' }}
                                    value="{{ $t->id }}">
                                    {{ $t->multiple_name }}
                                    @if ($t->is_hidden)
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
                            @foreach ($menus as $m)
                                <option {{ $menu->parent_id == $m->id ? 'selected' : '' }} value="{{ $m->id }}">
                                    {{ $m->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="url" class="form-label">Url</label>
                        <input type="text" class="form-control" value="{{ $menu->url }}" id="url"
                            name="url">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="is_hidden" class="form-label">Gizlimi </label>
                        <div class="d-flex gap-4">
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="radio" value="true"
                                    {{ $menu->is_hidden ? 'checked' : '' }} name="is_hidden">
                                <span class="form-check-label">Evet</span>
                            </label>
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="radio" value="false"
                                    {{ $menu->is_hidden ? '' : 'checked' }} name="is_hidden">
                                <span class="form-check-label">Hayır</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="description" class="form-label">Menü Açıklaması</label>
                        <textarea name="description" id="description" class="form-control">{{ $menu->description }}</textarea>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="imagePath" class="form-label">Resim</label>
                        <input type="file" {{ $menu->imagePath ? 'disabled' : '' }} class="form-control" id="imagePath"
                            name="imagePath">
                    </div>
                    @if ($menu->imagePath)
                        <div
                            class="w-100 d-flex text-center flex-column justify-content-center align-items-center gap-3 mt-4">
                            <img class="img-fluid" style="max-width:200px;" src="/files/menuImages/{{ $menu->imagePath }}"
                                alt="">
                            <a href="{{ route('admin.menu.destroyFile', ['image', $menu->id]) }}"
                                class="btn btn-danger">Sil</a>
                        </div>
                    @endif
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="filePath" class="form-label">Dosya</label>
                        <input type="file" {{ $menu->filePath ? 'disabled' : '' }} class="form-control"
                            id="filePath" name="filePath">
                    </div>
                    @if ($menu->filePath)
                        <div
                            class="w-100 d-flex text-center flex-column justify-content-center align-items-center gap-3 mt-4">
                            <a class="btn btn-warning" target="_blank"
                                href="/files/menuFiles/{{ $menu->filePath }}">Göster</a>
                            <a href="{{ route('admin.menu.destroyFile', ['file', $menu->id]) }}"
                                class="btn btn-danger">Sil</a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </div>
    </form>
@endsection

@section('js')
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
@endsection
