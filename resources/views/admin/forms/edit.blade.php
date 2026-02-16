@extends('admin.layout')
@section('title')
    {{ $form->name }} adlı formu düzenle
@endsection
@section('content-title')
    <div class="col">
        <h2 class="page-title">
            {{ $form->name }} adlı formu düzenle
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="dropdown">
            <button class="btn btn-primart dropdown-toggle" type="button" id="" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ $form->language->text }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                @foreach ($brothers as $b)
                    <li>
                        <a class="dropdown-item"
                            href="{{ route('admin.value.edit', [$b->id, $type->id]) }}">{{ $b->language->text }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
@section('content')
    <form method="POST" action="{{ route('admin.form.update', $form->id) }}" autocomplete="off" class="card">
        @csrf
        <div class="card-header">
            <div class="card-title">
                {{ $form->name }} adlı formu düzenle
            </div>
        </div>
        <div class="card-body">
            <div class="row gy-2">
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="form_name" class="form-label">Adı</label>
                        <input type="text" class="form-control" value="{{ $form->name }}" id="form_name"
                            name="form_name">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="name" class="form-label">Menü</label>
                        <select type="text" name="menu_id[]" class="form-select" placeholder="Menü Seçiniz"
                            id="menu_id" value="" multiple>
                            @foreach ($selectableMenus as $menu)
                                <option value="{{ $menu->id }}"
                                    {{ in_array($menu->id, $selectedMenus) ? 'selected' : '' }}>
                                    {{ $menu->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="success_message" class="form-label">Başarılı Mesajı</label>
                        <input type="text" class="form-control" value="{{ $form->success_message }}"
                            id="success_message" name="success_message">
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="error_message" class="form-label">Hata Mesajı</label>
                        <input type="text" class="form-control" value="{{ $form->error_message }}" id="error_message"
                            name="error_message">
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="ms-auto">
                                <button type="button" class="btn btn-secondary" onclick="addFormFieldRow()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 5l0 14"></path>
                                        <path d="M5 12l14 0"></path>
                                    </svg>
                                    Yeni Satır
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>Soru Tipi</th>
                                        <th>Soru Adı</th>
                                        <th>Soru Özellikleri</th>
                                        <th>Soru Cevapları</th>
                                        <th></th>
                                    </thead>
                                    <tbody id="form-fields-container">
                                        @if ($questions)
                                            @foreach ($questions as $item)
                                                <tr data-id="{{ $item['id'] }}">
                                                    <td>
                                                        <select name="type[]" id="" class="form-select">
                                                            @foreach (config('custom.formFieldTypes') as $df)
                                                                <option value="{{ $df['type'] }}"
                                                                    {{ $item['field'] == $df['type'] ? 'selected' : '' }}>
                                                                    {{ $df['label'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            value=" {{ $item['name'] }}" name="name[]" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            value="{{ $item['attr'] }}" name="attr[]" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            value="{{ $item['values'] }}" name="values[]" />
                                                    </td>
                                                    <td>
                                                        <button onclick="removeFieldInDom(this)" type="button"
                                                            class="btn btn-danger">
                                                            Sil
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
    <script src="/assets/admin/dist/custom-js/sortable.js"></script>
    <script src="/assets/admin/dist/custom-js/forms.js"></script>
    <script src="/assets/admin/dist/libs/tom-select/dist/js/tom-select.base.min.js" defer></script>
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
        });
        //fieldList form.js de tanımlı
        var sortable = Sortable.create(fieldList, {
            animation: 150,
            onChange: function(evt) {
                let currentOrder = sortable.toArray();
                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.form.sort', $form->id) }}",
                    data: {
                        data: currentOrder
                    }
                });
            }
        });
    </script>
@endsection
