@extends(theme()->viewPath('layouts.app'))

@section('content')
    <!-- Main content -->
    <section class="error-page">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo">{!! theme()->logo() !!}</span>
        </a>

        <h2 class="error-page__code text-red"> {{ $status }}</h2>

        <div class="error-page__content">
            {{ $message ?: 'Something went wrong' }}
        </div>
    </section>
    <!-- /.content -->
@stop