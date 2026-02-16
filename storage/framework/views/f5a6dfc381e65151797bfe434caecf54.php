<!doctype html>
<html lang="tr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Admin Paneli | Login </title>
    <!-- CSS files -->
    <link href="/assets/admin/dist/css/tabler.min.css" rel="stylesheet" />
    <link href="/assets/admin/dist/css/tabler-flags.min.css" rel="stylesheet" />
    <link href="/assets/admin/dist/css/tabler-payments.min.css" rel="stylesheet" />
    <link href="/assets/admin/dist/css/tabler-vendors.min.css" rel="stylesheet" />
    <link href="/assets/admin/dist/css/demo.min.css" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body class=" d-flex flex-column">
    <script src="/assets/admin/dist/js/demo-theme.min.js"></script>
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a href="/" class="navbar-brand navbar-brand-autodark"><img src="/assets/admin/logo.png"
                        height="100" alt=""></a>
            </div>
            <div class="card card-md">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Hesabınıza Giriş Yapınız</h2>
                    <form action="<?php echo e(route('login.post', App::currentLocale())); ?>" method="POST" autocomplete="off"
                        novalidate>
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">E-Mail</label>
                            <input type="email" name="email" class="form-control" placeholder="example@example.com"
                                autocomplete="off">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">
                                Şifre
                                
                            </label>
                            <div class="input-group input-group-flat">
                                <input id="passwordInput" type="password" name="password" class="form-control"
                                    placeholder="******" autocomplete="off">
                                <span class="input-group-text">
                                    <button class="bg-transparent border-0" type="button" onclick="showPassword()"
                                        class="link-secondary border-0 bg-transparent" title="Şifreyi Göster"
                                        data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path
                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                    </button>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
                        </div>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger mt-3">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($err); ?> <br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
                
            </div>
            
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="/assets/admin/dist/js/tabler.min.js" defer></script>
    <script src="/assets/admin/dist/js/demo.min.js" defer></script>
    <script>
        const showPassword = () => {
            let input = document.getElementById('passwordInput');
            if (input.type == "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>

</html>
<?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/auth/login.blade.php ENDPATH**/ ?>