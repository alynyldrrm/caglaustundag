@extends('admin.layout')
@section('title')
    {{ $type->single_name }}
@endsection
@section('content-title')
    <div class="col">
        <h2 class="page-title">
            Yeni {{ $type->single_name }} oluştur
        </h2>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.contact-settings.store', $type->id) }}" autocomplete="off" class="card">
        @csrf
        <div class="card-header">
            <div class="card-title">
                Yeni {{ $type->single_name }} oluştur
            </div>
        </div>
        <div class="card-body">
            <div class="row gy-2">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="title" class="form-label">Adı</label>
                        <input type="text" class="form-control" value="" id="name" name="name">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="city" class="form-label">İl</label>
                        <input type="text" class="form-control" value="" id="city" name="city">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="town" class="form-label">İlçe</label>
                        <input type="text" class="form-control" value="" id="town" name="town">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="phone" class="form-label">Telefon</label>
                        <input type="text" class="form-control" value="" id="phone" name="phone">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="text" class="form-label">E-Mail</label>
                        <input type="email" class="form-control" value="" id="email" name="email">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="text" class="form-label">Adres</label>
                        <textarea name="address" id="address" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="text" class="form-label">Harita Yerleştirme Kodu</label>
                        <textarea name="iframe_code" id="iframe_code" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </div>
    </form>
@endsection
