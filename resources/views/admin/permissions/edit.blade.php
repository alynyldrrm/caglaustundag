@extends('admin.layout')
@section('title')
    {{ $role->name }} adlı rolü düzenle
@endsection
@section('content-title')
    <div class="col">
        <h2 class="page-title">
            {{ $role->name }} adlı rolü düzenle
        </h2>
    </div>
@endsection
@section('content')
    <form method="POST" action="{{ route('admin.permissions.update', $role->id) }}" autocomplete="off" class="card">
        @csrf
        <div class="card-header">
            <div class="card-title">
                <h5 class="card-title">{{ $role->name }} isimli rolün yetkileri</h4>
            </div>
            <div class="form-check ms-auto form-switch mb-2">
                <input onchange="changeSelectAll(this)" type="checkbox" class="form-check-input" id="selectAll" />
                <label for="selectAll">Hepsini Seç</label>
            </div>
        </div>
        <div class="card-body">
            <div class="row row-cols-lg-3">
                @foreach ($permissions as $item)
                    <div class="col">
                        <div class="form-check form-switch mb-2">
                            <input type="checkbox" class="form-check-input chcboxCustom" name="{{ $item->id }}"
                                id="role_{{ $item->id }}" @checked($role->permissions->contains($item->id)) {{-- {{ $role->name == 'Admin' ? 'disabled' : '' }} --}} />
                            <label for="role_{{ $item->id }}">{{ $item->name }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </div>
    </form>
@endsection

@section('js')
    <script>
        function changeSelectAll(e) {
            let permissions = document.querySelectorAll('.chcboxCustom');
            permissions.forEach(item => {
                if (e.checked) {
                    item.checked = true;
                } else {
                    item.checked = false;
                }
            });
        }
    </script>
@endsection
