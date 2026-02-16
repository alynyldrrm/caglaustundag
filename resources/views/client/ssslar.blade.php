@php
    $currentLanguage = session('defaultDatas')['currentLanguage'] ?? null;
    
    // Eğer list boşsa, direkt veritabanından çek
    if(!isset($list) || !is_array($list) || count($list) == 0) {
        $list = getTypeValues('ssslar', 100);
    }
@endphp

@extends('client.layout')

@section('title', $menu->name ?? __('Sıkça Sorulan Sorular'))

@section('content')
<section class="page-header">
    <div class="container">
        <h1 class="page-title">{{ $menu->name ?? __('Sıkça Sorulan Sorular') }}</h1>
        <p class="page-subtitle">{{ __('Merak ettiğiniz soruların cevapları') }}</p>
    </div>
</section>

<section class="faq-section">
    <div class="container">
        @if($list && count($list) > 0)
            <div class="faq-list">
                @foreach($list as $index => $sss)
                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFaq(this)">
                            <span class="faq-number">{{ sprintf('%02d', $index + 1) }}</span>
                            <span class="faq-text">{{ getValue('soru', $sss) ?: $sss['name'] }}</span>
                            <i class="fas fa-chevron-down faq-icon"></i>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-content">
                                {!! getValue('cevap', $sss) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-question-circle"></i>
                <p>{{ __('Henüz soru eklenmemiş.') }}</p>
            </div>
        @endif
    </div>
</section>

<script>
function toggleFaq(button) {
    const item = button.parentElement;
    const answer = button.nextElementSibling;
    const icon = button.querySelector('.faq-icon');
    
    // Diğerlerini kapat (isteğe bağlı - istersen kaldır)
    document.querySelectorAll('.faq-item.active').forEach(function(activeItem) {
        if(activeItem !== item) {
            activeItem.classList.remove('active');
            activeItem.querySelector('.faq-answer').style.maxHeight = null;
            activeItem.querySelector('.faq-icon').style.transform = 'rotate(0deg)';
        }
    });
    
    // Toggle current
    if(item.classList.contains('active')) {
        item.classList.remove('active');
        answer.style.maxHeight = null;
        icon.style.transform = 'rotate(0deg)';
    } else {
        item.classList.add('active');
        answer.style.maxHeight = answer.scrollHeight + 'px';
        icon.style.transform = 'rotate(180deg)';
    }
}
</script>
@endsection

@section('css')
<style>
.page-header {
    background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
    padding: 80px 0;
    text-align: center;
    color: #fff;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.page-subtitle {
    font-size: 1.1rem;
    color: rgba(255,255,255,0.7);
}

.faq-section {
    padding: 80px 0;
    background: #f8f9fa;
}

.faq-list {
    max-width: 900px;
    margin: 0 auto;
}

.faq-item {
    background: #fff;
    border-radius: 12px;
    margin-bottom: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
    border: 1px solid #e5e5e5;
}

.faq-question {
    width: 100%;
    padding: 25px 30px;
    background: #fff;
    border: none;
    text-align: left;
    display: flex;
    align-items: center;
    gap: 20px;
    cursor: pointer;
    transition: all 0.3s;
}

.faq-question:hover {
    background: #fafafa;
}

.faq-number {
    width: 40px;
    height: 40px;
    background: #1a1a1a;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.faq-text {
    flex: 1;
    font-size: 1.1rem;
    font-weight: 600;
    color: #1a1a1a;
}

.faq-icon {
    font-size: 1.2rem;
    color: #666;
    transition: transform 0.3s;
}

.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.faq-answer-content {
    padding: 0 30px 30px 90px;
    font-size: 1rem;
    line-height: 1.8;
    color: #555;
}

.faq-answer-content p {
    margin-bottom: 15px;
}

.faq-item.active {
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.faq-item.active .faq-question {
    background: #fafafa;
}

.empty-state {
    text-align: center;
    padding: 80px 20px;
    color: #888;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .faq-question {
        padding: 20px;
        gap: 15px;
    }
    
    .faq-number {
        width: 35px;
        height: 35px;
        font-size: 0.85rem;
    }
    
    .faq-text {
        font-size: 1rem;
    }
    
    .faq-answer-content {
        padding: 0 20px 20px 70px;
        font-size: 0.95rem;
    }
}
</style>
@endsection
