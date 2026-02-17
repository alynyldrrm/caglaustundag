@php
    $currentLanguage = session('defaultDatas')['currentLanguage'] ?? null;

    if(!isset($list) || !is_array($list) || count($list) == 0) {
        $list = getTypeValues('referanslar', 100);
    }
@endphp

@extends('client.layout')

@section('title', $menu->name ?? __('Referanslar'))

@section('content')

<div class="rp">

    <!-- Hero -->
    <section class="rp-hero">
        <div class="rp-hero__noise"></div>
        <div class="rp-hero__circles">
            <span class="rp-hero__c rp-hero__c--1"></span>
            <span class="rp-hero__c rp-hero__c--2"></span>
        </div>
        <div class="container">
            <div class="rp-hero__inner">

                <h1 class="rp-hero__title">{!! $menu->name ?? __('Referanslar') !!}</h1>
                <p class="rp-hero__sub">{{ __('Başarı projelerimiz ve iş ortaklarımız') }}</p>
            </div>
        </div>
        <div class="rp-hero__line"></div>
    </section>

    <!-- Grid -->
    <section class="rp-main">
        <div class="container">
            @if($list && count($list) > 0)
                <div class="rp-grid">
                    @foreach($list as $referans)
                        <div class="rp-card" onclick="openReferenceModal({{ $referans['id'] }})">
                            <div class="rp-card__img">
                                @if(isset($referans['fields']['resim'][0]))
                                    <img src="{{ getImageLink($referans['fields']['resim'][0]['path'], ['w' => 300, 'h' => 200, 'q' => 90, 'fit' => 'contain']) }}"
                                         alt="{!! $referans['name'] !!}" loading="lazy">
                                @elseif(isset($referans['fields']['logo'][0]))
                                    <img src="{{ getImageLink($referans['fields']['logo'][0]['path'], ['w' => 300, 'h' => 200, 'q' => 90, 'fit' => 'contain']) }}"
                                         alt="{!! $referans['name'] !!}" loading="lazy">
                                @else
                                    <div class="rp-card__initials">
                                        <span>{!! mb_substr(strip_tags($referans['name']), 0, 2) !!}</span>
                                    </div>
                                @endif
                                <div class="rp-card__overlay">
                                    <span><i class="fas fa-eye"></i></span>
                                </div>
                            </div>
                            <div class="rp-card__body">
                                <h3 class="rp-card__name">{{ $referans['name'] }}</h3>
                                @if(getValue('sektor', $referans))
                                    <span class="rp-card__tag">{!! getValue('sektor', $referans) !!}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Modal -->
                        <div id="reference-modal-{{ $referans['id'] }}" class="ref-modal-page">
                            <div class="ref-overlay-page" onclick="closeReferenceModal({{ $referans['id'] }})"></div>
                            <div class="ref-content-page">
                                <button class="ref-close-page" onclick="closeReferenceModal({{ $referans['id'] }})">
                                    <i class="fas fa-times"></i>
                                </button>
                                <h3>{!! $referans['name'] !!}</h3>
                                @php
                                    $detay = getValue('Detay', $referans) ?: getValue('detay', $referans);
                                @endphp
                                @if($detay)
                                    <p>{!! $detay !!}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rp-empty">
                    <i class="fas fa-folder-open"></i>
                    <p>{{ __('Henüz referans eklenmemiş.') }}</p>
                </div>
            @endif
        </div>
    </section>

</div>

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

.rp {
    font-family: 'Outfit', sans-serif;
    background: var(--bg);
    color: var(--ink);
    -webkit-font-smoothing: antialiased;
}

.container {
    width: min(1200px, 92vw);
    margin-inline: auto;
}

/* ── Hero ── */
.rp-hero {
    position: relative;
    background: var(--white);
    padding: 130px 0 80px;
    border-bottom: 1px solid var(--border);
    overflow: hidden;
}

.rp-hero__noise {
    position: absolute;
    inset: 0;
    background-image: repeating-linear-gradient(
        0deg,
        transparent,
        transparent 39px,
        rgba(0,0,0,0.022) 39px,
        rgba(0,0,0,0.022) 40px
    );
    pointer-events: none;
}

.rp-hero__circles { position: absolute; inset: 0; pointer-events: none; }

.rp-hero__c {
    position: absolute;
    border-radius: 50%;
    border: 1px solid var(--border);
}

.rp-hero__c--1 {
    width: 380px; height: 380px;
    right: -100px; bottom: -120px;
}

.rp-hero__c--2 {
    width: 240px; height: 240px;
    right: -30px; bottom: -50px;
}

.rp-hero__inner {
    position: relative;
    z-index: 1;
    animation: rpFade 0.8s ease both;
}

@keyframes rpFade {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

.rp-hero__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 0.68rem;
    font-weight: 500;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--accent);
    margin-bottom: 20px;
}

.rp-hero__eyebrow::before {
    content: '';
    display: block;
    width: 28px; height: 1px;
    background: var(--accent);
    opacity: 0.5;
}

.rp-hero__title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.8rem, 5.5vw, 4.8rem);
    font-weight: 300;
    line-height: 1.08;
    color: var(--ink);
    letter-spacing: -0.015em;
}

.rp-hero__sub {
    margin-top: 16px;
    font-size: 0.95rem;
    color: var(--ink-2);
    font-weight: 300;
}

.rp-hero__line {
    position: absolute;
    left: 0; bottom: 0;
    width: 100%; height: 3px;
    background: linear-gradient(90deg, var(--accent) 0%, transparent 55%);
    opacity: 0.2;
}

/* ── Main ── */
.rp-main {
    padding: 70px 0 110px;
}

/* ── Grid ── */
.rp-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 24px;
}

/* ── Card ── */
.rp-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
    animation: rpFade 0.6s ease both;
}

.rp-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 48px rgba(42,61,82,0.12);
    border-color: var(--border-2);
}

/* Image area */
.rp-card__img {
    position: relative;
    height: 150px;
    background: var(--bg);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    overflow: hidden;
    border-bottom: 1px solid var(--border);
}

.rp-card__img img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    filter: grayscale(100%) opacity(0.7);
    transition: filter 0.35s ease, transform 0.35s ease;
}

.rp-card:hover .rp-card__img img {
    filter: grayscale(0%) opacity(1);
    transform: scale(1.04);
}

/* Initials fallback */
.rp-card__initials {
    width: 64px; height: 64px;
    border-radius: 10px;
    background: var(--accent-m);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.5rem;
    font-weight: 500;
    color: var(--accent);
    letter-spacing: 0.04em;
}

/* Hover overlay */
.rp-card__overlay {
    position: absolute;
    inset: 0;
    background: var(--accent);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.28s ease;
}

.rp-card:hover .rp-card__overlay { opacity: 0.88; }

.rp-card__overlay span {
    width: 44px; height: 44px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 0.9rem;
}

/* Body */
.rp-card__body {
    padding: 18px 20px;
    background: var(--white);
}

.rp-card__name {
    font-size: 0.92rem;
    font-weight: 500;
    color: var(--ink);
    margin-bottom: 8px;
    line-height: 1.4;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.rp-card__tag {
    display: inline-block;
    font-size: 0.7rem;
    font-weight: 500;
    letter-spacing: 0.06em;
    color: var(--accent);
    background: var(--accent-l);
    border: 1px solid var(--accent-m);
    border-radius: 4px;
    padding: 3px 10px;
}

/* ── Modal ── */
.ref-modal-page {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.ref-modal-page.active { display: flex; }

.ref-overlay-page {
    position: absolute;
    inset: 0;
    background: rgba(28,28,28,0.6);
    backdrop-filter: blur(4px);
}

.ref-content-page {
    position: relative;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 44px;
    max-width: 520px;
    width: 90%;
    z-index: 1001;
    box-shadow: 0 32px 80px rgba(28,28,28,0.18);
    animation: rpFade 0.3s ease both;
}

.ref-close-page {
    position: absolute;
    top: 18px; right: 18px;
    width: 34px; height: 34px;
    border: 1px solid var(--border);
    background: var(--bg);
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ink-3);
    font-size: 0.75rem;
    transition: all 0.2s;
}

.ref-close-page:hover {
    border-color: var(--accent);
    color: var(--accent);
}

.ref-content-page h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    font-weight: 400;
    color: var(--ink);
    margin-bottom: 18px;
    padding-bottom: 18px;
    border-bottom: 1px solid var(--border);
    letter-spacing: -0.01em;
    line-height: 1.2;
}

.ref-content-page p {
    font-size: 0.92rem;
    color: var(--ink-2);
    line-height: 1.75;
    font-weight: 300;
}

/* ── Empty ── */
.rp-empty {
    text-align: center;
    padding: 120px 20px;
    color: var(--ink-3);
}

.rp-empty i {
    font-size: 3.5rem;
    margin-bottom: 20px;
    display: block;
    opacity: 0.3;
}

.rp-empty p {
    font-size: 1rem;
    font-weight: 300;
}

/* ── Responsive ── */
@media (max-width: 1024px) {
    .rp-grid { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
}

@media (max-width: 768px) {
    .rp-hero  { padding: 100px 0 65px; }
    .rp-grid  { grid-template-columns: repeat(2, 1fr); gap: 16px; }
    .rp-card__img { height: 120px; padding: 18px; }
    .ref-content-page { padding: 32px 24px; }
}

@media (max-width: 480px) {
    .rp-grid { grid-template-columns: 1fr; }
}
</style>
@endsection

<script>
function openReferenceModal(id) {
    const modal = document.getElementById('reference-modal-' + id);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeReferenceModal(id) {
    const modal = document.getElementById('reference-modal-' + id);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.ref-modal-page.active').forEach(function(modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
});
</script>
