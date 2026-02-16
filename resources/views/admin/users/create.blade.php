@extends('admin.layout')
@section('title', 'Kullanıcı Oluştur')
@section('content-title')
    <div class="col">
        <h2 class="page-title">
            Yeni Kullanıcı Ekle
        </h2>
    </div>
@endsection


@section('content')
    <form method="POST" action="{{ route('admin.user.store') }}" autocomplete="off" class="card">
        @csrf
        <div class="card-header">
            <div class="card-title">
                Yeni Kullanıcı Ekle
            </div>
        </div>
        <div class="card-body">
            <div class="row gy-2">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="name" class="form-label">Adı Soyadı</label>
                        <input type="text" class="form-control" value="" id="name" name="name">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="email" class="form-label">E-Mail</label>
                        <input type="email" class="form-control" value="" id="email" name="email">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="phone" class="form-label">Telefon</label>
                        <input type="number" class="form-control" value="" id="phone" name="phone">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="password" class="form-label">Şifre</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="role" class="form-label">Rol</label>
                        <select name="role" id="role" class="form-select">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </div>
    </form>
@endsection
