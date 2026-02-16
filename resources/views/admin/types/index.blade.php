@extends('admin.layout')
@section('title', 'Tipler')

@section('content-title')
    <div class="col">
        <h2 class="page-title">
            Tipler
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <a href="{{ route('admin.type.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 5l0 14"></path>
                <path d="M5 12l14 0"></path>
            </svg>
            Ekle
        </a>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter table-mobile-md card-table">
                <thead>
                    <tr>
                        <th>Ad</th>
                        <th class="w-1"></th>
                    </tr>
                </thead>
                <tbody id="typeList">
                    @forelse ($types as $type)
                        <tr data-id="{{ $type->id }}">
                            <td data-label="Ad">
                                <div class="text-muted">
                                    {{ $type->multiple_name }}
                                    @if ($type->is_hidden)
                                        <small>
                                            (Gizli)
                                        </small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a href="{{ route('admin.type.edit', $type->id) }}" class="btn btn-secondary">
                                        Düzenle
                                    </a>
                                    <a href="{{ route('admin.type.destroy', $type->id) }}"
                                        onclick="return confirm('Silmek istediğinize emin misiniz?') "
                                        class="btn btn-danger">
                                        Sil
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">
                                Kayıt Bulunamadı
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script src="/assets/admin/dist/custom-js/sortable.js"></script>
    <script>
        let list = document.getElementById('typeList');
        var sortable = Sortable.create(list, {
            animation: 150,
            onChange: function(evt) {
                let currentOrder = sortable.toArray();
                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.type.sort') }}",
                    data: {
                        data: currentOrder
                    }
                });
            }
        });
    </script>
@endsection
