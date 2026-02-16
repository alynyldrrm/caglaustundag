@extends('admin.layout')
@section('title', 'Dil Listesi')
@section('content-title')
    <div class="col">
        <h2 class="page-title">
            Diller
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <a href="{{ route('admin.language.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 5l0 14"></path>
                <path d="M5 12l14 0"></path>
            </svg>
            Dil Ekle
        </a>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter table-mobile-md card-table">
                <thead>
                    <tr>
                        <th>Dil</th>
                        <th>Key</th>
                        <th>Varsayılan</th>
                        <th class="w-1"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($langs as $lang)
                        <tr>
                            <td data-label="Dil">
                                <div class="text-muted">{{ $lang->text }}</div>
                            </td>
                            <td data-label="Key">
                                <div class="text-muted">{{ $lang->key }}</div>
                            </td>
                            <td class="text-muted" data-label="Varsayılan">
                                @if ($lang->is_default)
                                    <span class="badge bg-blue-lt">Evet</span>
                                @else
                                    <span class="badge bg-blue-lt">Hayır</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a href="{{ route('admin.language.edit', $lang->id) }}" class="btn btn-secondary">
                                        Düzenle
                                    </a>
                                    <button
                                        onclick="confirm('Silmek istediğinize emin misiniz?') ? window.location.href = '{{ route('admin.language.destroy', $lang->id) }}' : ''"
                                        class="btn btn-danger">
                                        Sil
                                    </button>

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
@endsection
