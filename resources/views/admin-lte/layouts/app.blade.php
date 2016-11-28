<!DOCTYPE html>
<html lang="{{ trans()->getLocale() }}">
<head>
    {!! theme()->renderMeta($title) !!}
    @stack('scripts')
</head>
<body class="skin-blue sidebar-mini" data-route="{{ $route || '' }}">
        @yield('content')

    @stack('footer-scripts')
</body>
</html>