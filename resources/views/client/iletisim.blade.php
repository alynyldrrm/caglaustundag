@php
    $contactSettings = getContact();
    $currentLanguage = session('defaultDatas')['currentLanguage'] ?? null;
    
    // Captcha kodu üret
    $captchaCode = \App\Http\Controllers\ClientController::generateCaptcha();
@endphp

@extends('client.layout')

@section('title', __('İletişim'))

@section('content')
<section class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="/{{ App::getLocale() }}">{{ __('Ana Sayfa') }}</a>
            <span>/</span>
            <span>{{ __('İletişim') }}</span>
        </div>
        <h1 class="page-title">{{ __('İletişim') }}</h1>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <!-- Sol: İletişim Bilgileri -->
            <div class="contact-info">
                <h2 class="section-title">{{ __('Bize Ulaşın') }}</h2>

                @if($contactSettings && count($contactSettings) > 0)
                    @foreach($contactSettings as $item)
                    <div class="contact-card">
                        <h3 class="contact-branch">{{ $item['name'] ?? 'MERKEZ' }}</h3>

                        <div class="contact-items">
                            @if(!empty($item['address']))
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-detail">
                                    <span class="label">{{ __('Adres') }}</span>
                                    <p>{{ $item['address'] }}</p>
                                </div>
                            </div>
                            @endif

                            @if(!empty($item['phone']))
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="contact-detail">
                                    <span class="label">{{ __('Telefon') }}</span>
                                    <a href="tel:{{ str_replace(' ', '', $item['phone']) }}">{{ $item['phone'] }}</a>
                                </div>
                            </div>
                            @endif

                            @if(!empty($item['email']))
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-detail">
                                    <span class="label">{{ __('E-Posta') }}</span>
                                    <a href="mailto:{{ $item['email'] }}">{{ $item['email'] }}</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Varsayılan İletişim Bilgileri -->
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

            <!-- Orta: Harita -->
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

            <!-- Sağ: İletişim Formu -->
            <div class="contact-form-wrapper">
                <h2 class="section-title">{{ __('Mesaj Gönderin') }}</h2>
                
                @if(session('success') || session('userSuccess'))
                    <div class="alert alert-success">{{ session('success') ?? session('userSuccess') }}</div>
                @endif
                
                @if(session('userError'))
                    <div class="alert alert-danger">{{ session('userError') }}</div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.send', ['language_key' => App::getLocale()]) }}" method="POST" class="contact-form">
                    @csrf
                    
                    <div class="form-group">
                        <label for="name">{{ __('Ad Soyad') }} *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">{{ __('E-Posta') }} *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">{{ __('Konu') }} *</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">{{ __('Mesaj') }} *</label>
                        <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                    </div>
                    
                    <!-- Captcha -->
                    <div class="form-group captcha-group">
                        <label for="captcha">{{ __('Güvenlik Kodu') }} *</label>
                        <div class="captcha-box">
                            <span class="captcha-code">{{ $captchaCode }}</span>
                            <button type="button" class="captcha-refresh" onclick="location.reload()">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                        <input type="text" id="captcha" name="captcha" placeholder="{{ __('Yukarıdaki kodu girin') }}" required>
                    </div>
                    
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i>
                        {{ __('Gönder') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('css')
<style>
.page-header {
    background: #1a1a1a;
    padding: 80px 0 40px 0;
    color: #fff;
    margin-bottom: 0;  /* Ekledim */
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    font-size: 0.9rem;
    color: rgba(255,255,255,0.7);
}

.breadcrumb a {
    color: #fff;
    text-decoration: none;
}

.page-title {
    font-size: 2.8rem;
    font-weight: 700;
    color: #fff;
    margin: 0;  /* Tüm margin'leri sıfırladım */
}

.contact-section {
    padding: 0 0 80px 0;  /* Üst padding'i tamamen sıfırladım */
    background: #f8f9fa;
    margin-top: 0;  /* Ekledim */
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 30px;
}

@media (max-width: 1200px) {
    .contact-grid {
        grid-template-columns: 1fr 1fr;
    }
}

.section-title {
    font-size: 1.8rem;
    font-weight: 600;
    color: #1a1a1a;
    margin: 0 0 30px 0;  /* Sadece alt margin bıraktım */
    padding-top: 0;  /* Ekledim */
}

.contact-info {
    margin-top: 0;  /* Ekledim */
    padding-top: 0;  /* Ekledim */
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

.contact-map {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    height: 100%;
    min-height: 450px;
}

.map-container {
    width: 100%;
    height: 100%;
    min-height: 450px;
}

.map-container iframe {
    display: block;
    width: 100%;
    height: 100%;
    min-height: 450px;
    border: 0;
}

/* İletişim Formu Stilleri */
.contact-form-wrapper {
    background: #fff;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.contact-form .form-group {
    margin-bottom: 20px;
}

.contact-form label {
    display: block;
    font-size: 0.9rem;
    font-weight: 500;
    color: #333;
    margin-bottom: 8px;
}

.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 1rem;
    transition: border-color 0.3s;
}

.contact-form input:focus,
.contact-form textarea:focus {
    outline: none;
    border-color: #1a1a1a;
}

.captcha-group {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 6px;
}

.captcha-box {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.captcha-code {
    background: #1a1a1a;
    color: #fff;
    padding: 10px 20px;
    border-radius: 4px;
    font-family: monospace;
    font-size: 1.2rem;
    letter-spacing: 3px;
    flex: 1;
    text-align: center;
}

.captcha-refresh {
    background: #fff;
    border: 1px solid #ddd;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s;
}

.captcha-refresh:hover {
    background: #f0f0f0;
}

.btn-submit {
    width: 100%;
    padding: 15px;
    background: #1a1a1a;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-submit:hover {
    background: #333;
}

.alert {
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 20px;
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

.alert-danger ul {
    margin: 0;
    padding-left: 20px;
}

@media (max-width: 1200px) {
    .contact-grid {
        grid-template-columns: 1fr 1fr;
    }
    .contact-map {
        grid-column: span 2;
        min-height: 300px;
    }
}

@media (max-width: 768px) {
    .contact-grid {
        grid-template-columns: 1fr;
    }
    .contact-map {
        grid-column: span 1;
        min-height: 300px;
    }
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }

    .contact-section {
        padding: 0 0 50px 0;
    }
}
</style>
@endsection
