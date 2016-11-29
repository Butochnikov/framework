<!DOCTYPE html>
<html lang="{{ trans()->getLocale() }}">
    <head>
        {!! theme()->renderMeta( isset($title) ? $title : null ) !!}

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        @stack('scripts')
    </head>

    <!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
    <!-- the fixed layout is not compatible with sidebar-mini -->
    <body class="skin-blue sidebar-mini" data-route="{{ $route or null }}">

        @yield('content')

        @stack('footer-scripts')
    </body>
</html>