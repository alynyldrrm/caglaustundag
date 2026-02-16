@extends('admin.layout')
@section('title')
    {{ $lang->text }} adlı dili düzenle
@endsection
@section('content-title')
    <div class="col">
        <h2 class="page-title">
            {{ $lang->text }} adlı dili düzenle
        </h2>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.language.update', $lang->id) }}" autocomplete="off" class="card">
        @csrf
        <div class="card-header">
            <div class="card-title">
                {{ $lang->text }} adlı dili düzenle
            </div>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="text" class="form-label">Dil Adı</label>
                        <input type="text" class="form-control" value="{{ $lang->text }}" id="text"
                            name="text">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="key" class="form-label">Key</label>
                        <input type="text" class="form-control" value="{{ $lang->key }}" id="key"
                            name="key">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Varsayılan</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="is_default" id="btn-radio-basic-1"
                                autocomplete="off" {{ $lang->is_default ? 'checked' : '' }}>
                            <label for="btn-radio-basic-1" type="button" value="true" class="btn">Evet</label>
                            <input type="radio" class="btn-check" name="is_default" value="false" id="btn-radio-basic-2"
                                autocomplete="off" {{ $lang->is_default ? '' : 'checked' }}>
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
