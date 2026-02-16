<!DOCTYPE html>
<html lang="<?php echo e(getCurrentLanguage()->key); ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php echo e(getWebsiteSettings()->seo_title); ?> - <?php echo $__env->yieldContent('title'); ?></title>
    <meta name="keywords" content="<?php echo e(getWebsiteSettings()->seo_keywords); ?>" />
    <meta name="description" content="<?php echo e(getWebsiteSettings()->seo_description); ?>" />
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <?php echo $__env->yieldContent('css'); ?>
    
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
    </style>
    
    <!-- /assets CSS -->
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

    <!-- WhatsApp -->
    <div class="d-flex justify-content-end w-100 items-align-end" style="position:fixed; right:0.5%; z-index:99999; font-size:12px; top:93%;">
        <a href="https://api.whatsapp.com/send?phone=<?php echo e(getContact() ? getContact()->first()->phone ?? '' : ''); ?>" target="_blank">
            <img style="width:50px;" src="https://demobul.net/images/whatsapp.png" alt="whatsapp">
        </a>
    </div>

    <div class="body">
        <?php echo $__env->make('client.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div role="main" class="main">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        <?php echo $__env->make('client.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <?php echo $__env->yieldContent('js'); ?>
    <script src="/assets/client/vendor/plugins/js/plugins.min.js"></script>
    <script src="/assets/client/js/theme.js"></script>
    <script src="/assets/client/js/theme.init.js"></script>
</body>
</html>
<?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/client/layout.blade.php ENDPATH**/ ?>