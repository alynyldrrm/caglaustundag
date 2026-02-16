@php
    $selected_menus = getSelectedMenus();
@endphp

<section class="page-header-light">
    <div class="container">
        <nav class="breadcrumb">
            <a href="/{{ App::getLocale() }}">{{ __('Ana Sayfa') }}</a>
            @if($selected_menus->first())
                <span>/</span>
                <a href="#">{{ $selected_menus->first()->name }}</a>
            @endif
            <span>/</span>
            <span class="current">{{ $main_title }}</span>
        </nav>
        <h1 class="page-title">{{ $main_title }}</h1>
    </div>
</section>

<style>
    .page-header-light {
        background: #f8f9fa;
        border-bottom: 1px solid #e5e5e5;
        padding: 60px 0;
    }
    
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
        font-size: 0.9rem;
    }
    
    .breadcrumb a {
        color: #888;
        text-decoration: none;
        transition: color 0.3s;
    }
    
    .breadcrumb a:hover {
        color: #1a1a1a;
    }
    
    .breadcrumb span {
        color: #ccc;
    }
    
    .breadcrumb .current {
        color: #666;
    }
    
    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
        letter-spacing: -0.02em;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.8rem;
        }
    }
</style>
