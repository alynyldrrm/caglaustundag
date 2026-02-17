@php
    $currentLanguage = session('defaultDatas')['currentLanguage'] ?? null;

    $hakkimizdaList = getTypeValues('sayfalar', 1);
    $hakkimizda     = count($hakkimizdaList) > 0 ? $hakkimizdaList[0] : null;
@endphp

@extends('client.layout')

@section('title', $menu->name ?? __('Hakkımızda'))

@section('content')

<div class="hk">

    <!-- Hero -->
    <section class="hk-hero">
        <div class="hk-hero__noise"></div>
        <div class="hk-hero__circles">
            <span class="hk-hero__c hk-hero__c--1"></span>
            <span class="hk-hero__c hk-hero__c--2"></span>
        </div>
        <div class="container">
            <div class="hk-hero__inner">

                <h1 class="hk-hero__title">{!! $menu->name ?? __('Hakkımızda') !!}</h1>
            </div>
        </div>
        <div class="hk-hero__line"></div>
    </section>

    <!-- Content -->
    <section class="hk-main">
        <div class="container">
            @if($hakkimizda)
                <div class="hk-grid">

                    <!-- Görsel -->
                    <div class="hk-img-wrap">
                        @if(isset($hakkimizda['fields']['gorsel'][0]))
                            <img src="{{ getImageLink($hakkimizda['fields']['gorsel'][0]['path'], ['w' => 800, 'h' => 600, 'fit' => 'cover']) }}"
                                 alt="{!! getValue('baslik', $hakkimizda) !!}">
                        @endif
                        <div class="hk-img-wrap__deco"></div>
                    </div>

                    <!-- Yazı -->
                    <div class="hk-content">
                        <span class="hk-eyebrow hk-eyebrow--sm">{{ __('Biz Kimiz') }}</span>
                        <h2 class="hk-content__title">{!! getValue('baslik', $hakkimizda) !!}</h2>
                        <div class="hk-content__divider"></div>
                        <div class="hk-content__text">
                            {!! getValue('icerik', $hakkimizda) !!}
                        </div>
                    </div>

                </div>
            @else
                <div class="hk-empty">
                    <p>{{ __('İçerik bulunamadı.') }}</p>
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

.hk {
    font-family: 'Outfit', sans-serif;
    background: var(--bg);
    color: var(--ink);
    -webkit-font-smoothing: antialiased;
}

.container { width: min(1120px, 92vw); margin-inline: auto; }

/* ── Hero ── */
.hk-hero {
    position: relative;
    background: var(--white);
    padding: 130px 0 80px;
    border-bottom: 1px solid var(--border);
    overflow: hidden;
}

.hk-hero__noise {
    position: absolute; inset: 0;
    background-image: repeating-linear-gradient(
        0deg,
        transparent, transparent 39px,
        rgba(0,0,0,0.022) 39px, rgba(0,0,0,0.022) 40px
    );
    pointer-events: none;
}

.hk-hero__circles { position: absolute; inset: 0; pointer-events: none; }

.hk-hero__c {
    position: absolute;
    border-radius: 50%;
    border: 1px solid var(--border);
}

.hk-hero__c--1 { width: 380px; height: 380px; right: -100px; bottom: -120px; }
.hk-hero__c--2 { width: 240px; height: 240px; right: -30px;  bottom: -50px;  }

.hk-hero__inner {
    position: relative; z-index: 1;
    animation: hkFade .8s ease both;
}

@keyframes hkFade {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

.hk-eyebrow {
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

.hk-eyebrow::before {
    content: '';
    display: block;
    width: 28px; height: 1px;
    background: var(--accent);
    opacity: .5;
}

.hk-eyebrow--sm {
    font-size: .63rem;
    margin-bottom: 14px;
}

.hk-hero__title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.8rem, 5.5vw, 4.8rem);
    font-weight: 300;
    line-height: 1.08;
    color: var(--ink);
    letter-spacing: -.015em;
}

.hk-hero__line {
    position: absolute; left: 0; bottom: 0;
    width: 100%; height: 3px;
    background: linear-gradient(90deg, var(--accent) 0%, transparent 55%);
    opacity: .2;
}

/* ── Main ── */
.hk-main {
    padding: 80px 0 110px;
    background: var(--bg);
}

.hk-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 72px;
    align-items: center;
}

/* Görsel */
.hk-img-wrap {
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    animation: hkFade .8s .1s ease both;
}

.hk-img-wrap img {
    width: 100%;
    display: block;
    border-radius: 14px;
    border: 1px solid var(--border);
}

/* köşe dekor */
.hk-img-wrap__deco {
    position: absolute;
    bottom: -14px; right: -14px;
    width: 100px; height: 100px;
    border: 1px solid var(--border);
    border-radius: 50%;
    pointer-events: none;
    z-index: -1;
}

/* İçerik */
.hk-content {
    animation: hkFade .8s .2s ease both;
}

.hk-content__title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2rem, 3.5vw, 2.8rem);
    font-weight: 300;
    line-height: 1.15;
    color: var(--ink);
    letter-spacing: -.015em;
    margin-bottom: 22px;
}

.hk-content__divider {
    width: 48px; height: 2px;
    background: var(--accent);
    opacity: .35;
    margin-bottom: 28px;
    border-radius: 2px;
}

.hk-content__text {
    font-size: .975rem;
    color: var(--ink-2);
    line-height: 1.85;
    font-weight: 300;
}

.hk-content__text p {
    margin-bottom: 18px;
}

.hk-content__text p:last-child { margin-bottom: 0; }

.hk-content__text h2,
.hk-content__text h3,
.hk-content__text h4 {
    font-family: 'Cormorant Garamond', serif;
    font-weight: 400;
    color: var(--ink);
    margin: 28px 0 12px;
    letter-spacing: -.01em;
}

.hk-content__text h2 { font-size: 1.7rem; }
.hk-content__text h3 { font-size: 1.35rem; }
.hk-content__text h4 { font-size: 1.1rem; font-family: 'Outfit', sans-serif; }

.hk-content__text ul,
.hk-content__text ol {
    padding-left: 0;
    list-style: none;
    margin-bottom: 18px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.hk-content__text li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: .925rem;
    color: var(--ink-2);
    line-height: 1.6;
}

.hk-content__text li::before {
    content: '';
    width: 5px; height: 5px;
    border-radius: 50%;
    background: var(--accent);
    flex-shrink: 0;
    margin-top: 7px;
    opacity: .6;
}

.hk-content__text a {
    color: var(--accent);
    text-decoration: underline;
    text-underline-offset: 3px;
}

.hk-content__text strong { font-weight: 600; color: var(--ink); }

/* Empty */
.hk-empty {
    text-align: center;
    padding: 120px 20px;
    color: var(--ink-3);
    font-size: .95rem;
    font-weight: 300;
}

/* ── Responsive ── */
@media (max-width: 960px) {
    .hk-grid { grid-template-columns: 1fr; gap: 44px; }
    .hk-img-wrap { order: -1; }
}

@media (max-width: 640px) {
    .hk-hero { padding: 100px 0 65px; }
    .hk-main { padding: 60px 0 80px; }
}
</style>
@endsection
