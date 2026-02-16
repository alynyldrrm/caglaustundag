@extends('admin.layout')
@section('title', 'Roller Listesi')

@section('content-title')
    <div class="col">
        <h2 class="page-title">
            Roller
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <button type="buttton" data-bs-toggle="modal" data-bs-target="#createRoleModal" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 5l0 14"></path>
                <path d="M5 12l14 0"></path>
            </svg>
            Yeni Rol Ekle
        </button>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter table-mobile-md card-table">
                <thead>
                    <tr>
                        <th>Rol</th>
                        <th>Kullanıcı Sayısı</th>
                        <th class="w-1"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <td data-label="Rol">
                                <div class="text-muted">{{ $role->name }}</div>
                            </td>
                            <td data-label="Kullanıcı Sayısı">
                                <div class="text-muted">{{ $role->users_count }}</div>
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a href="{{ route('admin.permissions.edit', $role->id) }}" class="btn btn-secondary">
                                        Yetkileri Düzenle
                                    </a>
                                    <div class="btn-list flex-nowrap">
                                        <a href="{{ route('admin.permissions.destroy', $role->id) }}"
                                            class="btn btn-danger">
                                            Sil
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">
                                Kayıt Bulunamadı
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal modal-blur fade" id="createRoleModal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <form method="POST" action="{{ route('admin.permissions.store') }}" autocomplete="off" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Yeni Rol Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <input type="text" name="role" class="form-control" name="example-text-input"
                            placeholder="Administrator">
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Vazgeç
                    </a>
                    <button type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Rolü Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
