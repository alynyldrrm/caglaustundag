@extends('client.layout')
@section('title', __('Anasayfa'))

@php
    $homeSections = getTypeValues('sayfalar', 1);
    $homeSection  = count($homeSections) > 0 ? $homeSections[0] : null;

    if ($homeSection) {
        $resim = isset($homeSection['fields']['gorsel'][0])
            ? getImageLink($homeSection['fields']['gorsel'][0]['path'], ['w' => 800, 'h' => 600, 'fit' => 'cover'])
            : '/assets/client/img/style-switcher.png';
    }

    $hizmetler   = getTypeValues('hizmetler', 100);  // tümünü çek, sonra slice et
    $referanslar = getTypeValues('referanslar', 5);

    // Hizmetler liste sayfası URL'si
    // getMenus() tüm nav menülerini döner (parent + children birlikte)
    // parent_id null olanlar ana menü, dolu olanlar alt menü
    $hizmetlerMenuUrl   = '';
    $referanslarMenuUrl = '';
    $langKey            = App::getLocale();

    foreach(getMenus() as $menuItem) {
        // Ana menü (parent_id yok veya 0) ve type hizmetler
        if(empty($menuItem['parent_id'])) {
            $name = strtolower(strip_tags($menuItem['name'] ?? ''));
            $perm = $menuItem['permalink'] ?? '';
            $lang = $menuItem['language']['key'] ?? $langKey;

            if(stripos($name, 'hizmet') !== false || stripos($perm, 'hizmet') !== false) {
                $hizmetlerMenuUrl = route('showPage', [$lang, $perm]);
            }
            if(stripos($name, 'referans') !== false || stripos($perm, 'referans') !== false) {
                $referanslarMenuUrl = route('showPage', [$lang, $perm]);
            }
        }
    }
@endphp

@section('content')

    @include('client.partials.slider')

    {{-- Hakkımızda --}}
    @if($homeSection)
    <section class="ha-about">
        <div class="container">
            <div class="ha-about__grid">
                <div class="ha-about__content">
                    <span class="ha-eyebrow">{{ __('Hakkımızda') }}</span>
                    <h2 class="ha-title">{!! getValue('baslik', $homeSection) !!}</h2>
                    <div class="ha-about__text">
                        {!! substr(getValue('icerik', $homeSection), 0, 400) !!}...
                    </div>
                    <a href="/{{ App::getLocale() }}/hakkimizda" class="ha-btn ha-btn--dark">
                        {{ __('Devamını Gör') }}
                        <span class="ha-btn__arr"><i class="fas fa-arrow-right"></i></span>
                    </a>
                </div>
                <div class="ha-about__img">
                    <img src="{{ $resim }}" alt="{!! getValue('baslik', $homeSection) !!}">
                    <div class="ha-about__img-deco"></div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Hizmetler --}}
    @if(count($hizmetler) > 0)
    <section class="ha-services">
        <div class="container">
            <div class="ha-section-head">
                <div>
                    <span class="ha-eyebrow">{{ __('Hizmetlerimiz') }}</span>
                    <h2 class="ha-title">{{ __('Profesyonel Çözümler') }}</h2>
                </div>
                @if($hizmetlerMenuUrl)
                <a href="{{ $hizmetlerMenuUrl }}" class="ha-btn ha-btn--outline ha-btn--sm">
                    {{ __('Tüm Hizmetleri Gör') }}
                    <span class="ha-btn__arr"><i class="fas fa-arrow-right"></i></span>
                </a>
                @endif
            </div>
            <div class="ha-services__grid">
                @foreach(array_slice($hizmetler, 0, 4) as $index => $hizmet)
                @php
                    $hMenuPermalink = $hizmet['menu']['permalink'] ?? '';
                    $hLangKey       = $hizmet['language']['key'] ?? App::getLocale();
                @endphp
                <a href="{{ route('showPage', [$hLangKey, $hMenuPermalink, $hizmet['permalink']]) }}" class="ha-scard">
                    <span class="ha-scard__num">{{ sprintf('%02d', $index + 1) }}</span>
                    <div class="ha-scard__ico">
                        @if(isset($hizmet['fields']['icon'][0]))
                            <img src="{{ getImageLink($hizmet['fields']['icon'][0]['path'], ['w' => 60, 'h' => 60, 'fit' => 'contain']) }}" alt="">
                        @else
                            <i class="fas fa-briefcase"></i>
                        @endif
                    </div>
                    <h3 class="ha-scard__name">{!! $hizmet['name'] !!}</h3>
                    @if(getValue('kisa_aciklama', $hizmet))
                        <p class="ha-scard__desc">{!! substr(getValue('kisa_aciklama', $hizmet), 0, 100) !!}...</p>
                    @endif
                    <span class="ha-scard__link">{{ __('Detay') }} <i class="fas fa-arrow-right"></i></span>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Referanslar --}}
    @if(count($referanslar) > 0)
    <section class="ha-refs">
        <div class="container">
            <div class="ha-section-head">
                <div>
                    <span class="ha-eyebrow">{{ __('Referanslar') }}</span>
                    <h2 class="ha-title">{{ __('İş Ortaklarımız') }}</h2>
                </div>
                @if($referanslarMenuUrl)
                <a href="{{ $referanslarMenuUrl }}" class="ha-btn ha-btn--outline ha-btn--sm">
                    {{ __('Tüm Referansları Gör') }}
                    <span class="ha-btn__arr"><i class="fas fa-arrow-right"></i></span>
                </a>
                @endif
            </div>
            <div class="ha-refs__grid">
                @foreach($referanslar as $referans)
                <div class="ha-ref" onclick="openRefModal({{ $referans['id'] }})">
                    @if(isset($referans['fields']['resim'][0]))
                        <img src="{{ getImageLink($referans['fields']['resim'][0]['path'], ['w' => 200, 'h' => 120, 'q' => 90, 'fit' => 'contain']) }}"
                             alt="{!! $referans['name'] !!}">
                    @else
                        <div class="ha-ref__name">{!! $referans['name'] !!}</div>
                    @endif
                    <div class="ha-ref__overlay"><i class="fas fa-eye"></i></div>
                </div>

                <div id="ref-modal-{{ $referans['id'] }}" class="ref-modal">
                    <div class="ref-overlay" onclick="closeRefModal({{ $referans['id'] }})"></div>
                    <div class="ref-content">
                        <button class="ref-close" onclick="closeRefModal({{ $referans['id'] }})">
                            <i class="fas fa-times"></i>
                        </button>
                        <h3>{!! $referans['name'] !!}</h3>
                        @php $detay = getValue('Detay', $referans) ?: getValue('detay', $referans); @endphp
                        @if($detay)<p>{!! $detay !!}</p>@endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- İstatistikler --}}
    <section class="ha-stats">
        <div class="container">
            <div class="ha-stats__grid">
                <div class="ha-stat">
                    <span class="ha-stat__num">10+</span>
                    <span class="ha-stat__lbl">{{ __('Yıllık Tecrübe') }}</span>
                </div>
                <div class="ha-stat">
                    <span class="ha-stat__num">500+</span>
                    <span class="ha-stat__lbl">{{ __('Mutlu Müşteri') }}</span>
                </div>
                <div class="ha-stat">
                    <span class="ha-stat__num">50+</span>
                    <span class="ha-stat__lbl">{{ __('Uzman Kadro') }}</span>
                </div>
                <div class="ha-stat">
                    <span class="ha-stat__num">1000+</span>
                    <span class="ha-stat__lbl">{{ __('Tamamlanan Proje') }}</span>
                </div>
            </div>
        </div>
    </section>

    <script>
    function openRefModal(id) {
        const m = document.getElementById('ref-modal-' + id);
        if(m) { m.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
    }
    function closeRefModal(id) {
        const m = document.getElementById('ref-modal-' + id);
        if(m) { m.style.display = 'none'; document.body.style.overflow = ''; }
    }
    document.addEventListener('keydown', e => {
        if(e.key === 'Escape') {
            document.querySelectorAll('.ref-modal').forEach(m => { m.style.display = 'none'; });
            document.body.style.overflow = '';
        }
    });
    </script>
@endsection

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

/* ─── base ─── */
.ha-about, .ha-services, .ha-refs, .ha-stats,
.ha-about *, .ha-services *, .ha-refs *, .ha-stats * {
    font-family: 'Outfit', sans-serif;
    -webkit-font-smoothing: antialiased;
}

.container { width: min(1140px, 92vw); margin-inline: auto; }

/* ─── shared atoms ─── */
.ha-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: .68rem;
    font-weight: 500;
    letter-spacing: .2em;
    text-transform: uppercase;
    color: var(--accent);
    margin-bottom: 14px;
}

.ha-eyebrow::before {
    content: '';
    display: block;
    width: 26px; height: 1px;
    background: var(--accent);
    opacity: .5;
}

.ha-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 300;
    line-height: 1.12;
    color: var(--ink);
    letter-spacing: -.015em;
    margin-bottom: 0;
}

.ha-section-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 24px;
    margin-bottom: 44px;
    padding-bottom: 28px;
    border-bottom: 1px solid var(--border);
}

/* ─── buttons ─── */
.ha-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 13px 26px;
    border-radius: 8px;
    font-size: .875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all .22s;
    white-space: nowrap;
    letter-spacing: .02em;
}

.ha-btn--dark {
    background: var(--accent);
    color: #fff;
    border: 1px solid var(--accent);
}

.ha-btn--dark:hover {
    background: #1e2e3f;
    box-shadow: 0 8px 28px var(--accent-m);
    transform: translateY(-2px);
    color: #fff;
    text-decoration: none;
}

.ha-btn--outline {
    background: transparent;
    color: var(--accent);
    border: 1px solid var(--accent-m);
}

.ha-btn--outline:hover {
    background: var(--accent);
    color: #fff;
    border-color: var(--accent);
    text-decoration: none;
}

.ha-btn--sm { padding: 10px 20px; font-size: .78rem; }

.ha-btn__arr {
    width: 24px; height: 24px;
    border-radius: 4px;
    display: flex; align-items: center; justify-content: center;
    font-size: .7rem;
    transition: transform .2s;
}

.ha-btn--dark .ha-btn__arr   { background: rgba(255,255,255,.15); }
.ha-btn--outline .ha-btn__arr { background: var(--accent-l); }

.ha-btn:hover .ha-btn__arr { transform: translateX(4px); }
.ha-btn--outline:hover .ha-btn__arr { background: rgba(255,255,255,.15); }

/* ═══════════════════════════════════
   HAKKIMIZDA
═══════════════════════════════════ */
.ha-about {
    padding: 100px 0;
    background: var(--white);
    border-bottom: 1px solid var(--border);
}

.ha-about__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
}

.ha-about__content { display: flex; flex-direction: column; gap: 0; }

.ha-about__content .ha-title { margin: 0 0 22px; }

.ha-about__text {
    font-size: 1rem;
    color: var(--ink-2);
    line-height: 1.8;
    font-weight: 300;
    margin-bottom: 32px;
}

.ha-about__img {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
}

.ha-about__img img {
    width: 100%;
    display: block;
    border-radius: 12px;
    border: 1px solid var(--border);
}

.ha-about__img-deco {
    position: absolute;
    inset: -8px -8px auto auto;
    width: 120px; height: 120px;
    border: 1px solid var(--border);
    border-radius: 50%;
    pointer-events: none;
    z-index: -1;
}

/* ═══════════════════════════════════
   HİZMETLER
═══════════════════════════════════ */
.ha-services {
    padding: 100px 0;
    background: var(--bg);
    border-bottom: 1px solid var(--border);
}

.ha-services__grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.ha-scard {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 28px 24px;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    color: inherit;
    transition: transform .26s ease, box-shadow .26s ease, border-color .26s ease;
    position: relative;
    overflow: hidden;
}

.ha-scard::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    width: 0; height: 2px;
    background: var(--accent);
    transition: width .3s ease;
}

.ha-scard:hover { transform: translateY(-5px); box-shadow: 0 16px 44px rgba(42,61,82,.1); border-color: var(--border-2); text-decoration: none; color: inherit; }
.ha-scard:hover::after { width: 100%; }

.ha-scard__num {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.3rem;
    font-weight: 300;
    color: var(--accent);
    opacity: .35;
    margin-bottom: 16px;
    line-height: 1;
}

.ha-scard__ico {
    width: 44px; height: 44px;
    background: var(--accent-l);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: var(--accent);
    font-size: 1.1rem;
    margin-bottom: 16px;
    transition: background .2s;
}

.ha-scard:hover .ha-scard__ico { background: var(--accent-m); }

.ha-scard__ico img { max-width: 22px; max-height: 22px; }

.ha-scard__name {
    font-size: 1rem;
    font-weight: 500;
    color: var(--ink);
    margin-bottom: 10px;
    line-height: 1.35;
}

.ha-scard__desc {
    font-size: .85rem;
    color: var(--ink-2);
    line-height: 1.6;
    font-weight: 300;
    flex: 1;
    margin-bottom: 20px;
}

.ha-scard__link {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--accent);
    margin-top: auto;
    transition: gap .2s;
}

.ha-scard:hover .ha-scard__link { gap: 11px; }

/* ═══════════════════════════════════
   REFERANSLAR
═══════════════════════════════════ */
.ha-refs {
    padding: 100px 0;
    background: var(--white);
    border-bottom: 1px solid var(--border);
}

.ha-refs__grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 18px;
}

.ha-ref {
    position: relative;
    height: 96px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    padding: 18px;
    cursor: pointer;
    overflow: hidden;
    transition: border-color .22s, box-shadow .22s;
}

.ha-ref:hover { border-color: var(--border-2); box-shadow: 0 8px 24px rgba(42,61,82,.08); }

.ha-ref img {
    max-width: 100%; max-height: 100%;
    object-fit: contain;
    filter: grayscale(1) opacity(.65);
    transition: filter .3s;
}

.ha-ref:hover img { filter: grayscale(0) opacity(1); }

.ha-ref__name {
    font-size: .85rem;
    font-weight: 500;
    color: var(--ink-2);
    text-align: center;
    line-height: 1.4;
}

.ha-ref__overlay {
    position: absolute;
    inset: 0;
    background: var(--accent);
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: .9rem;
    opacity: 0;
    transition: opacity .25s;
}

.ha-ref:hover .ha-ref__overlay { opacity: .85; }

/* Modal */
.ref-modal {
    display: none;
    position: fixed; inset: 0;
    z-index: 1000;
    align-items: center; justify-content: center;
}

.ref-overlay {
    position: absolute; inset: 0;
    background: rgba(28,28,28,.55);
    backdrop-filter: blur(4px);
}

.ref-content {
    position: relative;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 44px;
    max-width: 520px; width: 90%;
    z-index: 1001;
    box-shadow: 0 32px 80px rgba(28,28,28,.16);
}

.ref-close {
    position: absolute; top: 18px; right: 18px;
    width: 34px; height: 34px;
    border: 1px solid var(--border);
    background: var(--bg);
    border-radius: 50%;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: var(--ink-3); font-size: .75rem;
    transition: all .2s;
}

.ref-close:hover { border-color: var(--accent); color: var(--accent); }

.ref-content h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem; font-weight: 400;
    color: var(--ink); margin-bottom: 18px;
    padding-bottom: 18px; border-bottom: 1px solid var(--border);
    letter-spacing: -.01em; line-height: 1.2;
}

.ref-content p {
    font-size: .92rem; color: var(--ink-2);
    line-height: 1.75; font-weight: 300;
}

/* ═══════════════════════════════════
   İSTATİSTİKLER
═══════════════════════════════════ */
.ha-stats {
    padding: 80px 0;
    background: var(--accent);
    border-bottom: 1px solid rgba(255,255,255,.08);
}

.ha-stats__grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
}

.ha-stat {
    display: flex; flex-direction: column; align-items: center;
    padding: 12px 20px;
    border-right: 1px solid rgba(255,255,255,.12);
    text-align: center;
}

.ha-stat:last-child { border-right: none; }

.ha-stat__num {
    display: block;
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.8rem, 4vw, 4rem);
    font-weight: 300;
    color: #fff;
    line-height: 1;
    margin-bottom: 10px;
    letter-spacing: -.02em;
}

.ha-stat__lbl {
    font-size: .68rem;
    font-weight: 500;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: rgba(255,255,255,.55);
}

/* ─── responsive ─── */
@media (max-width: 1100px) {
    .ha-services__grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 1024px) {
    .ha-about__grid { grid-template-columns: 1fr; gap: 48px; }
    .ha-about__img  { order: -1; }
    .ha-refs__grid  { grid-template-columns: repeat(3, 1fr); }
    .ha-stats__grid { grid-template-columns: repeat(2, 1fr); }
    .ha-stat        { border-bottom: 1px solid rgba(255,255,255,.12); padding: 28px 20px; }
    .ha-stat:nth-child(2), .ha-stat:last-child { border-right: none; }
}

@media (max-width: 768px) {
    .ha-about, .ha-services, .ha-refs { padding: 70px 0; }
    .ha-section-head { flex-direction: column; align-items: flex-start; gap: 16px; }
    .ha-services__grid { grid-template-columns: 1fr; }
    .ha-refs__grid  { grid-template-columns: repeat(2, 1fr); }
    .ha-stats__grid { grid-template-columns: 1fr; }
    .ha-stat        { border-right: none; }
    .ref-content    { padding: 30px 22px; }
}
</style>
@endsection
