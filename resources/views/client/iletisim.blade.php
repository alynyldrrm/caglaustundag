@php
    $contactSettings = getContact();
    $currentLanguage = session('defaultDatas')['currentLanguage'] ?? null;
    $captchaCode = \App\Http\Controllers\ClientController::generateCaptcha();
@endphp

@extends('client.layout')

@section('title', __('İletişim'))

@section('content')

<div class="cp">

    <!-- Hero -->
    <section class="cp-hero">
        <div class="cp-hero__noise"></div>
        <div class="container">
            <div class="cp-hero__inner">
                <span class="cp-hero__eyebrow">{{ __('İletişim') }}</span>
                <h1 class="cp-hero__title">{{ __('Nasıl yardımcı') }}<br><em>{{ __('olabiliriz?') }}</em></h1>
                <p class="cp-hero__sub">{{ __('Sorularınız için bize ulaşın') }}</p>
            </div>
        </div>
        <div class="cp-hero__line"></div>
    </section>

    <!-- Info Bar -->
    <div class="cp-bar">
        <div class="container">
            <div class="cp-bar__inner">
                @if($contactSettings && count($contactSettings) > 0)
                    @foreach($contactSettings as $item)
                        @if(!empty($item['address']))
                        <div class="cp-bar__item">
                            <span class="cp-bar__ico"><i class="fas fa-map-marker-alt"></i></span>
                            <div>
                                <p class="cp-bar__lbl">{{ __('Adres') }}</p>
                                <p class="cp-bar__val">{!! $item['address'] !!}</p>
                            </div>
                        </div>
                        @endif
                        @if(!empty($item['phone']))
                        <div class="cp-bar__item">
                            <span class="cp-bar__ico"><i class="fas fa-phone-alt"></i></span>
                            <div>
                                <p class="cp-bar__lbl">{{ __('Telefon') }}</p>
                                <p class="cp-bar__val"><a href="tel:{{ str_replace(' ', '', $item['phone']) }}">{!! $item['phone'] !!}</a></p>
                            </div>
                        </div>
                        @endif
                        @if(!empty($item['email']))
                        <div class="cp-bar__item">
                            <span class="cp-bar__ico"><i class="fas fa-envelope"></i></span>
                            <div>
                                <p class="cp-bar__lbl">{{ __('E-Posta') }}</p>
                                <p class="cp-bar__val"><a href="mailto:{{ $item['email'] }}">{!! $item['email'] !!}</a></p>
                            </div>
                        </div>
                        @endif
                    @endforeach
                @else
                    <div class="cp-bar__item">
                        <span class="cp-bar__ico"><i class="fas fa-map-marker-alt"></i></span>
                        <div>
                            <p class="cp-bar__lbl">{{ __('Adres') }}</p>
                            <p class="cp-bar__val">Anittepe Mahallesi Turgutreis Caddesi 21/A Çankaya ANKARA</p>
                        </div>
                    </div>
                    <div class="cp-bar__item">
                        <span class="cp-bar__ico"><i class="fas fa-phone-alt"></i></span>
                        <div>
                            <p class="cp-bar__lbl">{{ __('Telefon') }}</p>
                            <p class="cp-bar__val"><a href="tel:03122319628">0312 231 96 28</a></p>
                        </div>
                    </div>
                    <div class="cp-bar__item">
                        <span class="cp-bar__ico"><i class="fas fa-envelope"></i></span>
                        <div>
                            <p class="cp-bar__lbl">{{ __('E-Posta') }}</p>
                            <p class="cp-bar__val"><a href="mailto:info@reformdanismanlik.com.tr">info@reformdanismanlik.com.tr</a></p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Main -->
    <section class="cp-main">
        <div class="container">
            <div class="cp-main__grid">

                <!-- Form -->
                <div class="cp-form">
                    <div class="cp-form__head">
                        <h2>{{ __('Mesaj Gönderin') }}</h2>
                        <p>{{ __('Formu doldurun, en kısa sürede size dönüş yapalım') }}</p>
                    </div>

                    @if(session('success') || session('userSuccess'))
                        <div class="cp-alert cp-alert--ok">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('success') ?? session('userSuccess') }}</span>
                        </div>
                    @endif
                    @if(session('userError'))
                        <div class="cp-alert cp-alert--err">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ session('userError') }}</span>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="cp-alert cp-alert--err">
                            <i class="fas fa-exclamation-circle"></i>
                            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.send', ['language_key' => App::getLocale()]) }}" method="POST">
                        @csrf
                        <div class="cp-row">
                            <div class="cp-field">
                                <label for="name">{{ __('Ad Soyad') }} <sup>*</sup></label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="{{ __('Adınız ve soyadınız') }}" required>
                            </div>
                            <div class="cp-field">
                                <label for="email">{{ __('E-Posta') }} <sup>*</sup></label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('E-posta adresiniz') }}" required>
                            </div>
                        </div>
                        <div class="cp-field">
                            <label for="subject">{{ __('Konu') }} <sup>*</sup></label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" placeholder="{{ __('Mesajınızın konusu') }}" required>
                        </div>
                        <div class="cp-field">
                            <label for="message">{{ __('Mesaj') }} <sup>*</sup></label>
                            <textarea id="message" name="message" rows="5" placeholder="{{ __('Mesajınızı buraya yazın...') }}" required>{{ old('message') }}</textarea>
                        </div>
                        <div class="cp-field">
                            <label for="captcha">{{ __('Güvenlik Kodu') }} <sup>*</sup></label>
                            <div class="cp-captcha">
                                <div class="cp-captcha__row">
                                    <span class="cp-captcha__code">{{ $captchaCode }}</span>
                                    <button type="button" class="cp-captcha__btn" onclick="location.reload()" title="{{ __('Yenile') }}">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                <input type="text" id="captcha" name="captcha" placeholder="{{ __('Güvenlik kodunu girin') }}" required>
                            </div>
                        </div>
                        <button type="submit" class="cp-submit">
                            <span>{{ __('Gönder') }}</span>
                            <span class="cp-submit__arr"><i class="fas fa-arrow-right"></i></span>
                        </button>
                    </form>
                </div>

                <!-- Map -->
                <div class="cp-map">
                    <p class="cp-map__lbl">{{ __('Konumumuz') }}</p>
                    <div class="cp-map__frame">
                        @if($contactSettings && count($contactSettings) > 0 && !empty($contactSettings[0]['map_code']))
                            {!! $contactSettings[0]['map_code'] !!}
                        @else
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3059.4!2d32.835758!3d39.9323919!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMznCsDU1JzU2LjYiTiAzMsKwNTAnMDguNyJF!5e0!3m2!1str!2str!4v1609459200000!5m2!1str!2str" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        @endif
                    </div>
                </div>

            </div>
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
    --accent:   #2a3d52;        /* koyu lacivert — tek vurgu */
    --accent-l: rgba(42,61,82,0.07);
}

.cp {
    font-family: 'Outfit', sans-serif;
    background: var(--bg);
    color: var(--ink);
    -webkit-font-smoothing: antialiased;
}

.container {
    width: min(1120px, 92vw);
    margin-inline: auto;
}

/* ───────────── HERO ───────────── */
.cp-hero {
    position: relative;
    background: var(--white);
    padding: 130px 0 80px;
    border-bottom: 1px solid var(--border);
    overflow: hidden;
}

/* hafif doku — noise-like yatay çizgiler */
.cp-hero__noise {
    position: absolute;
    inset: 0;
    background-image:
        repeating-linear-gradient(
            0deg,
            transparent,
            transparent 39px,
            rgba(0,0,0,0.025) 39px,
            rgba(0,0,0,0.025) 40px
        );
    pointer-events: none;
}

/* sağ alt köşe dekor */
.cp-hero::after {
    content: '';
    position: absolute;
    right: -80px;
    bottom: -80px;
    width: 340px;
    height: 340px;
    border-radius: 50%;
    border: 1px solid var(--border);
    pointer-events: none;
}

.cp-hero::before {
    content: '';
    position: absolute;
    right: -20px;
    bottom: -20px;
    width: 220px;
    height: 220px;
    border-radius: 50%;
    border: 1px solid var(--border);
    pointer-events: none;
}

.cp-hero__inner {
    position: relative;
    z-index: 1;
    animation: cpFade 0.8s ease both;
}

@keyframes cpFade {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

.cp-hero__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 0.68rem;
    font-weight: 500;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--accent);
    margin-bottom: 22px;
}

.cp-hero__eyebrow::before {
    content: '';
    display: block;
    width: 28px;
    height: 1px;
    background: var(--accent);
    opacity: 0.5;
}

.cp-hero__title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.8rem, 5.5vw, 4.8rem);
    font-weight: 300;
    line-height: 1.08;
    color: var(--ink);
    letter-spacing: -0.015em;
}

.cp-hero__title em {
    font-style: italic;
    color: var(--accent);
}

.cp-hero__sub {
    margin-top: 18px;
    font-size: 0.95rem;
    color: var(--ink-2);
    font-weight: 300;
}

.cp-hero__line {
    position: absolute;
    left: 0; bottom: 0;
    width: 100%; height: 3px;
    background: linear-gradient(90deg, var(--accent) 0%, transparent 60%);
    opacity: 0.25;
}

/* ───────────── INFO BAR ───────────── */
.cp-bar {
    background: var(--white);
    border-bottom: 1px solid var(--border);
}

.cp-bar__inner {
    display: flex;
}

.cp-bar__item {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 26px 34px;
    border-right: 1px solid var(--border);
    transition: background 0.2s;
    animation: cpFade 0.6s ease both;
}

.cp-bar__item:nth-child(1) { animation-delay: 0.08s; }
.cp-bar__item:nth-child(2) { animation-delay: 0.16s; }
.cp-bar__item:nth-child(3) { animation-delay: 0.24s; }
.cp-bar__item:last-child   { border-right: none; }
.cp-bar__item:hover        { background: var(--accent-l); }

.cp-bar__ico {
    width: 36px;
    height: 36px;
    border: 1px solid var(--border-2);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--accent);
    font-size: 0.8rem;
    flex-shrink: 0;
    transition: all 0.22s;
}

.cp-bar__item:hover .cp-bar__ico {
    background: var(--accent);
    border-color: var(--accent);
    color: #fff;
}

.cp-bar__lbl {
    font-size: 0.63rem;
    font-weight: 600;
    letter-spacing: 0.13em;
    text-transform: uppercase;
    color: var(--ink-3);
    margin-bottom: 3px;
}

.cp-bar__val {
    font-size: 0.875rem;
    color: var(--ink);
    font-weight: 300;
    line-height: 1.5;
}

.cp-bar__val a {
    color: inherit;
    text-decoration: none;
    transition: color 0.2s;
}

.cp-bar__val a:hover { color: var(--accent); }

/* ───────────── MAIN ───────────── */
.cp-main {
    padding: 70px 0 100px;
}

.cp-main__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 48px;
    align-items: start;
}

/* ───────────── FORM ───────────── */
.cp-form {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 42px;
    animation: cpFade 0.7s 0.15s ease both;
}

.cp-form__head {
    margin-bottom: 30px;
    padding-bottom: 24px;
    border-bottom: 1px solid var(--border);
}

.cp-form__head h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.85rem;
    font-weight: 400;
    color: var(--ink);
    margin-bottom: 6px;
    letter-spacing: -0.01em;
}

.cp-form__head p {
    font-size: 0.875rem;
    color: var(--ink-2);
    font-weight: 300;
}

/* Alerts */
.cp-alert {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 13px 16px;
    border-radius: 8px;
    font-size: 0.855rem;
    margin-bottom: 22px;
    line-height: 1.5;
}

.cp-alert--ok  { background: #f0faf5; border: 1px solid #b5dfc9; color: #1d6342; }
.cp-alert--err { background: #fff5f5; border: 1px solid #f5c6c6; color: #9b1c1c; }
.cp-alert ul   { padding-left: 16px; margin: 0; }

/* Fields */
.cp-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.cp-field {
    margin-bottom: 16px;
}

.cp-field label {
    display: block;
    font-size: 0.68rem;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--ink-2);
    margin-bottom: 7px;
}

.cp-field label sup {
    color: var(--accent);
    font-size: 0.85em;
}

.cp-field input,
.cp-field textarea {
    width: 100%;
    padding: 11px 14px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 8px;
    font-family: 'Outfit', sans-serif;
    font-size: 0.9rem;
    color: var(--ink);
    outline: none;
    transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
    -webkit-appearance: none;
}

.cp-field textarea {
    resize: vertical;
    min-height: 128px;
    line-height: 1.6;
}

.cp-field input:focus,
.cp-field textarea:focus {
    border-color: var(--accent);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(42,61,82,0.08);
}

.cp-field input::placeholder,
.cp-field textarea::placeholder {
    color: var(--ink-3);
    font-weight: 300;
}

/* Captcha */
.cp-captcha { display: flex; flex-direction: column; gap: 10px; }

.cp-captcha__row {
    display: flex;
    align-items: center;
    gap: 10px;
}

.cp-captcha__code {
    flex: 1;
    padding: 11px 18px;
    background: var(--accent);
    color: #fff;
    border-radius: 8px;
    font-family: 'Courier New', monospace;
    font-size: 1.15rem;
    font-weight: 700;
    letter-spacing: 7px;
    text-align: center;
    user-select: none;
}

.cp-captcha__btn {
    width: 42px;
    height: 42px;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ink-3);
    font-size: 0.82rem;
    transition: all 0.25s;
}

.cp-captcha__btn:hover {
    border-color: var(--accent);
    color: var(--accent);
    rotate: 180deg;
}

/* Submit */
.cp-submit {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 14px 20px;
    background: var(--accent);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-family: 'Outfit', sans-serif;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.22s;
    margin-top: 4px;
    letter-spacing: 0.03em;
}

.cp-submit:hover {
    background: #1e2e3f;
    box-shadow: 0 8px 28px rgba(42,61,82,0.22);
    transform: translateY(-2px);
}

.cp-submit__arr {
    width: 28px;
    height: 28px;
    background: rgba(255,255,255,0.15);
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    transition: transform 0.2s;
}

.cp-submit:hover .cp-submit__arr { transform: translateX(4px); }

/* ───────────── MAP ───────────── */
.cp-map {
    position: sticky;
    top: 90px;
    animation: cpFade 0.7s 0.3s ease both;
}

.cp-map__lbl {
    font-size: 0.65rem;
    font-weight: 600;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--ink-3);
    margin-bottom: 12px;
}

.cp-map__frame {
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid var(--border);
    aspect-ratio: 4/3;
    box-shadow: 0 20px 50px rgba(0,0,0,0.08);
}

.cp-map__frame iframe {
    width: 100%;
    height: 100%;
    border: 0;
    display: block;
}

/* ───────────── RESPONSIVE ───────────── */
@media (max-width: 960px) {
    .cp-bar__inner  { flex-direction: column; }
    .cp-bar__item   { border-right: none; border-bottom: 1px solid var(--border); }
    .cp-bar__item:last-child { border-bottom: none; }
    .cp-main__grid  { grid-template-columns: 1fr; gap: 36px; }
    .cp-map         { position: static; }
}

@media (max-width: 640px) {
    .cp-hero        { padding: 100px 0 60px; }
    .cp-form        { padding: 28px 22px; }
    .cp-row         { grid-template-columns: 1fr; }
    .cp-bar__item   { padding: 20px 22px; }
}
</style>
@endsection
