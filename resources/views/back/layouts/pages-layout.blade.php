<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('pageTitle')</title>
    <!-- CSS files -->
    <base href="/">
    <link href="./back/dist/css/tabler.min.css" rel="stylesheet" />
    <link href="./back/dist/css/tabler-flags.min.css" rel="stylesheet" />
    <link href="./back/dist/css/tabler-payments.min.css" rel="stylesheet" />
    <link href="./back/dist/css/tabler-vendors.min.css" rel="stylesheet" />
    <link href="./back/dist/libs/iJabo/ijabo.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/back/dist/libs/ijaboCroptool/ijaboCroptool.min.css') }}">
    <link href="./back/dist/css/demo.min.css" rel="stylesheet" />
    @stack('stylesheets')
    @livewireStyles
</head>

<body>
    <div class="wrapper">
        @include('back.layouts.inc.header')
        <div class="page-wrapper">
            <div class="container-xl">
                <!-- Page title -->
                @yield('pageHeader')
            </div>
            <div class="page-body">
                <div class="container-xl">
                    @yield('content')
                </div>
            </div>
            @include('back.layouts.inc.footer')
        </div>
    </div>

    <!-- Libs JS -->
    <script src="{{ asset('back/dist/libs/jQuery/jquery.js') }}"></script>
    <script src="./back/dist/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="{{ asset('back/dist/libs/iJabo/ijabo.min.js') }}"></script>
    <script src="{{ asset('back/dist/libs/ijaboCroptool/ijaboCropTool.min.js') }}"></script>
    <script src="{{ asset('back/dist/libs/ijaboViewer/jquery.ijaboViewer.min.js') }}"></script>
    <!-- Tabler Core -->
    <script src="./back/dist/js/tabler.min.js"></script>

    @stack('scripts')
    @livewireScripts
    <script>
        window.addEventListener("showToastr", function(event) {
            toastr.remove();
            if (event.detail.type === 'info') {
                toastr.info(event.detail.message)
            } else if (event.detail.type === 'success') {
                toastr.success(event.detail.message)
            } else if (event.detail.type === 'error') {
                toastr.error(event.detail.message)
            } else if (event.detail.type === 'warning') {
                toastr.warning(event.detail.message)
            } else {
                return false
            }
        })
    </script>
    @stack('scripts')
    <script script src="./back/dist/js/demo.min.js"></script>
</body>

</html>
