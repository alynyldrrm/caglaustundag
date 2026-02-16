<!DOCTYPE html>
<html lang="{{ getCurrentLanguage()->key }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ getWebsiteSettings()->seo_title }} - @yield('title')</title>
    <meta name="keywords" content="{{ getWebsiteSettings()->seo_keywords }}" />
    <meta name="description" content="{{ getWebsiteSettings()->seo_description }}" />
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('css')

    <!-- Light Theme Global Styles -->
    <style>
        :root {
            --color-bg: #ffffff;
            --color-bg-alt: #f8f9fa;
            --color-text: #1a1a1a;
            --color-text-muted: #666666;
            --color-border: #e5e5e5;
            --color-accent: #1a1a1a;
        }

        body {
            background-color: var(--color-bg) !important;
            color: var(--color-text) !important;
            font-family: 'Poppins', sans-serif;
        }

        .body {
            background-color: var(--color-bg) !important;
        }

        /* Header Light */
        #header {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--color-border) !important;
        }

        #header .header-nav-main nav > ul > li > a {
            color: #444 !important;
            font-weight: 500;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        #header .header-nav-main nav > ul > li > a:hover {
            color: #000 !important;
        }

        #header .header-nav-main nav > ul > li.dropdown .dropdown-menu {
            background: #fff !important;
            border: 1px solid #e5e5e5 !important;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        #header .header-nav-main nav > ul > li.dropdown .dropdown-menu a {
            color: #444 !important;
        }

        #header .header-nav-main nav > ul > li.dropdown .dropdown-menu a:hover {
            color: #000 !important;
            background: #f5f5f5 !important;
        }

        /* Footer Light */
        #footer {
            background: #f8f9fa !important;
            border-top: 1px solid #e5e5e5 !important;
            color: #666 !important;
        }

        #footer h4, #footer h5 {
            color: #1a1a1a !important;
        }

        #footer a {
            color: #666 !important;
        }

        #footer a:hover {
            color: #000 !important;
        }

        .footer-copyright {
            background: #fff !important;
            border-top: 1px solid #e5e5e5 !important;
        }

        /* Selection */
        ::selection {
            background: #1a1a1a;
            color: #fff;
        }

        /* WhatsApp Float Button */
        .whatsapp-float-btn {
            position: fixed;
            bottom: 100px;
            right: 20px;
            z-index: 999;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #25D366;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .whatsapp-float-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
        }

        .whatsapp-float-btn img {
            width: 40px;
            height: 40px;
        }

        /* Scroll To Top Button */
        .scroll-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            width: 50px;
            height: 50px;
            background: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .scroll-to-top.show {
            display: flex;
        }

        .scroll-to-top:hover {
            background: #333;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .scroll-to-top i {
            font-size: 1.2rem;
        }

        /* Mobil görünüm */
        @media (max-width: 768px) {
            .whatsapp-float-btn {
                bottom: 90px;
                right: 15px;
                width: 55px;
                height: 55px;
            }

            .whatsapp-float-btn img {
                width: 35px;
                height: 35px;
            }

            .scroll-to-top {
                bottom: 15px;
                right: 15px;
                width: 45px;
                height: 45px;
            }
        }
    </style>

    <!-- Assets CSS -->
    <link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/client/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/client/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/assets/client/vendor/animate/animate.compat.css">
    <link rel="stylesheet" href="/assets/client/css/theme.css">
    <link rel="stylesheet" href="/assets/client/css/theme-elements.css">

    <!-- Google tag -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DNF8D2EEHK"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-DNF8D2EEHK');
    </script>
</head>

<body data-plugin-page-transition>

    <!-- WhatsApp Float Button -->
    <a href="https://api.whatsapp.com/send?phone={{ getContact() ? str_replace([' ', '-', '(', ')'], '', getContact()->first()->phone ?? '') : '' }}"
       target="_blank"
       class="whatsapp-float-btn"
       aria-label="WhatsApp ile iletişime geç">
        <img src="https://demobul.net/images/whatsapp.png" alt="WhatsApp">
    </a>

    <!-- Scroll To Top Button -->
    <button class="scroll-to-top" id="scrollToTop" aria-label="Yukarı çık">
        <i class="fas fa-arrow-up"></i>
    </button>

    <div class="body">
        @include('client.partials.header')
        <div role="main" class="main">
            @yield('content')
        </div>
        @include('client.partials.footer')
    </div>

    @yield('js')
    <script src="/assets/client/vendor/plugins/js/plugins.min.js"></script>
    <script src="/assets/client/js/theme.js"></script>
    <script src="/assets/client/js/theme.init.js"></script>

    <!-- Scroll To Top Script -->
    <script>
        // Scroll To Top Functionality
        const scrollToTopBtn = document.getElementById('scrollToTop');

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.add('show');
            } else {
                scrollToTopBtn.classList.remove('show');
            }
        });

        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</body>
</html>
