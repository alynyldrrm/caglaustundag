@php
    $currentLanguage = session('defaultDatas')['currentLanguage'] ?? null;
@endphp

@extends('client.layout')

@section('title', $detail['name'] ?? __('Haber Detayı'))

@section('content')
@php
    $baslik = getValue('baslik', $detail);
    $icerik = getValue('icerik', $detail);
    $tarih = getValue('tarih', $detail);
@endphp

<section class="news-detail-header">
    <div class="container">
        <nav class="breadcrumb">
            <a href="/{{ App::getLocale() }}">{{ __('Ana Sayfa') }}</a>
            <span>/</span>
            <a href="/{{ App::getLocale() }}/haberler">{{ __('Haberler') }}</a>
            <span>/</span>
            <span class="current">{!! $baslik !!}</span>
        </nav>
    </div>
</section>

<section class="news-detail-content">
    <div class="container">
        <article class="news-article">
            @if(isset($detail['fields']['resim'][0]))
                <div class="news-hero-image">
                    <img src="{{ getImageLink($detail['fields']['resim'][0]['path'], ['w' => 1200, 'h' => 600, 'q' => 90, 'fit' => 'cover']) }}" 
                         alt="{!! $baslik !!}">
                </div>
            @endif
            
            <div class="news-article-content">
                @if($tarih)
                    <div class="news-meta">
                        <span class="news-date-badge">
                            <i class="fas fa-calendar-alt"></i>
                            {!! $tarih !!}
                        </span>
                    </div>
                @endif
                
                <h1 class="news-article-title">{!! $baslik !!}</h1>
                
                @if($icerik)
                    <div class="news-article-text">
                        {!! $icerik !!}
                    </div>
                @endif
                
                <div class="news-navigation">
                    <a href="/{{ App::getLocale() }}/haberler" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                        {{ __('Tüm Haberler') }}
                    </a>
                </div>
            </div>
        </article>
    </div>
</section>
@endsection

@section('css')
<style>
.news-detail-header {
    background: #1a1a1a;
    padding: 30px 0;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #fff;
    font-size: 0.95rem;
}

.breadcrumb a {
    color: #999;
    text-decoration: none;
    transition: color 0.3s;
}

.breadcrumb a:hover {
    color: #fff;
}

.breadcrumb .current {
    color: #fff;
}

.news-detail-content {
    padding: 60px 0 100px;
    background: #f8f9fa;
}

.news-article {
    max-width: 900px;
    margin: 0 auto;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 30px rgba(0,0,0,0.1);
}

.news-hero-image {
    width: 100%;
    height: 400px;
}

.news-hero-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.news-article-content {
    padding: 50px;
}

.news-meta {
    margin-bottom: 20px;
}

.news-date-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #1a1a1a;
    color: #fff;
    padding: 10px 20px;
    border-radius: 30px;
    font-size: 0.9rem;
    font-weight: 500;
}

.news-article-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1.3;
    margin-bottom: 30px;
}

.news-article-text {
    font-size: 1.1rem;
    line-height: 1.9;
    color: #444;
}

.news-article-text p {
    margin-bottom: 20px;
}

.news-article-text h2,
.news-article-text h3 {
    color: #1a1a1a;
    margin: 30px 0 15px;
}

.news-article-text ul,
.news-article-text ol {
    margin: 20px 0;
    padding-left: 25px;
}

.news-article-text li {
    margin-bottom: 10px;
}

.news-navigation {
    margin-top: 50px;
    padding-top: 30px;
    border-top: 1px solid #e5e5e5;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 28px;
    background: transparent;
    color: #1a1a1a;
    border: 2px solid #1a1a1a;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-back:hover {
    background: #1a1a1a;
    color: #fff;
}

@media (max-width: 768px) {
    .news-hero-image {
        height: 250px;
    }
    
    .news-article-content {
        padding: 30px;
    }
    
    .news-article-title {
        font-size: 1.6rem;
    }
    
    .news-article-text {
        font-size: 1rem;
    }
}
</style>
@endsection
