@extends('admin.layout')
@section('title')
    {{ $type->single_name }}
@endsection
@section('content-title')
    <div class="col">
        <h2 class="page-title">
            {{ $setting->name }} kaydını düzenle
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="dropdown">
            <a href="{{ route('admin.value.create', $setting->type->id) }}" class="btn btn-primary">
                Yeni {{ $setting->type->single_name }} Oluştur
            </A>
        </div>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="dropdown">
            <button class="btn btn-primart dropdown-toggle" type="button" id="" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ $setting->language->text }}
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
    <form method="POST" action="{{ route('admin.contact-settings.update', $setting->id) }}" autocomplete="off"
        class="card">
        @csrf
        <div class="card-header">
            <div class="card-title">
                {{ $setting->name }} kaydını düzenle
            </div>
        </div>
        <div class="card-body">
            <div class="row gy-2">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="title" class="form-label">Adı</label>
                        <input type="text" class="form-control" value="{{ $setting->name }}" id="name"
                            name="name">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="city" class="form-label">İl</label>
                        <input type="text" class="form-control" value="{{ $setting->city }}" id="city"
                            name="city">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="town" class="form-label">İlçe</label>
                        <input type="text" class="form-control" value="{{ $setting->town }}" id="town"
                            name="town">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="phone" class="form-label">Telefon</label>
                        <input type="text" class="form-control" value="{{ $setting->phone }}" id="phone"
                            name="phone">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="text" class="form-label">E-Mail</label>
                        <input type="email" class="form-control" value="{{ $setting->email }}" id="email"
                            name="email">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="text" class="form-label">Adres</label>
                        <textarea name="address" id="address" class="form-control">{{ $setting->address }}</textarea>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="text" class="form-label">Harita Yerleştirme Kodu</label>
                        <textarea name="iframe_code" id="iframe_code" class="form-control">{{ $setting->iframe_code }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </div>
    </form>
@endsection
