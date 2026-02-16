@extends('admin.layout')
@section('title')
    {{ $type->single_name }} adlı tipi düzenle
@endsection
@section('content-title')
    <div class="col">
        <h2 class="page-title">
            {{ $type->single_name }} adlı tipi düzenle
        </h2>
    </div>
@endsection
@section('content')
    <form method="POST" action="{{ route('admin.type.update', $type->id) }}" autocomplete="off" class="card"
        id="updateTypeForm">
        @csrf
        <div class="card-header">
            <div class="card-title">
                {{ $type->single_name }} adlı tipi düzenle
            </div>
        </div>
        <div class="card-body">
            <div class="row gy-2">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="single_name" class="form-label">Tekil Ad</label>
                        <input type="text" class="form-control" value="{{ $type->single_name }}" id="single_name"
                            name="single_name">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="multiple_name" class="form-label">Çoğul Ad</label>
                        <input type="text" class="form-control" value="{{ $type->multiple_name }}" id="multiple_name"
                            name="multiple_name">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control" id="model" value="{{ $type->model }}"
                            name="model">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="rendered_view" class="form-label">Render Edilecek View</label>
                        <input type="text" class="form-control" id="rendered_view" value="{{ $type->rendered_view }}"
                            placeholder="Özel Sayfa İse Doldurunuz." name="rendered_view">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="is_hidden" class="form-label">Gizlimi </label>
                        <div class="d-flex gap-4">
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="radio" value="true"
                                    {{ $type->is_hidden ? 'checked' : '' }} name="is_hidden">
                                <span class="form-check-label">Evet</span>
                            </label>
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="radio" value="false"
                                    {{ $type->is_hidden ? '' : 'checked' }} name="is_hidden">
                                <span class="form-check-label">Hayır</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="#fields" class="nav-link active" data-bs-toggle="tab" aria-selected="false"
                                        role="tab" tabindex="-1">Sorular</a>
                                </li>
                                <li class="nav-item ms-auto">
                                    <button type="button" class="btn btn-secondary" onclick="addFieldRow()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 5l0 14"></path>
                                            <path d="M5 12l14 0"></path>
                                        </svg>
                                        Yeni Satır
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body px-0">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="fields" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-vcenter table-mobile-md card-table">
                                            <thead>
                                                <tr>
                                                    <th>Key</th>
                                                    <th>Tip</th>
                                                    <th>Ad</th>
                                                    <th>Özellikler</th>
                                                    <th>Seçenekler</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="field-list">
                                                @foreach ($type->fields as $field)
                                                    <tr data-id="{{ $field->id }}">
                                                        <input type="hidden" name="fieldIds[]"
                                                            value="{{ $field->id }}">
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $field->key }}" name="key[]" />
                                                        </td>
                                                        <td>
                                                            <select name="type[]" id="" class="form-select">
                                                                @foreach (config('custom.fieldTypes') as $df)
                                                                    <option value="{{ $df['type'] }}"
                                                                        {{ $field->type == $df['type'] ? 'selected' : '' }}>
                                                                        {{ $df['label'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $field->name }}" name="name[]" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $field->attr }}" name="attr[]" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $field->values }}" name="values[]" />
                                                        </td>
                                                        <td>
                                                            <button onclick="removeFieldInDom(this)" type="button"
                                                                class="btn btn-danger">
                                                                Sil
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="button" onclick="submitUpdateTypeForm()" class="btn btn-primary">Kaydet</button>
        </div>
    </form>
@endsection
@section('js')
    <script src="/assets/admin/dist/custom-js/types.js"></script>
    <script src="/assets/admin/dist/custom-js/sortable.js"></script>
    <script>
        let list = document.getElementById('field-list');
        var sortable = Sortable.create(list, {
            animation: 150,
            onChange: function(evt) {
                let currentOrder = sortable.toArray();
                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.field.sort') }}",
                    data: {
                        data: currentOrder
                    }
                });
            }
        });
    </script>
@endsection
