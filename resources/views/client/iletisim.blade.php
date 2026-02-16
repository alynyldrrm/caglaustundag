@php
    $contactSettings = getContact();
    $currentLanguage = session('defaultDatas')['currentLanguage'] ?? null;

    // Captcha kodu üret
    $captchaCode = \App\Http\Controllers\ClientController::generateCaptcha();
@endphp

@extends('client.layout')

@section('title', __('İletişim'))

@section('content')
<!-- Hero Section -->
<section class="contact-hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">{{ __('İletişim') }}</h1>
            <p class="hero-desc">{{ __('Sorularınız için bize ulaşın') }}</p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-main">
    <div class="container">
        <!-- Contact Info Cards -->
        <div class="info-cards">
            @if($contactSettings && count($contactSettings) > 0)
                @foreach($contactSettings as $item)
                    @if(!empty($item['address']))
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <h4>{{ __('Adres') }}</h4>
                            <p>{!! $item['address'] !!}</p>
                        </div>
                    </div>
                    @endif

                    @if(!empty($item['phone']))
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="info-content">
                            <h4>{{ __('Telefon') }}</h4>
                            <a href="tel:{{ str_replace(' ', '', $item['phone']) }}">{!! $item['phone'] !!}</a>
                        </div>
                    </div>
                    @endif

                    @if(!empty($item['email']))
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <h4>{{ __('E-Posta') }}</h4>
                            <a href="mailto:{{ $item['email'] }}">{!! $item['email'] !!}</a>
                        </div>
                    </div>
                    @endif
                @endforeach
            @else
                <!-- Varsayılan İletişim Bilgileri -->
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="info-content">
                        <h4>{{ __('Adres') }}</h4>
                        <p>Anittepe Mahallesi Turgutreis Caddesi 21/A Çankaya ANKARA</p>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="info-content">
                        <h4>{{ __('Telefon') }}</h4>
                        <a href="tel:03122319628">0312 231 96 28</a>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-content">
                        <h4>{{ __('E-Posta') }}</h4>
                        <a href="mailto:info@reformdanismanlik.com.tr">info@reformdanismanlik.com.tr</a>
                    </div>
                </div>
            @endif
        </div>

        <div class="contact-content">
            <!-- Contact Form -->
            <div class="form-section">
                <div class="form-header">
                    <h2>{{ __('Mesaj Gönderin') }}</h2>
                    <p>{{ __('Formu doldurun, en kısa sürede size dönüş yapalım') }}</p>
                </div>

                @if(session('success') || session('userSuccess'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') ?? session('userSuccess') }}</span>
                    </div>
                @endif

                @if(session('userError'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('userError') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.send', ['language_key' => App::getLocale()]) }}" method="POST" class="contact-form">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">{{ __('Ad Soyad') }} *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="{{ __('Adınız ve soyadınız') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('E-Posta') }} *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('E-posta adresiniz') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject">{{ __('Konu') }} *</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" placeholder="{{ __('Mesajınızın konusu') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="message">{{ __('Mesaj') }} *</label>
                        <textarea id="message" name="message" rows="5" placeholder="{{ __('Mesajınızı buraya yazın...') }}" required>{{ old('message') }}</textarea>
                    </div>

                    <!-- Captcha -->
                    <div class="form-group">
                        <label for="captcha">{{ __('Güvenlik Kodu') }} *</label>
                        <div class="captcha-wrapper">
                            <div class="captcha-display">
                                <span class="captcha-code">{{ $captchaCode }}</span>
                                <button type="button" class="captcha-refresh" onclick="location.reload()" title="{{ __('Yenile') }}">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                            <input type="text" id="captcha" name="captcha" placeholder="{{ __('Güvenlik kodunu girin') }}" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <span>{{ __('Gönder') }}</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>

            <!-- Map -->
            <div class="map-section">
                <div class="map-wrapper">
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
@endsection

@section('css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --color-primary: #2d3748;
    --color-text: #2d3748;
    --color-text-light: #718096;
    --color-border: #e2e8f0;
}

* {
    font-family: 'Poppins', sans-serif;
}

/* Hero Section */
.contact-hero {
    background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
    padding: 100px 0 60px;
    text-align: center;
    position: relative;
}

.hero-content {
    position: relative;
    z-index: 1;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 600;
    color: #fff;
    margin-bottom: 12px;
}

.hero-desc {
    font-size: 1.05rem;
    color: rgba(255,255,255,0.8);
}

/* Contact Main */
.contact-main {
    padding: 80px 0;
    background: #f7fafc;
}

/* Info Cards */
.info-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    margin-bottom: 50px;
}

.info-card {
    background: #fff;
    border-radius: 12px;
    padding: 30px 25px;
    text-align: center;
    border: 1px solid var(--color-border);
    transition: all 0.3s;
}

.info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.info-icon {
    width: 50px;
    height: 50px;
    background: var(--color-primary);
    color: #fff;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin: 0 auto 18px;
}

.info-content h4 {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--color-text-light);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.info-content p,
.info-content a {
    font-size: 0.95rem;
    color: var(--color-text);
    line-height: 1.6;
    text-decoration: none;
    margin: 0;
}

.info-content a:hover {
    color: var(--color-primary);
}

/* Contact Content */
.contact-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

/* Form Section */
.form-section {
    background: #fff;
    border-radius: 16px;
    padding: 40px;
    border: 1px solid var(--color-border);
}

.form-header {
    margin-bottom: 35px;
}

.form-header h2 {
    font-size: 1.6rem;
    font-weight: 600;
    color: var(--color-text);
    margin-bottom: 8px;
}

.form-header p {
    font-size: 0.95rem;
    color: var(--color-text-light);
}

/* Form Styles */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--color-text);
    margin-bottom: 8px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid var(--color-border);
    border-radius: 8px;
    font-size: 0.95rem;
    color: var(--color-text);
    transition: all 0.3s;
    background: #fff;
}

.form-group textarea {
    resize: vertical;
    min-height: 120px;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--color-primary);
}

.form-group input::placeholder,
.form-group textarea::placeholder {
    color: #a0aec0;
}

/* Captcha */
.captcha-wrapper {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.captcha-display {
    display: flex;
    align-items: center;
    gap: 12px;
}

.captcha-code {
    flex: 1;
    background: var(--color-primary);
    color: #fff;
    padding: 12px 20px;
    border-radius: 8px;
    font-family: 'Courier New', monospace;
    font-size: 1.3rem;
    font-weight: 700;
    letter-spacing: 4px;
    text-align: center;
    user-select: none;
}

.captcha-refresh {
    width: 45px;
    height: 45px;
    background: #fff;
    border: 1px solid var(--color-border);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-text-light);
}

.captcha-refresh:hover {
    border-color: var(--color-primary);
    color: var(--color-primary);
    transform: rotate(180deg);
}

/* Submit Button */
.btn-submit {
    width: 100%;
    padding: 14px 30px;
    background: var(--color-primary);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-submit:hover {
    background: #1a202c;
    transform: translateY(-2px);
}

.btn-submit i {
    transition: transform 0.3s;
}

.btn-submit:hover i {
    transform: translateX(5px);
}

/* Map Section */
.map-section {
    position: sticky;
    top: 100px;
}

.map-wrapper {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid var(--color-border);
    height: 100%;
    min-height: 500px;
}

.map-wrapper iframe {
    width: 100%;
    height: 100%;
    min-height: 500px;
    border: 0;
}

/* Alerts */
.alert {
    padding: 14px 18px;
    border-radius: 8px;
    margin-bottom: 25px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: 0.9rem;
}

.alert i {
    font-size: 1.1rem;
    margin-top: 2px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert ul {
    margin: 0;
    padding-left: 18px;
}

/* Responsive */
@media (max-width: 1024px) {
    .contact-content {
        grid-template-columns: 1fr;
    }

    .map-section {
        position: static;
    }

    .map-wrapper {
        min-height: 400px;
    }

    .map-wrapper iframe {
        min-height: 400px;
    }
}

@media (max-width: 768px) {
    .contact-hero {
        padding: 80px 0 50px;
    }

    .hero-title {
        font-size: 2rem;
    }

    .info-cards {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .form-section {
        padding: 30px 25px;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .captcha-code {
        font-size: 1.1rem;
        letter-spacing: 3px;
    }
}

@media (max-width: 480px) {
    .captcha-display {
        flex-direction: column;
    }

    .captcha-refresh {
        width: 100%;
    }
}
</style>
@endsection
