<!doctype html>

<html lang="tr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="icon" href="/assets/admin/logo.png" type="image/png">
    <title>Admin Paneli - @yield('title')</title>
    <!-- CSS files -->
    <link href="/assets/admin/dist/css/tabler.min.css?1684106062" rel="stylesheet" />
    <link href="/assets/admin/dist/css/tabler-flags.min.css?1684106062" rel="stylesheet" />
    <link href="/assets/admin/dist/css/tabler-payments.min.css?1684106062" rel="stylesheet" />
    <link href="/assets/admin/dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet" />
    <link href="/assets/admin/dist/css/demo.min.css?1684106062" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    @yield('css')
</head>

<body>
    <script src="/assets/admin/dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page">
        <!-- Sidebar -->
        @include('admin.partials.header')
        <div class="page-wrapper">
            <!-- Page header -->
            <div class="page-header d-print-none">
                <div class="container-fluid">
                    <div class="row g-2 align-items-center">
                        @yield('content-title')
                    </div>
                </div>
            </div>
            <!-- Page body -->
            <div class="page-body">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @include('admin.partials.footer')
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="/assets/admin/dist/js/tabler.min.js?1684106062" defer></script>
    <script src="/assets/admin/dist/js/demo.min.js?1684106062" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        const ErrorToast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        @if ($errors->any())
            let errors = @json($errors->all());
            let message = "";
            errors.forEach(error => {
                message += `${error}<br>`;
            });
            ErrorToast.fire({
                icon: 'error',
                title: message
            })
        @endif
    </script>
    <script>
        const SuccessToast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        @if (session('success'))
            let message = "{{ session('success') }}";
            SuccessToast.fire({
                icon: 'success',
                title: message
            })
        @endif
    </script>
    <script>
        @php
            $languages = App\Models\Language::get();
        @endphp
        const languages = @json($languages);
    </script>
    <script>
        const ajaxErrorHandle = (err) => {
            if (err.status === 422) {
                let message = "";
                let errors = Object.values(err.responseJSON.errors);
                errors.forEach(error => {
                    error.forEach(err => {
                        message += `${err}<br>`;
                    });
                });
                ErrorToast.fire({
                    icon: 'error',
                    title: message
                })
            } else {
                ErrorToast.fire({
                    icon: 'error',
                    title: "Bir hata oluştu daha sonra tekrar deneyiniz."
                })
            }
        }
    </script>
    @yield('js')
</body>

</html>
