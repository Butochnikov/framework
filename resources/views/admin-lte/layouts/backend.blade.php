@extends(theme()->viewPath('layouts.app'))

@section('content')
    @include(theme()->viewPath('layouts.partials.header'))
    @include(theme()->viewPath('layouts.partials.sidebar'))

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @if(isset($title))
            <section class="content-header">
                <h1>
                    {{{ $title }}}
                </h1>
            </section>
        @endif

        <!-- Main content -->
        <section class="content">

            @yield('block.content.header')
            {!! $content or null !!}
            @yield('block.content.footer')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include(theme()->viewPath('layouts.partials.footer'))
    @include(theme()->viewPath('layouts.partials.control-sidebar'))
@stop