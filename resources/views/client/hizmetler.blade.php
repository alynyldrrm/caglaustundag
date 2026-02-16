@extends('client.layout')

@php
    // Eğer list boşsa, direkt veritabanından çek
    if(!is_array($list) || count($list) == 0) {
        $list = getTypeValues('hizmetler', 100);
    }
    $list = is_array($list) ? $list : [];
@endphp

{{-- DETAY SAYFASI - KOMPAKT GRID --}}
@if($detail)
    @section('title', $detail['name'] ?? __('Hizmet Detayı'))
    
    @section('content')
        @php
            $baslik = getValue('baslik', $detail);
            $altbaslik = getValue('altbaslik', $detail);
            $icerik = getValue('icerik', $detail);
        @endphp

        <!-- Hero -->
        <section class="service-hero-compact">
            <div class="container">
                <nav class="breadcrumb-compact">
                    <a href="/{{ App::getLocale() }}">{{ __('Ana Sayfa') }}</a>
                    <i class="fas fa-chevron-right"></i>
                    <a href="{{ url()->previous() }}">{{ __('Hizmetler') }}</a>
                    <i class="fas fa-chevron-right"></i>
                    <span>{!! $baslik !!}</span>
                </nav>
                <h1 class="service-title-compact">{!! $baslik !!}</h1>
                @if($altbaslik)
                    <p class="service-subtitle-compact">{!! $altbaslik !!}</p>
                @endif
            </div>
        </section>

        <!-- Content - 2 Column Layout -->
        <section class="service-content-compact">
            <div class="container">
                <div class="content-grid-compact">
                    <!-- Main Content -->
                    <div class="main-content-compact">
                        
                        <!-- Intro Text -->
                        @php
                            // İlk paragrafı intro olarak al
                            $intro = strip_tags($icerik);
                            $intro = explode("\n", $intro)[0] ?? '';
                        @endphp
                        @if($intro)
                        <div class="intro-text-compact">
                            {!! $intro !!}
                        </div>
                        @endif

                        <!-- Features Grid - YAN YANA -->
                        @php
                            // Liste maddelerini çıkar
                            preg_match_all('/<li[^>]*>(.*?)<\/li>/s', $icerik, $matches);
                            $items = $matches[1] ?? [];
                            
                            // Kategorilere göre grupla
                            $groups = [];
                            $currentGroup = [];
                            
                            foreach($items as $item) {
                                $text = strip_tags($item);
                                if(strpos($text, 'YATIRIM DÖNEMİ') !== false || strpos($text, 'İŞLETME DÖNEMİ') !== false) {
                                    if(!empty($currentGroup)) {
                                        $groups[] = $currentGroup;
                                    }
                                    $currentGroup = ['title' => $text, 'items' => []];
                                } else {
                                    $currentGroup['items'][] = $text;
                                }
                            }
                            if(!empty($currentGroup)) {
                                $groups[] = $currentGroup;
                            }
                        @endphp

                        @if(!empty($groups))
                        <div class="features-section-compact">
                            @foreach($groups as $group)
                            <div class="feature-group-compact">
                                <h3 class="group-title-compact">{!! $group['title'] ?? '' !!}</h3>
                                <div class="features-grid-compact">
                                    @foreach($group['items'] as $item)
                                    <div class="feature-item-compact">
                                        <i class="fas fa-check-circle"></i>
                                        <span>{!! $item !!}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <!-- CTA Box -->
                        <div class="cta-box-compact">
                            <div class="cta-content-compact">
                                <i class="fas fa-phone-alt"></i>
                                <div>
                                    <h4>{{ __('Bu hizmet hakkında bilgi alın') }}</h4>
                                    <p>{{ __('Uzman ekibimiz size yardımcı olmaya hazır') }}</p>
                                </div>
                            </div>
                            <a href="{{ route('showPage', [App::getLocale(), 'iletisim']) }}" class="btn-cta-compact">
                                {{ __('Bize Ulaşın') }}
                            </a>
                        </div>
                    </div>
                    
                    <!-- Sidebar -->
                    @if(count($list) > 1)
                    <aside class="sidebar-compact">
                        <div class="sidebar-box-compact">
                            <h4>{{ __('Diğer Hizmetler') }}</h4>
                            <ul class="service-list-compact">
                                @foreach(array_slice($list, 0, 5) as $hizmet)
                                    @if($hizmet['id'] != ($detail['id'] ?? 0))
                                        @php
                                            $hbaslik = getValue('baslik', $hizmet);
                                            $hmenuPermalink = $hizmet['menu']['permalink'] ?? '';
                                            $hlanguageKey = $hizmet['language']['key'] ?? 'tr';
                                        @endphp
                                        <li>
                                            <a href="{{ route('showPage', [$hlanguageKey, $hmenuPermalink, $hizmet['permalink']]) }}">
                                                <i class="fas fa-chevron-right"></i>
                                                <span>{!! $hbaslik !!}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </aside>
                    @endif
                </div>
            </div>
        </section>
    @endsection

{{-- LİSTE SAYFASI --}}
@else
    @section('title', getSelectedMenus()->last() ? getSelectedMenus()->last()->name : __('Hizmetler'))
    
    @section('content')
        <section class="services-hero-compact">
            <div class="container">
                <span class="section-label-compact">{{ __('Hizmetlerimiz') }}</span>
                <h1 class="section-heading-compact">{{ __('Profesyonel Çözümler') }}</h1>
                <p class="section-desc-compact">{{ __('İşletmenizin büyümesi için sunduğumuz danışmanlık hizmetleri') }}</p>
            </div>
        </section>

        <section class="services-list-compact">
            <div class="container">
                @if(count($list) > 0)
                    <div class="services-grid-compact">
                        @foreach($list as $index => $hizmet)
                            @php
                                $baslik = getValue('baslik', $hizmet);
                                $altbaslik = getValue('altbaslik', $hizmet);
                                $menuPermalink = $hizmet['menu']['permalink'] ?? '';
                                $languageKey = $hizmet['language']['key'] ?? 'tr';
                            @endphp
                            
                            <article class="service-card-compact">
                                <div class="card-header-compact">
                                    <span class="card-num-compact">{{ sprintf('%02d', $index + 1) }}</span>
                                    <h3>{!! $baslik !!}</h3>
                                </div>
                                @if($altbaslik)
                                    <p class="card-desc-compact">{!! $altbaslik !!}</p>
                                @endif
                                <a href="{{ route('showPage', [$languageKey, $menuPermalink, $hizmet['permalink']]) }}" class="card-link-compact">
                                    {{ __('Detay') }}
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state-compact">
                        <p>{{ __('Henüz hizmet eklenmemiş.') }}</p>
                    </div>
                @endif
            </div>
        </section>
    @endsection
@endif

@section('css')
<style>
    /* ========================================
       DETAY SAYFASI - KOMPAKT GRID
       ======================================== */
    
    .service-hero-compact {
        background: #fff;
        padding: 60px 0 40px;
        border-bottom: 1px solid #e5e5e5;
    }
    
    .breadcrumb-compact {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        font-size: 0.85rem;
    }
    
    .breadcrumb-compact a {
        color: #888;
        text-decoration: none;
    }
    
    .breadcrumb-compact a:hover {
        color: #1a1a1a;
    }
    
    .breadcrumb-compact i {
        font-size: 0.6rem;
        color: #ccc;
    }
    
    .breadcrumb-compact span {
        color: #1a1a1a;
    }
    
    .service-title-compact {
        font-size: 2.2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 10px;
        letter-spacing: -0.01em;
    }
    
    .service-subtitle-compact {
        font-size: 1.1rem;
        color: #666;
        margin: 0;
    }
    
    .service-content-compact {
        padding: 40px 0 80px;
        background: #fff;
    }
    
    .content-grid-compact {
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 50px;
    }
    
    /* Intro */
    .intro-text-compact {
        font-size: 1.15rem;
        color: #444;
        line-height: 1.7;
        margin-bottom: 40px;
        padding-bottom: 30px;
        border-bottom: 1px solid #eee;
    }
    
    /* Features Grid - YAN YANA */
    .features-section-compact {
        display: flex;
        flex-direction: column;
        gap: 40px;
    }
    
    .feature-group-compact {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 25px 30px;
    }
    
    .group-title-compact {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1a1a1a;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #1a1a1a;
    }
    
    .features-grid-compact {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .feature-item-compact {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 15px;
        background: #fff;
        border-radius: 8px;
        font-size: 0.9rem;
        color: #444;
        line-height: 1.4;
    }
    
    .feature-item-compact i {
        color: #1a1a1a;
        margin-top: 2px;
        font-size: 0.9rem;
    }
    
    /* CTA Box */
    .cta-box-compact {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-top: 50px;
        padding: 25px 30px;
        background: #1a1a1a;
        border-radius: 10px;
        color: #fff;
    }
    
    .cta-content-compact {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    
    .cta-content-compact i {
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .cta-content-compact h4 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 3px;
    }
    
    .cta-content-compact p {
        color: rgba(255,255,255,0.6);
        margin: 0;
        font-size: 0.9rem;
    }
    
    .btn-cta-compact {
        padding: 12px 25px;
        background: #fff;
        color: #1a1a1a;
        text-decoration: none;
        font-weight: 600;
        border-radius: 6px;
        font-size: 0.9rem;
        white-space: nowrap;
    }
    
    .btn-cta-compact:hover {
        background: #f0f0f0;
        color: #1a1a1a;
        text-decoration: none;
    }
    
    /* Sidebar */
    .sidebar-compact {
        position: sticky;
        top: 100px;
        height: fit-content;
    }
    
    .sidebar-box-compact {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 25px;
    }
    
    .sidebar-box-compact h4 {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .service-list-compact {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .service-list-compact li {
        border-bottom: 1px solid #e5e5e5;
    }
    
    .service-list-compact li:last-child {
        border-bottom: none;
    }
    
    .service-list-compact a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 0;
        color: #555;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    
    .service-list-compact a:hover {
        color: #1a1a1a;
        padding-left: 5px;
    }
    
    .service-list-compact i {
        font-size: 0.7rem;
        color: #999;
    }
    
    /* ========================================
       LİSTE SAYFASI
       ======================================== */
    
    .services-hero-compact {
        padding: 80px 0 40px;
        text-align: center;
        background: #fff;
    }
    
    .section-label-compact {
        display: inline-block;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #999;
        margin-bottom: 15px;
    }
    
    .section-heading-compact {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 15px;
    }
    
    .section-desc-compact {
        font-size: 1.1rem;
        color: #666;
        max-width: 500px;
        margin: 0 auto;
    }
    
    .services-list-compact {
        padding: 30px 0 80px;
        background: #fff;
    }
    
    .services-grid-compact {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
    }
    
    .service-card-compact {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 25px;
        display: flex;
        flex-direction: column;
        transition: all 0.3s;
    }
    
    .service-card-compact:hover {
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }
    
    .card-header-compact {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }
    
    .card-num-compact {
        font-size: 0.75rem;
        font-weight: 600;
        color: #bbb;
        font-family: monospace;
    }
    
    .card-header-compact h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1a1a1a;
        margin: 0;
    }
    
    .card-desc-compact {
        color: #666;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 20px;
        flex: 1;
    }
    
    .card-link-compact {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #1a1a1a;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.85rem;
    }
    
    .card-link-compact:hover {
        gap: 12px;
    }
    
    .empty-state-compact {
        text-align: center;
        padding: 60px 0;
        color: #999;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .content-grid-compact {
            grid-template-columns: 1fr;
            gap: 40px;
        }
        
        .sidebar-compact {
            position: static;
        }
        
        .features-grid-compact {
            grid-template-columns: 1fr;
        }
        
        .cta-box-compact {
            flex-direction: column;
            text-align: center;
        }
    }
    
    @media (max-width: 768px) {
        .service-title-compact {
            font-size: 1.7rem;
        }
        
        .services-grid-compact {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
