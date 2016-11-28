@extends(themeView('layouts.app'))

@section('content')
    <div class="wrapper">
        <<header class="main-header">
            @include(themeView('layouts.partials.header'))
        </header>

        <aside class="main-sidebar">
            @include(themeView('layouts.partials.sidebar'))
        </aside>

        <div class="content-wrapper">.
            @if(isset($title))
            <div class="content-header">
                <h1>
                    {{{ $title }}}
                </h1>
            </div>
            @endif

            <div class="content body">
                @yield('block.content.header')
                {!! $content or null !!}
                @yield('block.content.footer')
            </div>
        </div>
    </div>
@stop