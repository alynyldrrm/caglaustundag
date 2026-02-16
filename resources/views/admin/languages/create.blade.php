@extends('admin.layout')
@section('title', 'Yeni Dil Ekle')
@section('content-title')
    <div class="col">
        <h2 class="page-title">
            Yeni Dil Ekle
        </h2>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.language.store') }}" autocomplete="off" class="card">
        @csrf
        <div class="card-header">
            <div class="card-title">
                Yeni Dil Ekle
            </div>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="text" class="form-label">Dil Adı</label>
                        <input type="text" class="form-control" value="{{ old('text') }}" id="text"
                            name="text">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="key" class="form-label">Key</label>
                        <input type="text" class="form-control" value="{{ old('key') }}" id="key"
                            name="key">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Varsayılan</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="is_default" id="btn-radio-basic-1"
                                autocomplete="off">
                            <label for="btn-radio-basic-1" type="button" value="true" class="btn">Evet</label>
                            <input type="radio" class="btn-check" name="is_default" value="false" id="btn-radio-basic-2"
                                autocomplete="off" checked="">
                            <label for="btn-radio-basic-2" type="button" class="btn">Hayır</label>
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
