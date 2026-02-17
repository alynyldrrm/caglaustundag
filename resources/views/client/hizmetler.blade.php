@extends('client.layout')

@php
    if(!is_array($list) || count($list) == 0) {
        $list = getTypeValues('hizmetler', 100);
    }
    $list = is_array($list) ? $list : [];
@endphp

{{-- DETAY SAYFASI --}}
@if($detail)
    @section('title', $detail['name'] ?? __('Hizmet Detayı'))

    @section('content')
        @php
            $baslik    = getValue('baslik', $detail);
            $altbaslik = getValue('altbaslik', $detail);
            $icerik    = getValue('icerik', $detail);
        @endphp

        <!-- Hero -->
        <section class="sh-hero">
            <div class="sh-hero__noise"></div>
            <div class="sh-hero__circles">
                <span class="sh-hero__c sh-hero__c--1"></span>
                <span class="sh-hero__c sh-hero__c--2"></span>
            </div>
            <div class="container">
                <div class="sh-hero__inner">
                    <nav class="sh-breadcrumb">
                        <a href="/{{ App::getLocale() }}">{{ __('Ana Sayfa') }}</a>
                        <i class="fas fa-chevron-right"></i>
                        <a href="{{ url()->previous() }}">{{ __('Hizmetler') }}</a>
                        <i class="fas fa-chevron-right"></i>
                        <span>{!! $baslik !!}</span>
                    </nav>
                    <span class="sh-hero__eyebrow">{{ __('Hizmet Detayı') }}</span>
                    <h1 class="sh-hero__title">{!! $baslik !!}</h1>
                    @if($altbaslik)
                        <p class="sh-hero__sub">{!! $altbaslik !!}</p>
                    @endif
                </div>
            </div>
            <div class="sh-hero__line"></div>
        </section>

        <!-- Content -->
        <section class="sh-detail">
            <div class="container">
                <div class="sh-detail__grid">

                    <!-- Ana İçerik -->
                    <div class="sh-detail__main">

                        @php
                            // Tüm paragrafları al (ilk satır hariç liste için ayrılacak)
                            $contentText = strip_tags($icerik);
                            $paragraphs = array_filter(array_map('trim', explode("\n", $contentText)));
                            $paragraphs = array_values($paragraphs);
                            
                            // İlk paragrafı intro olarak al
                            $intro = $paragraphs[0] ?? '';
                            
                            // Diğer paragrafları (başlıklar dahil) al
                            $otherParas = array_slice($paragraphs, 1);
                        @endphp
                        
                        @if($intro)
                            <p class="sh-intro">{!! $intro !!}</p>
                        @endif
                        
                        @foreach($otherParas as $para)
                            @if(trim($para))
                                @php
                                    $isBold = strpos($para, 'çalıştığınızda:') !== false || 
                                              strpos($para, 'Nedir?') !== false ||
                                              mb_substr($para, -1) === ':';
                                @endphp
                                @if($isBold)
                                    <h3 class="sh-subtitle">{!! $para !!}</h3>
                                @else
                                    <p class="sh-paragraph">{!! $para !!}</p>
                                @endif
                            @endif
                        @endforeach

                        @php
                            // Liste öğelerini işle
                            preg_match_all('/<li[^>]*>(.*?)<\/li>/s', $icerik, $matches);
                            $items = $matches[1] ?? [];
                            $groups = [];
                            $currentGroup = [];
                            foreach($items as $item) {
                                $text = strip_tags($item);
                                if(strpos($text, 'YATIRIM DÖNEMİ') !== false || strpos($text, 'İŞLETME DÖNEMİ') !== false) {
                                    if(!empty($currentGroup)) $groups[] = $currentGroup;
                                    $currentGroup = ['title' => $text, 'items' => []];
                                } else {
                                    $currentGroup['items'][] = $text;
                                }
                            }
                            if(!empty($currentGroup)) $groups[] = $currentGroup;
                        @endphp

                        @if(!empty($groups))
                            <div class="sh-groups">
                                @foreach($groups as $group)
                                    <div class="sh-group">
                                        @if(!empty($group['title']))
                                            <h3 class="sh-group__title">{!! $group['title'] !!}</h3>
                                        @endif
                                        <div class="sh-group__grid">
                                            @foreach($group['items'] as $item)
                                                <div class="sh-feat">
                                                    <span class="sh-feat__dot"></span>
                                                    <span>{!! $item !!}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- CTA -->
                        <div class="sh-cta">
                            <div class="sh-cta__left">
                                <span class="sh-cta__icon"><i class="fas fa-phone-alt"></i></span>
                                <div>
                                    <h4>{{ __('Bu hizmet hakkında bilgi alın') }}</h4>
                                    <p>{{ __('Uzman ekibimiz size yardımcı olmaya hazır') }}</p>
                                </div>
                            </div>
                            <a href="{{ route('showPage', [App::getLocale(), 'iletisim']) }}" class="sh-cta__btn">
                                {{ __('Bize Ulaşın') }}
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    @if(count($list) > 1)
                        <aside class="sh-sidebar">
                            <div class="sh-sidebar__box">
                                <p class="sh-sidebar__label">{{ __('Diğer Hizmetler') }}</p>
                                <ul class="sh-sidebar__list">
                                    @foreach(array_slice($list, 0, 5) as $hizmet)
                                        @if($hizmet['id'] != ($detail['id'] ?? 0))
                                            @php
                                                $hbaslik         = getValue('baslik', $hizmet);
                                                $hmenuPermalink  = $hizmet['menu']['permalink'] ?? '';
                                                $hlanguageKey    = $hizmet['language']['key'] ?? 'tr';
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

        <!-- Hero -->
        <section class="sl-hero">
            <div class="sl-hero__noise"></div>
            <div class="sl-hero__circles">
                <span class="sl-hero__c sl-hero__c--1"></span>
                <span class="sl-hero__c sl-hero__c--2"></span>
            </div>
            <div class="container">
                <div class="sl-hero__inner">
                    <span class="sl-hero__eyebrow">{{ __('Hizmetlerimiz') }}</span>
                    <h1 class="sl-hero__title">{{ __('Profesyonel') }} <em>{{ __('Çözümler') }}</em></h1>
                    <p class="sl-hero__sub">{{ __('İşletmenizin büyümesi için sunduğumuz danışmanlık hizmetleri') }}</p>
                </div>
            </div>
            <div class="sl-hero__line"></div>
        </section>

        <!-- List -->
        <section class="sl-main">
            <div class="container">
                @if(count($list) > 0)
                    <div class="sl-grid">
                        @foreach($list as $index => $hizmet)
                            @php
                                $baslik         = getValue('baslik', $hizmet);
                                $altbaslik      = getValue('altbaslik', $hizmet);
                                $menuPermalink  = $hizmet['menu']['permalink'] ?? '';
                                $languageKey    = $hizmet['language']['key'] ?? 'tr';
                            @endphp
                            <article class="sl-card">
                                <div class="sl-card__top">
                                    <span class="sl-card__num">{{ sprintf('%02d', $index + 1) }}</span>
                                    <div class="sl-card__dash"></div>
                                </div>
                                <h3 class="sl-card__title">{!! $baslik !!}</h3>
                                @if($altbaslik)
                                    <p class="sl-card__desc">{!! $altbaslik !!}</p>
                                @endif
                                <a href="{{ route('showPage', [$languageKey, $menuPermalink, $hizmet['permalink']]) }}" class="sl-card__link">
                                    {{ __('Detayı İncele') }}
                                    <span class="sl-card__arr"><i class="fas fa-arrow-right"></i></span>
                                </a>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="sl-empty">
                        <p>{{ __('Henüz hizmet eklenmemiş.') }}</p>
                    </div>
                @endif
            </div>
        </section>

    @endsection
@endif

@section('css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --bg:       #f8f7f4;
    --white:    #ffffff;
    --ink:      #1c1c1c;
    --ink-2:    #555550;
    --ink-3:    #9a9891;
    --border:   #e4e2dc;
    --border-2: #ccc9c0;
    --accent:   #2a3d52;
    --accent-l: rgba(42,61,82,0.06);
    --accent-m: rgba(42,61,82,0.12);
}

.container {
    width: min(1120px, 92vw);
    margin-inline: auto;
    font-family: 'Outfit', sans-serif;
    -webkit-font-smoothing: antialiased;
}

/* ══════════════════════════════════════
   SHARED HERO ATOMS
══════════════════════════════════════ */
.sh-hero, .sl-hero {
    position: relative;
    background: var(--white);
    padding: 130px 0 80px;
    border-bottom: 1px solid var(--border);
    overflow: hidden;
    font-family: 'Outfit', sans-serif;
}

.sh-hero__noise, .sl-hero__noise {
    position: absolute;
    inset: 0;
    background-image: repeating-linear-gradient(
        0deg,
        transparent, transparent 39px,
        rgba(0,0,0,0.022) 39px, rgba(0,0,0,0.022) 40px
    );
    pointer-events: none;
}

.sh-hero__circles, .sl-hero__circles {
    position: absolute;
    inset: 0;
    pointer-events: none;
}

.sh-hero__c, .sl-hero__c {
    position: absolute;
    border-radius: 50%;
    border: 1px solid var(--border);
}

.sh-hero__c--1, .sl-hero__c--1 { width: 380px; height: 380px; right: -100px; bottom: -120px; }
.sh-hero__c--2, .sl-hero__c--2 { width: 240px; height: 240px; right: -30px;  bottom: -50px;  }

.sh-hero__inner, .sl-hero__inner {
    position: relative;
    z-index: 1;
    animation: svFade .8s ease both;
}

@keyframes svFade {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

.sh-hero__eyebrow, .sl-hero__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: .68rem;
    font-weight: 500;
    letter-spacing: .2em;
    text-transform: uppercase;
    color: var(--accent);
    margin-bottom: 20px;
}

.sh-hero__eyebrow::before, .sl-hero__eyebrow::before {
    content: '';
    display: block;
    width: 28px; height: 1px;
    background: var(--accent);
    opacity: .5;
}

.sh-hero__title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.4rem, 5vw, 4.2rem);
    font-weight: 300;
    line-height: 1.08;
    color: var(--ink);
    letter-spacing: -.015em;
}

.sl-hero__title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.8rem, 5.5vw, 4.8rem);
    font-weight: 300;
    line-height: 1.08;
    color: var(--ink);
    letter-spacing: -.015em;
}

.sl-hero__title em {
    font-style: italic;
    color: var(--accent);
}

.sh-hero__sub, .sl-hero__sub {
    margin-top: 16px;
    font-size: .95rem;
    color: var(--ink-2);
    font-weight: 300;
}

.sh-hero__line, .sl-hero__line {
    position: absolute;
    left: 0; bottom: 0;
    width: 100%; height: 3px;
    background: linear-gradient(90deg, var(--accent) 0%, transparent 55%);
    opacity: .2;
}

/* ══════════════════════════════════════
   BREADCRUMB
══════════════════════════════════════ */
.sh-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 22px;
    font-size: .78rem;
    font-family: 'Outfit', sans-serif;
}

.sh-breadcrumb a {
    color: var(--ink-3);
    text-decoration: none;
    transition: color .2s;
}

.sh-breadcrumb a:hover { color: var(--accent); }

.sh-breadcrumb i {
    font-size: .5rem;
    color: var(--border-2);
}

.sh-breadcrumb span { color: var(--ink-2); font-weight: 500; }

/* ══════════════════════════════════════
   DETAY — LAYOUT
══════════════════════════════════════ */
.sh-detail {
    padding: 60px 0 100px;
    background: var(--bg);
    font-family: 'Outfit', sans-serif;
}

.sh-detail__grid {
    display: grid;
    grid-template-columns: 1fr 268px;
    gap: 50px;
    align-items: start;
}

/* Intro */
.sh-intro {
    font-size: 1.05rem;
    color: var(--ink-2);
    line-height: 1.8;
    font-weight: 300;
    margin-bottom: 24px;
    padding-bottom: 32px;
    border-bottom: 1px solid var(--border);
}

/* Diğer Paragraflar */
.sh-paragraph {
    font-size: 0.95rem;
    color: var(--ink-2);
    line-height: 1.75;
    font-weight: 300;
    margin-bottom: 20px;
}

/* Alt Başlıklar */
.sh-subtitle {
    font-size: 1rem;
    font-weight: 600;
    color: var(--ink);
    margin: 28px 0 16px;
    font-family: 'Outfit', sans-serif;
}

/* Feature groups */
.sh-groups {
    display: flex;
    flex-direction: column;
    gap: 28px;
}

.sh-group {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 28px 30px;
}

.sh-group__title {
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--accent);
    margin-bottom: 20px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--border);
}

.sh-group__grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.sh-feat {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 14px;
    background: var(--bg);
    border-radius: 8px;
    font-size: .875rem;
    color: var(--ink-2);
    line-height: 1.5;
    font-family: 'Outfit', sans-serif;
    transition: background .2s;
}

.sh-feat:hover { background: var(--accent-l); }

.sh-feat__dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--accent);
    flex-shrink: 0;
    margin-top: 5px;
    opacity: .6;
}

/* CTA */
.sh-cta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    margin-top: 40px;
    padding: 28px 32px;
    background: var(--accent);
    border-radius: 12px;
    color: #fff;
}

.sh-cta__left {
    display: flex;
    align-items: center;
    gap: 18px;
}

.sh-cta__icon {
    width: 46px; height: 46px;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.sh-cta h4 {
    font-size: .95rem;
    font-weight: 500;
    margin-bottom: 3px;
    font-family: 'Outfit', sans-serif;
}

.sh-cta p {
    font-size: .82rem;
    color: rgba(255,255,255,.6);
    font-weight: 300;
    font-family: 'Outfit', sans-serif;
}

.sh-cta__btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    background: var(--white);
    color: var(--accent);
    border-radius: 8px;
    font-family: 'Outfit', sans-serif;
    font-size: .875rem;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
    transition: all .22s;
}

.sh-cta__btn:hover {
    background: var(--bg);
    box-shadow: 0 6px 20px rgba(0,0,0,.1);
    text-decoration: none;
    color: var(--accent);
}

.sh-cta__btn i { transition: transform .2s; }
.sh-cta__btn:hover i { transform: translateX(4px); }

/* Sidebar */
.sh-sidebar {
    position: sticky;
    top: 100px;
    height: fit-content;
}

.sh-sidebar__box {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 26px;
}

.sh-sidebar__label {
    font-size: .65rem;
    font-weight: 600;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--ink-3);
    margin-bottom: 16px;
    font-family: 'Outfit', sans-serif;
}

.sh-sidebar__list {
    list-style: none;
}

.sh-sidebar__list li {
    border-bottom: 1px solid var(--border);
}

.sh-sidebar__list li:last-child { border-bottom: none; }

.sh-sidebar__list a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 0;
    color: var(--ink-2);
    text-decoration: none;
    font-size: .875rem;
    font-family: 'Outfit', sans-serif;
    font-weight: 300;
    transition: all .2s;
}

.sh-sidebar__list a:hover {
    color: var(--accent);
    padding-left: 4px;
}

.sh-sidebar__list i {
    font-size: .55rem;
    color: var(--border-2);
    transition: color .2s;
}

.sh-sidebar__list a:hover i { color: var(--accent); }

/* ══════════════════════════════════════
   LİSTE — GRID
══════════════════════════════════════ */
.sl-main {
    padding: 70px 0 110px;
    background: var(--bg);
    font-family: 'Outfit', sans-serif;
}

.sl-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}

.sl-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 32px;
    display: flex;
    flex-direction: column;
    transition: transform .26s ease, box-shadow .26s ease, border-color .26s ease;
    animation: svFade .6s ease both;
}

.sl-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 44px rgba(42,61,82,.1);
    border-color: var(--border-2);
}

.sl-card__top {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 20px;
}

.sl-card__num {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.5rem;
    font-weight: 300;
    color: var(--accent);
    opacity: .5;
    line-height: 1;
}

.sl-card__dash {
    flex: 1;
    height: 1px;
    background: var(--border);
}

.sl-card__title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.45rem;
    font-weight: 400;
    color: var(--ink);
    line-height: 1.25;
    margin-bottom: 12px;
    letter-spacing: -.01em;
}

.sl-card__desc {
    font-size: .875rem;
    color: var(--ink-2);
    line-height: 1.65;
    font-weight: 300;
    flex: 1;
    margin-bottom: 28px;
}

.sl-card__link {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: .78rem;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--accent);
    text-decoration: none;
    margin-top: auto;
    transition: gap .2s;
}

.sl-card__link:hover { gap: 14px; text-decoration: none; }

.sl-card__arr {
    width: 28px; height: 28px;
    border: 1px solid var(--accent-m);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .65rem;
    transition: background .2s, border-color .2s;
}

.sl-card__link:hover .sl-card__arr {
    background: var(--accent);
    border-color: var(--accent);
    color: #fff;
}

/* Empty */
.sl-empty {
    text-align: center;
    padding: 100px 20px;
    color: var(--ink-3);
    font-size: .95rem;
    font-weight: 300;
    font-family: 'Outfit', sans-serif;
}

/* ══════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════ */
@media (max-width: 1024px) {
    .sh-detail__grid { grid-template-columns: 1fr; }
    .sh-sidebar       { position: static; }
    .sh-group__grid   { grid-template-columns: 1fr; }
    .sh-cta           { flex-direction: column; text-align: center; }
    .sh-cta__left     { flex-direction: column; text-align: center; }
}

@media (max-width: 768px) {
    .sh-hero, .sl-hero { padding: 100px 0 65px; }
    .sl-grid            { grid-template-columns: 1fr; }
    .sh-group           { padding: 22px 20px; }
}
</style>
@endsection
