@extends('admin.layout')
@section('title')
    Web sitesi ayarlarını düzenle
@endsection
@section('content-title')
    <div class="col">
        <h2 class="page-title">
            Web sitesi ayarlarını düzenle
        </h2>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.website-settings.update') }}" autocomplete="off" class="card">
        @csrf
        <div class="card-header">
            <div class="card-title">
                Web sitesi ayarlarını düzenle
            </div>
        </div>
        <div class="card-body">
            <div class="row gy-2">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="seo_title" class="form-label">Site Başlığı</label>
                        <input type="text" class="form-control" value="{{ $setting->seo_title }}" id="seo_title"
                            name="seo_title">
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="form-group">
                        <label for="seo_keywords" class="form-label">Anahtar Kelimeler <small>(,) ile
                                ayırınız</small></label>
                        <input type="text" class="form-control" value="{{ $setting->seo_keywords }}" id="seo_keywords"
                            name="seo_keywords">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="seo_description" class="form-label">Site Açıklaması</label>
                        <textarea name="seo_description" id="seo_description" class="form-control">{{ $setting->seo_description }}</textarea>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="facebook" class="form-label">Facebook</label>
                        <input type="text" class="form-control" value="{{ $setting->facebook }}" id="facebook"
                            name="facebook">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="twitter" class="form-label">Twitter</label>
                        <input type="text" class="form-control" value="{{ $setting->twitter }}" id="twitter"
                            name="twitter">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="instagram" class="form-label">İnstagram</label>
                        <input type="text" class="form-control" value="{{ $setting->instagram }}" id="instagram"
                            name="instagram">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="youtube" class="form-label">Youtube</label>
                        <input type="text" class="form-control" value="{{ $setting->youtube }}" id="youtube"
                            name="youtube">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="gplus" class="form-label">Google +</label>
                        <input type="text" class="form-control" value="{{ $setting->gplus }}" id="gplus"
                            name="gplus">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="linkedin" class="form-label">Linkedin</label>
                        <input type="text" class="form-control" value="{{ $setting->linkedin }}" id="linkedin"
                            name="linkedin">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="pinterest" class="form-label">Pinterest</label>
                        <input type="text" class="form-control" value="{{ $setting->pinterest }}" id="pinterest"
                            name="pinterest">
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="form-group">
                        <label for="emails" class="form-label">E-Posta Adresleri<small>(,) ile
                                ayırınız</small></label>
                        <input type="text" class="form-control" value="{{ $setting->emails }}" id="emails"
                            name="emails">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </div>
    </form>
@endsection
