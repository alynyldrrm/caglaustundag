@php
    $currentLanguage = session('defaultDatas')['currentLanguage'] ?? null;
    
    // Eğer list boşsa ve detail yoksa, veritabanından çek
    if((!isset($list) || !is_array($list) || count($list) == 0) && !$detail) {
        $list = getTypeValues('haberler', 100);
    }
@endphp

@extends('client.layout')

{{-- DETAY SAYFASI --}}
@if($detail)
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
                <span class="current">{{ $baslik }}</span>
            </nav>
        </div>
    </section>

    <section class="news-detail-content">
        <div class="container">
            <article class="news-article">
                @if(isset($detail['fields']['resim'][0]))
                    <div class="news-hero-image">
                        <img src="{{ getImageLink($detail['fields']['resim'][0]['path'], ['w' => 1200, 'h' => 600, 'q' => 90, 'fit' => 'cover']) }}" 
                             alt="{{ $baslik }}">
                    </div>
                @endif
                
                <div class="news-article-content">
                    @if($tarih)
                        <div class="news-meta">
                            <span class="news-date-badge">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $tarih }}
                            </span>
                        </div>
                    @endif
                    
                    <h1 class="news-article-title">{{ $baslik }}</h1>
                    
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

{{-- LİSTE SAYFASI --}}
@else
    @section('title', $menu->name ?? __('Haberler'))
    
    @section('content')
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">{{ $menu->name ?? __('Haberler') }}</h1>
            <p class="page-subtitle">{{ __('Güncel haber ve duyurularımız') }}</p>
        </div>
    </section>

    <section class="news-section">
        <div class="container">
            @if($list && count($list) > 0)
                <div class="news-grid">
                    @foreach($list as $haber)
                        <article class="news-card">
                            <a href="/{{ App::getLocale() }}/haberler/{{ $haber['permalink'] }}" class="news-link">
                                <div class="news-image">
                                    @if(isset($haber['fields']['resim'][0]))
                                        <img src="{{ getImageLink($haber['fields']['resim'][0]['path'], ['w' => 600, 'h' => 400, 'q' => 90, 'fit' => 'cover']) }}" 
                                             alt="{{ $haber['name'] }}"
                                             loading="lazy">
                                    @else
                                        <div class="news-placeholder">
                                            <i class="fas fa-newspaper"></i>
                                        </div>
                                    @endif
                                    @if(getValue('tarih', $haber))
                                        <span class="news-date">{{ getValue('tarih', $haber) }}</span>
                                    @endif
                                </div>
                                <div class="news-content">
                                    <h2 class="news-title">{{ $haber['name'] }}</h2>
                                    @if(getValue('icerik', $haber))
                                        <p class="news-excerpt">{{ substr(strip_tags(getValue('icerik', $haber)), 0, 150) }}...</p>
                                    @endif
                                    <span class="news-read-more">
                                        {{ __('Devamını Oku') }}
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-newspaper"></i>
                    <p>{{ __('Henüz haber eklenmemiş.') }}</p>
                </div>
            @endif
        </div>
    </section>
    @endsection
@endif

@section('css')
<style>
/* LISTE STYLLERİ */
.page-header {
    background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
    padding: 80px 0;
    text-align: center;
    color: #fff;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.page-subtitle {
    font-size: 1.1rem;
    color: rgba(255,255,255,0.7);
}

.news-section {
    padding: 80px 0;
    background: #f8f9fa;
}

.news-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.news-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.news-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.news-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.news-image {
    position: relative;
    height: 220px;
    overflow: hidden;
}

.news-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.news-card:hover .news-image img {
    transform: scale(1.05);
}

.news-placeholder {
    width: 100%;
    height: 100%;
    background: #e5e5e5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: #999;
}

.news-date {
    position: absolute;
    bottom: 15px;
    left: 15px;
    background: #1a1a1a;
    color: #fff;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.news-content {
    padding: 25px;
}

.news-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 12px;
    line-height: 1.4;
}

.news-excerpt {
    font-size: 0.95rem;
    color: #666;
    line-height: 1.6;
    margin-bottom: 20px;
}

.news-read-more {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: #1a1a1a;
    color: #fff;
    font-weight: 600;
    border-radius: 6px;
    transition: all 0.3s;
}

.news-card:hover .news-read-more {
    background: #333;
}

.empty-state {
    text-align: center;
    padding: 80px 20px;
    color: #888;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

/* DETAY STYLLERİ */
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

/* RESPONSIVE */
@media (max-width: 1024px) {
    .news-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .news-grid {
        grid-template-columns: 1fr;
    }
    
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
