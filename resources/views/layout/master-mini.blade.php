<!DOCTYPE html>
<html>

<head>
    <title>admin absensi</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="_token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">

    <!-- plugin css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/@mdi/font/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css.map') }}">
    <!-- end plugin css -->

    <!-- plugin css -->
    @stack('plugin-styles')
    <!-- end plugin css -->

    <!-- common css -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/app.js.map') }}"></script>
    <!-- end common css -->

    @stack('style')

</head>

<body data-base-url="{{ url('/') }}">

    <div class="container-scroller" id="app">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- base js -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/app.js.map') }}"></script>
    <!-- end base js -->

    <!-- plugin js -->
    @stack('plugin-scripts')
    <!-- end plugin js -->

    @stack('custom-scripts')
    <script src="{{ asset('assets/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/vendor.bundle.addons.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>

    <script>
        document.getElementById("sidebarToggle").addEventListener("click", function() {
            const icon = document.getElementById("toggleIcon");

            if (icon.classList.contains("mdi-arrow-left")) {
                icon.classList.remove("mdi-arrow-left");
                icon.classList.add("mdi-arrow-right");
            } else {
                icon.classList.remove("mdi-arrow-right");
                icon.classList.add("mdi-arrow-left");
            }
        });
    </script>
</body>

</html>
