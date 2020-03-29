<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <title>{{ config('app.name') }}</title>
</head>
<body>

    @include("include.top-nav-bar")

    <div class="container">
        <div class="row mt-5">
            <div class="col col-12">
                @include("include.alert-validation")
                @include("include.alert-message")
            </div>
        </div>

        @yield('body')
    </div>

    {{-- Inject all URL param vars into JS as an object literal --}}
    <script>
        window.$GET = {!! $queryString !!};
    </script>

    <!-- dynamic and injected via Laravel -->
    <script src="{{ mix('/js/manifest.js') }}?v={{ date('ymd') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}?v={{ date('ymd') }}"></script>
    <script src="{{ mix('/js/app.js') }}?v={{ date('ymd') }}"></script>

    {{-- Load automatically some javascript environments --}}
    <script src="{{ route('home.assets.lang') }}?v={{ date('ymd') }}"></script>

    <!-- Interface Controller per View -->
    <script src="{{ mix('/js/controllers/Main.controller.js') }}?v={{ date('ymd') }}"></script>
    <script>
        window.Artist4Artist = window.Artist4Artist ? window.Artist4Artist : {};
        window.InterfaceController.init();
    </script>

    @if(file_exists(public_path('/js/controllers/' . ucfirst($view_name) . '.controller.js')))
        <script src="{{ mix('/js/controllers/' . ucfirst($view_name) . '.controller.js') }}?v={{ date('ymd') }}"></script>
        <script>
            $(function () {
                window.Artist4Artist.template = "{{ucfirst($view_name)}}";
                window.InterfaceController.{{ucfirst($view_name)}}.init();
            });
        </script>
    @else
        <script>console.warn("File not found: ", '/js/controllers/{{ ucfirst($view_name) }}.controller.js');</script>
    @endif

    @stack('endscripts')

</body>
</html>
