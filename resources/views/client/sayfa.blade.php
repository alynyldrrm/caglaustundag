@php
    $currentLanguage = session('defaultDatas')['currentLanguage'] ?? null;
    $menuPermalink = $menu->permalink ?? '';
@endphp

@extends('client.layout')

@section('title', $menu->name ?? __('Sayfa'))

@section('content')
{{-- Hakkımızda Sayfası --}}
@if($menuPermalink == 'hakkimizda')
    @php
        $hakkimizdaList = getTypeValues('sayfalar', 1);
        $hakkimizda = count($hakkimizdaList) > 0 ? $hakkimizdaList[0] : null;
    @endphp
    
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">{!! $menu->name ?? __('Hakkımızda') !!}</h1>
        </div>
    </section>

    <section class="page-content hakkimizda-page">
        <div class="container">
            @if($hakkimizda)
                <div class="hakkimizda-grid">
                    <div class="hakkimizda-image">
                        @if(isset($hakkimizda['fields']['gorsel'][0]))
                            <img src="{{ getImageLink($hakkimizda['fields']['gorsel'][0]['path'], ['w' => 800, 'h' => 600, 'fit' => 'cover']) }}" alt="{!! getValue('baslik', $hakkimizda) !!}">
                        @endif
                    </div>
                    <div class="hakkimizda-content">
                        <h2>{!! getValue('baslik', $hakkimizda) !!}</h2>
                        <div class="hakkimizda-text">
                            {!! getValue('icerik', $hakkimizda) !!}
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-content">
                    <p>{{ __('İçerik bulunamadı.') }}</p>
                </div>
            @endif
        </div>
    </section>

{{-- İletişim Sayfası --}}
@elseif($menuPermalink == 'iletisim')
    @php
        $contactSettings = getContact();
    @endphp
    
    <section class="page-content contact-page" style="padding-top: 0;">
        <div class="container">
            <div class="contact-grid">
                <!-- Sol: İletişim Bilgileri -->
                <div class="contact-info">
                    <h2 class="section-title" style="margin-top: -20px;">{{ __('Bize Ulaşın') }}</h2>
                    
                    @if($contactSettings && count($contactSettings) > 0)
                        @foreach($contactSettings as $item)
                        <div class="contact-card">
                            <h3 class="contact-branch">{!! $item['name'] ?? 'MERKEZ' !!}</h3>
                            
                            <div class="contact-items">
                                @if(!empty($item['address']))
                                <div class="contact-item">
                                    <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                                    <div class="contact-detail">
                                        <span class="label">{{ __('Adres') }}</span>
                                        <p>{!! $item['address'] !!}</p>
                                    </div>
                                </div>
                                @endif
                                
                                @if(!empty($item['phone']))
                                <div class="contact-item">
                                    <div class="contact-icon"><i class="fas fa-phone"></i></div>
                                    <div class="contact-detail">
                                        <span class="label">{{ __('Telefon') }}</span>
                                        <a href="tel:{{ str_replace(' ', '', $item['phone']) }}">{!! $item['phone'] !!}</a>
                                    </div>
                                </div>
                                @endif
                                
                                @if(!empty($item['email']))
                                <div class="contact-item">
                                    <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                                    <div class="contact-detail">
                                        <span class="label">{{ __('E-Posta') }}</span>
                                        <a href="mailto:{{ $item['email'] }}">{!! $item['email'] !!}</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="contact-card">
                            <h3 class="contact-branch">MERKEZ</h3>
                            <div class="contact-items">
                                <div class="contact-item">
                                    <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                                    <div class="contact-detail">
                                        <span class="label">{{ __('Adres') }}</span>
                                        <p>Anittepe Mahallesi Turgutreis Caddesi 21/A Çankaya ANKARA</p>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <div class="contact-icon"><i class="fas fa-phone"></i></div>
                                    <div class="contact-detail">
                                        <span class="label">{{ __('Telefon') }}</span>
                                        <a href="tel:03122319628">0312 231 96 28</a>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                                    <div class="contact-detail">
                                        <span class="label">{{ __('E-Posta') }}</span>
                                        <a href="mailto:info@reformdanismanlik.com.tr">info@reformdanismanlik.com.tr</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Sağ: Harita -->
                <div class="contact-map">
                    @if($contactSettings && count($contactSettings) > 0 && !empty($contactSettings[0]['map_code']))
                        <div class="map-container">
                            {!! $contactSettings[0]['map_code'] !!}
                        </div>
                    @else
                        <div class="map-container">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3059.4!2d32.835758!3d39.9323919!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMznCsDU1JzU2LjYiTiAzMsKwNTAnMDguNyJF!5e0!3m2!1str!2str!4v1609459200000!5m2!1str!2str" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

{{-- Diğer Sayfalar --}}
@else
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">{!! $menu->name ?? '' !!}</h1>
        </div>
    </section>

    <section class="page-content">
        <div class="container">
            @if($list && count($list) > 0)
                <div class="page-list">
                    @foreach($list as $item)
                        <div class="page-item">
                            <h3>{!! $item['name'] ?? '' !!}</h3>
                            <div class="page-item-content">
                                {!! $item['content'] ?? '' !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-content">
                    <p>{{ __('İçerik bulunamadı.') }}</p>
                </div>
            @endif
        </div>
    </section>
@endif
@endsection

@section('css')
<style>
.page-header {
    background: #1a1a1a;
    padding: 60px 0;
    color: #fff;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
}

.page-content {
    padding: 80px 0;
    background: #f8f9fa;
}

/* Hakkımızda Stilleri */
.hakkimizda-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.hakkimizda-image {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.hakkimizda-image img {
    width: 100%;
    display: block;
}

.hakkimizda-content h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 30px;
    line-height: 1.3;
}

.hakkimizda-text {
    font-size: 1.1rem;
    color: #555;
    line-height: 1.8;
}

.hakkimizda-text p {
    margin-bottom: 20px;
}

/* İletişim Stilleri */
.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
}

.section-title {
    font-size: 1.8rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 30px;
}

.contact-card {
    background: #fff;
    border-radius: 8px;
    padding: 30px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.contact-branch {
    font-size: 1.2rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #1a1a1a;
}

.contact-items {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.contact-icon {
    width: 44px;
    height: 44px;
    background: #1a1a1a;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.contact-detail {
    flex: 1;
}

.contact-detail .label {
    display: block;
    font-size: 0.8rem;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 5px;
}

.contact-detail p,
.contact-detail a {
    font-size: 1rem;
    color: #333;
    line-height: 1.5;
    text-decoration: none;
}

.contact-detail a:hover {
    color: #000;
    text-decoration: underline;
}

.map-container {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.map-container iframe {
    display: block;
    width: 100%;
    height: 450px;
}

.empty-content {
    text-align: center;
    padding: 60px 0;
    color: #888;
}

@media (max-width: 1024px) {
    .hakkimizda-grid,
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .hakkimizda-image,
    .contact-map {
        order: -1;
    }
}

@media (max-width: 768px) {
    .page-header {
        padding: 40px 0;
    }
    
    .page-title {
        font-size: 1.8rem;
    }
    
    .page-content {
        padding: 50px 0;
    }
    
    .hakkimizda-content h2 {
        font-size: 1.6rem;
    }
}
</style>
@endsection
