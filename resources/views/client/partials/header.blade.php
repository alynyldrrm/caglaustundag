@php
    $lang = getLanguageLinks();
    $defaultDatas = session('defaultDatas');
    $currentLanguage = $defaultDatas['currentLanguage'] ?? null;
@endphp

<header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 120, 'stickyHeaderContainerHeight': 70}">
    <div class="header-body border-top-0">
        <div class="header-container container">
            <div class="header-row">
                <div class="header-column">
                    <div class="header-row">
                        <div class="header-logo">
                            <a href="/{{ App::getLocale() }}">
                                <img alt="Çağla Üstündağ Logo" width="200" height="auto" data-sticky-width="180"
                                    data-sticky-height="auto" src="/files/logo/cagla-ustundag-logo-horizontal.png">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="header-column justify-content-end">
                    <div class="header-row">
                        <div class="header-nav header-nav-stripe order-2 order-lg-1">
                            <div class="header-nav-main header-nav-main-square header-nav-main-effect-1 header-nav-main-sub-effect-1">
                                <nav class="collapse">
                                    <ul class="nav nav-pills" id="mainNav">
                                        {!! createMenus(getMenus()) !!}

                                        <li class="nav-item dropdown nav-item-left-border d-none d-sm-block nav-item-left-border-remove nav-item-left-border-md-show">
                                            <a class="nav-link" href="#" role="button" id="dropdownLanguage" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa-solid fa-globe me-2"></i>{{ $currentLanguage ? $currentLanguage->key : App::getLocale() }}
                                                <i class="fas fa-angle-down ms-1"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownLanguage">
                                                @foreach ($lang as $key => $item)
                                                    @php
                                                        $language = App\Models\Language::where('key', $key)->first();
                                                    @endphp
                                                    @if($language)
                                                        <a class="dropdown-item" href="{{ $item }}">{{ $language->text }}</a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
    #header {
        background: rgba(255, 255, 255, 0.98) !important;
        backdrop-filter: blur(10px);
        border-bottom: 1px solid #e5e5e5 !important;
    }
    
    #header .header-logo a {
        display: inline-block;
    }
    
    #header .header-logo img {
        transition: transform 0.3s ease;
    }
    
    #header .header-logo a:hover img {
        transform: scale(1.02);
    }
    
    #mainNav {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    #mainNav .nav-item > a {
        color: #444 !important;
        font-size: 0.9rem;
        font-weight: 500;
        letter-spacing: 0.5px;
        padding: 10px 18px !important;
        transition: all 0.3s;
    }
    
    #mainNav .nav-item > a:hover {
        color: #000 !important;
    }
    
    #dropdownLanguage {
        color: #444 !important;
        font-size: 0.85rem;
        border-left: 1px solid #e5e5e5;
        margin-left: 15px;
        padding-left: 20px !important;
    }
    
    #dropdownLanguage:hover {
        color: #000 !important;
    }
    
    .header-btn-collapse-nav {
        background: transparent !important;
        border: 1px solid #ddd !important;
        color: #333 !important;
        padding: 10px 15px !important;
        border-radius: 4px !important;
    }
    
    .header-btn-collapse-nav:hover {
        border-color: #000 !important;
        color: #000 !important;
    }
</style>
