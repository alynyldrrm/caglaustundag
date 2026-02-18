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
                                <img alt="Çağla Üstündağ Logo" width="200" height="auto"
                                     data-sticky-width="180" data-sticky-height="auto"
                                     src="/files/logo/cagla-ustundag-logo-horizontal.png">
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
                                            <a class="nav-link hd-lang" href="#" role="button"
                                               id="dropdownLanguage"
                                               data-bs-toggle="dropdown"
                                               aria-haspopup="true"
                                               aria-expanded="false">
                                                <i class="fa-solid fa-globe"></i>
                                                {{ $currentLanguage ? $currentLanguage->key : App::getLocale() }}
                                                <i class="fas fa-angle-down hd-lang__chevron"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownLanguage">
                                                @foreach ($lang as $key => $item)
                                                    @php $language = App\Models\Language::where('key', $key)->first(); @endphp
                                                    @if($language)
                                                        <a class="dropdown-item" href="{{ $item }}">{{ $language->text }}</a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <button class="btn header-btn-collapse-nav"
                                    data-bs-toggle="collapse"
                                    data-bs-target=".header-nav-main nav">
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
    font-family: 'Nunito', sans-serif !important;
    background: rgba(255,255,255,0.98) !important;
    backdrop-filter: blur(14px) !important;
    -webkit-backdrop-filter: blur(14px) !important;
    border-bottom: 1px solid #e2e0d8 !important;
    box-shadow: 0 1px 0 rgba(0,0,0,.03) !important;
}

#header .header-logo img { transition: opacity .2s; }
#header .header-logo a:hover img { opacity: .78; }

/* Nav links */
#mainNav .nav-item > a {
    font-family: 'Nunito', sans-serif !important;
    color: #4a4a45 !important;
    font-size: .95rem !important;
    font-weight: 600 !important;
    letter-spacing: .01em !important;
    padding: 10px 15px !important;
    transition: color .18s !important;
    position: relative;
}

#mainNav .nav-item > a::after {
    content: '';
    position: absolute;
    bottom: 5px; left: 15px; right: 15px;
    height: 1px;
    background: #b5904a;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform .22s ease;
}

#mainNav .nav-item > a:hover { color: #181818 !important; }
#mainNav .nav-item > a:hover::after { transform: scaleX(1); }

#mainNav .nav-item.active > a { color: #1e3a4f !important; }
#mainNav .nav-item.active > a::after { transform: scaleX(1); background: #1e3a4f; }

/* Language */
.hd-lang {
    display: inline-flex !important;
    align-items: center !important;
    gap: 5px !important;
    font-size: .88rem !important;
    font-weight: 600 !important;
    letter-spacing: .06em !important;
    text-transform: uppercase !important;
    color: #9a9891 !important;
    border-left: 1px solid #e2e0d8 !important;
    margin-left: 8px !important;
    padding-left: 18px !important;
}

.hd-lang:hover { color: #1e3a4f !important; }

.hd-lang .hd-lang__chevron {
    font-size: .55rem !important;
    opacity: .65;
}

/* Dropdown */
#header .dropdown-menu {
    border: 1px solid #e2e0d8 !important;
    border-radius: 8px !important;
    box-shadow: 0 10px 32px rgba(24,24,24,.1) !important;
    padding: 5px !important;
    min-width: 120px !important;
}

#header .dropdown-item {
    font-family: 'Nunito', sans-serif !important;
    font-size: .92rem !important;
    font-weight: 500 !important;
    color: #4a4a45 !important;
    border-radius: 5px !important;
    padding: 8px 14px !important;
    transition: all .15s !important;
}

#header .dropdown-item:hover {
    background: rgba(30,58,79,.07) !important;
    color: #1e3a4f !important;
}

/* Hamburger */
.header-btn-collapse-nav {
    background: transparent !important;
    border: 1px solid #e2e0d8 !important;
    color: #4a4a45 !important;
    padding: 9px 14px !important;
    border-radius: 6px !important;
    font-size: .9rem !important;
    transition: all .18s !important;
}

.header-btn-collapse-nav:hover {
    border-color: #1e3a4f !important;
    color: #1e3a4f !important;
}
</style>
