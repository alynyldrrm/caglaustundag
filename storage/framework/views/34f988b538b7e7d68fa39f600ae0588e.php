<?php
    $lang = getLanguageLinks();
    $defaultDatas = session('defaultDatas');
    $currentLanguage = $defaultDatas['currentLanguage'] ?? null;
?>

<header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 120, 'stickyHeaderContainerHeight': 70}">
    <div class="header-body border-top-0">
        <div class="header-container container">
            <div class="header-row">
                <div class="header-column">
                    <div class="header-row">
                        <div class="header-logo">
                            <a href="/<?php echo e(App::getLocale()); ?>">
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
                                        <?php echo createMenus(getMenus()); ?>


                                        <li class="nav-item dropdown nav-item-left-border d-none d-sm-block nav-item-left-border-remove nav-item-left-border-md-show">
                                            <a class="nav-link hd-lang" href="#" role="button"
                                               id="dropdownLanguage"
                                               data-bs-toggle="dropdown"
                                               aria-haspopup="true"
                                               aria-expanded="false">
                                                <i class="fa-solid fa-globe"></i>
                                                <?php echo e($currentLanguage ? $currentLanguage->key : App::getLocale()); ?>

                                                <i class="fas fa-angle-down hd-lang__chevron"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownLanguage">
                                                <?php $__currentLoopData = $lang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $language = App\Models\Language::where('key', $key)->first(); ?>
                                                    <?php if($language): ?>
                                                        <a class="dropdown-item" href="<?php echo e($item); ?>"><?php echo e($language->text); ?></a>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    font-family: 'Outfit', sans-serif !important;
    background: rgba(255,255,255,0.97) !important;
    backdrop-filter: blur(12px) !important;
    -webkit-backdrop-filter: blur(12px) !important;
    border-bottom: 1px solid #e4e2dc !important;
    box-shadow: 0 1px 0 rgba(0,0,0,.04) !important;
}

/* Logo */
#header .header-logo img {
    transition: opacity .2s;
}

#header .header-logo a:hover img { opacity: .8; }

/* Nav links */
#mainNav .nav-item > a {
    font-family: 'Outfit', sans-serif !important;
    color: #555550 !important;
    font-size: .85rem !important;
    font-weight: 500 !important;
    letter-spacing: .03em !important;
    padding: 10px 16px !important;
    transition: color .2s !important;
    position: relative;
}

#mainNav .nav-item > a::after {
    content: '';
    position: absolute;
    bottom: 4px; left: 16px; right: 16px;
    height: 1px;
    background: #2a3d52;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform .25s ease;
}

#mainNav .nav-item > a:hover { color: #1c1c1c !important; }
#mainNav .nav-item > a:hover::after { transform: scaleX(1); }

/* Active */
#mainNav .nav-item.active > a { color: #2a3d52 !important; }
#mainNav .nav-item.active > a::after { transform: scaleX(1); }

/* Language dropdown */
.hd-lang {
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    font-size: .78rem !important;
    font-weight: 500 !important;
    letter-spacing: .06em !important;
    text-transform: uppercase !important;
    color: #9a9891 !important;
    border-left: 1px solid #e4e2dc !important;
    margin-left: 10px !important;
    padding-left: 20px !important;
}

.hd-lang:hover { color: #2a3d52 !important; }

.hd-lang .hd-lang__chevron {
    font-size: .55rem !important;
    opacity: .7;
}

/* Dropdown menu */
#header .dropdown-menu {
    border: 1px solid #e4e2dc !important;
    border-radius: 8px !important;
    box-shadow: 0 12px 36px rgba(28,28,28,.1) !important;
    padding: 6px !important;
    min-width: 120px !important;
}

#header .dropdown-item {
    font-family: 'Outfit', sans-serif !important;
    font-size: .82rem !important;
    font-weight: 400 !important;
    color: #555550 !important;
    border-radius: 6px !important;
    padding: 8px 14px !important;
    transition: all .15s !important;
}

#header .dropdown-item:hover {
    background: rgba(42,61,82,.07) !important;
    color: #2a3d52 !important;
}

/* Hamburger */
.header-btn-collapse-nav {
    background: transparent !important;
    border: 1px solid #e4e2dc !important;
    color: #555550 !important;
    padding: 9px 14px !important;
    border-radius: 7px !important;
    font-size: .85rem !important;
    transition: all .2s !important;
}

.header-btn-collapse-nav:hover {
    border-color: #2a3d52 !important;
    color: #2a3d52 !important;
}
</style>
<?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/client/partials/header.blade.php ENDPATH**/ ?>