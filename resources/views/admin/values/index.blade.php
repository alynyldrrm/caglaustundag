@extends('admin.layout')
@section('title')
    {{ $type->multiple_name }}
@endsection
@section('content-title')
    <div class="col">
        <h2 class="page-title">
            {{ $type->multiple_name }}
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <a href="{{ route('admin.value.create', $type->id) }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 5l0 14"></path>
                <path d="M5 12l14 0"></path>
            </svg>
            Yeni {{ $type->single_name }} Ekle
        </a>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-0 col-lg-10"></div>
                    <div class="col-12 col-lg-2">
                        <form class="form-group" id="langForm" method="GET"
                            action="{{ route('admin.value.index', $type->id) }}">
                            <label for="lang" class="form-label">Dil</label>
                            <select name="lang" id="langSelect" class="form-select">
                                @foreach ($langs as $lang)
                                    <option {{ request('lang') == $lang->id ? 'selected' : '' }}
                                        value="{{ $lang->id }}">
                                        {{ $lang->text }}</option>
                                @endforeach
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
                            @if ($type->model == 'App\Models\Value')
                                <th>Menü</th>
                            @endif
                            @if ($type->model == 'App\Models\ContactSetting')
                                <th>Telefon</th>
                            @endif
                            <th>Eklenme Tarihi</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody id="valueList">
                        @forelse ($values as $value)
                            <tr data-id="{{ $value->id }}">
                                <td data-label="Ad">
                                    <div class="text-muted">{{ $value->name }}</div>
                                </td>
                             @if ($type->model == 'App\Models\Value')
                                    <td data-label="Menü">
                                        @php
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

                                        @endphp
                                        <div class="text-muted">{!! $menuText !!}</div>
                                    </td>
                                @endif
                                @if ($type->model == 'App\Models\ContactSetting')
                                    <td>{{ $value->phone ?? '-' }}</td>
                                @endif
                                <td data-label="Tarih">
                                    <div class="text-muted">
                                        {{ Carbon\Carbon::parse($value->created_at)->format('d.m.Y') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-list flex-nowrap">
                                        @if ($type->model == 'App\Models\Form')
                                            <a href="{{ route('admin.form.show', $value->id) }}" class="btn btn-warning">
                                                Cevapları Listele
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.value.edit', [$value->id, $type->id]) }}"
                                            class="btn btn-secondary">
                                            Düzenle
                                        </a>
                                        <a href="{{ route('admin.value.destroy', [$value->id, $type->id]) }}"
                                            onclick="return confirm('Silmek istediğinize emin misiniz?')"
                                            class="btn btn-danger">
                                            Sil
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    Kayıt Bulunamadı
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{-- @php
                $values->appends(request()->query())->links();
            @endphp --}}
            @if (count($values) > 0)
                <ul class="pagination justify-center justify-content-lg-end">
                    <li class="page-item">
                        <a class="page-link" href="{{ $values->previousPageUrl() }}" tabindex="-1" aria-disabled="true">
                            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M15 6l-6 6l6 6"></path>
                            </svg>
                        </a>
                    </li>
                    @php
                        $x = 0;
                    @endphp
                    @for ($i = 1; $i <= $values->lastPage(); $i++)
                        @if ($i == 1 || $i == $values->lastPage() || ($i >= $values->currentPage() - 1 && $i <= $values->currentPage() + 1))
                            <li class="page-item {{ request('page') == $i ? 'active' : null }}">
                                <a class="page-link " href="{{ $values->url($i) }}">{{ $i }}</a>
                            </li>
                        @elseif($i == $values->lastPage() - 1)
                            <li class="page-item pe-none">
                                <a class="page-link" href="#">...</a>
                            </li>
                        @endif
                        @if ($values->currentPage() - 1 >= 3)
                            @if ($x == 0)
                                <li class="page-item pe-none">
                                    <a class="page-link" href="#">...</a>
                                </li>
                            @endif
                            @php
                                $x = 1;
                            @endphp
                        @endif
                    @endfor
                    <li class="page-item">
                        <a class="page-link" href="{{ $values->nextPageUrl() }}">
                            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M9 6l6 6l-6 6"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="page-item {{ request('all') ? 'active' : '' }}">
                        <a class="page-link" href="{{ route('admin.value.index', [$type->id, 'all' => true]) }}">
                            Tümü
                        </a>
                    </li>
                </ul>
            @endif

        </div>
    </div>
@endsection

@section('js')
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
                    url: "{{ route('admin.value.sort', $type->id) }}",
                    data: {
                        data: currentOrder
                    }
                });
            }
        });
    </script>
@endsection
