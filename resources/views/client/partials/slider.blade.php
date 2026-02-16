@php
    $sliders = getTypeValues('sliderlar', 5);
@endphp

@if (count($sliders) > 0)
    <div id="heroSlider" class="hero-slider">
        @foreach ($sliders as $index => $slider)
            @php
                $resim = isset($slider['fields']['resim'][0])
                    ? getImageLink($slider['fields']['resim'][0]['path'], ['w' => 1920, 'h' => 700, 'q' => 90, 'fit' => 'cover'])
                    : '/assets/client/img/default.jpg';

                $baslik = getValue('metin_baslik', $slider);
                $icerik = getValue('metin_icerik', $slider);
                $buton_varmi = getValue('buton_varmi', $slider) == 'Evet';
                $buton_metin = getValue('buton_metin', $slider);
                $buton_link = getValue('buton_link', $slider);

                // Metin pozisyonu ayarı
                $metin_pozisyon = getValue('metin_pozisyon', $slider);
                $pozisyon_class = '';
                switch($metin_pozisyon) {
                    case 'Solda hizalı':
                        $pozisyon_class = 'align-left';
                        break;
                    case 'Ortalı':
                        $pozisyon_class = 'align-center';
                        break;
                    case 'Sağda hizalı':
                        $pozisyon_class = 'align-right';
                        break;
                    default:
                        $pozisyon_class = 'align-left';
                }
            @endphp

            <div class="slide {{ $index == 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                <!-- ARKA PLAN RESMİ - ORİJİNAL RENK, EFEKTSİZ -->
                <div class="slide-image" style="background-image: url('{{ $resim }}');"></div>

                <!-- BEYAZ OVERLAY - Yazıları daha okunur yapmak için -->
                <div class="slide-overlay"></div>

                <!-- İÇERİK -->
                <div class="slide-content {{ $pozisyon_class }}">
                    @if ($baslik)
                        <h2 class="slide-title">{{ $baslik }}</h2>
                    @endif

                    @if ($icerik)
                        <p class="slide-text">{{ $icerik }}</p>
                    @endif

                    @if ($buton_varmi && $buton_metin)
                        <a href="{{ $buton_link }}" class="slide-btn">
                            {{ $buton_metin }}
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @endif
                </div>
            </div>
        @endforeach

        {{-- SADECE 1'DEN FAZLA SLIDER VARSA NAVİGASYON --}}
        @if(count($sliders) > 1)
        <div class="slider-nav">
            <button class="slider-arrow prev" onclick="heroSlider.prev()">
                <i class="fas fa-chevron-left"></i>
            </button>
            <div class="slider-dots">
                @foreach($sliders as $index => $slider)
                    <span class="dot {{ $index == 0 ? 'active' : '' }}" onclick="heroSlider.goTo({{ $index }})"></span>
                @endforeach
            </div>
            <button class="slider-arrow next" onclick="heroSlider.next()">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        @endif
    </div>
@endif

<style>
/* ===== HERO SLIDER ===== */
.hero-slider {
    position: relative;
    width: 100%;
    height: 600px;
    overflow: hidden;
    background: #f5f5f5;
}

.slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.6s ease;
}

.slide.active {
    opacity: 1;
    visibility: visible;
}

/* ARKA PLAN RESMİ - TAMAMEN ORİJİNAL, HİÇBİR EFEKT YOK */
.slide-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    /* Hiçbir filtre yok */
    filter: none !important;
    -webkit-filter: none !important;
    transform: scale(1);
    transition: transform 6s ease;
}

.slide.active .slide-image {
    transform: scale(1.05);
}

/* BEYAZ OVERLAY - Yazıların okunabilirliği için */
.slide-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to right, rgba(255,255,255,0.7) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0.2) 100%);
}

/* İÇERİK - POZİSYON AYARLARI */
.slide-content {
    position: relative;
    z-index: 10;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 40px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

/* Pozisyon sınıfları */
.slide-content.align-left {
    align-items: flex-start;
    text-align: left;
}

.slide-content.align-center {
    align-items: center;
    text-align: center;
}

.slide-content.align-right {
    align-items: flex-end;
    text-align: right;
}

/* Yazı stilleri - SİYAH RENK */
.slide-title {
    font-size: 3rem;
    font-weight: 700;
    color: #1a1a1a; /* Siyah */
    margin-bottom: 20px;
    line-height: 1.2;
    text-shadow: 0 2px 8px rgba(255,255,255,0.5);
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease 0.2s;
}

.slide.active .slide-title {
    opacity: 1;
    transform: translateY(0);
}

.slide-text {
    font-size: 1.2rem;
    color: #2d2d2d; /* Koyu gri-siyah */
    line-height: 1.7;
    margin-bottom: 30px;
    max-width: 600px;
    text-shadow: 0 1px 4px rgba(255,255,255,0.5);
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease 0.4s;
}

.slide.active .slide-text {
    opacity: 1;
    transform: translateY(0);
}

/* Ortalı pozisyon için max-width düzenlemesi */
.slide-content.align-center .slide-text {
    max-width: 700px;
}

.slide-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 30px;
    background: #1a1a1a;
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    border-radius: 4px;
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.3s, opacity 0.6s ease 0.6s, transform 0.6s ease 0.6s;
}

.slide.active .slide-btn {
    opacity: 1;
    transform: translateY(0);
}

.slide-btn:hover {
    background: #333;
    text-decoration: none;
    color: #fff;
    transform: translateY(-2px);
}

/* NAVİGASYON */
.slider-nav {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    gap: 20px;
    z-index: 20;
}

.slider-arrow {
    width: 44px;
    height: 44px;
    border: 1px solid rgba(0,0,0,0.3);
    background: rgba(255,255,255,0.8);
    color: #1a1a1a;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(4px);
}

.slider-arrow:hover {
    background: #1a1a1a;
    color: #fff;
    border-color: #1a1a1a;
}

.slider-dots {
    display: flex;
    gap: 8px;
}

.dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(0,0,0,0.3);
    cursor: pointer;
    transition: all 0.3s;
}

.dot.active {
    background: #1a1a1a;
    width: 28px;
    border-radius: 5px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .hero-slider {
        height: 500px;
    }

    .slide-content {
        padding: 0 20px;
    }

    .slide-title {
        font-size: 2rem;
    }

    .slide-text {
        font-size: 1rem;
    }

    /* Mobilde hep ortalı */
    .slide-content {
        align-items: center !important;
        text-align: center !important;
    }
}
</style>

@if(count($sliders) > 1)
<script>
const heroSlider = {
    current: 0,
    slides: document.querySelectorAll('.slide'),
    dots: document.querySelectorAll('.dot'),
    total: {{ count($sliders) }},
    autoplay: null,

    init() {
        this.startAutoplay();
    },

    show(index) {
        this.slides.forEach(s => s.classList.remove('active'));
        this.dots.forEach(d => d.classList.remove('active'));

        this.slides[index].classList.add('active');
        if(this.dots[index]) this.dots[index].classList.add('active');
        this.current = index;
    },

    next() {
        let next = this.current + 1;
        if (next >= this.total) next = 0;
        this.show(next);
    },

    prev() {
        let prev = this.current - 1;
        if (prev < 0) prev = this.total - 1;
        this.show(prev);
    },

    goTo(index) {
        this.show(index);
        this.resetAutoplay();
    },

    startAutoplay() {
        this.autoplay = setInterval(() => this.next(), 5000);
    },

    resetAutoplay() {
        clearInterval(this.autoplay);
        this.startAutoplay();
    }
};

heroSlider.init();
</script>
@endif
