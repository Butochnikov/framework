@extends(theme()->viewPath('layouts.app'))

@section('content')
    @include(theme()->viewPath('layouts.partials.simple-header'))

    <!-- Main content -->
    <section class="error-page">
        <h2 class="error-page__code text-red"> {{ $status }}</h2>

        <div class="error-page__content">
            {{ $message ?: 'Something went wrong' }}
        </div>
    </section>
    <!-- /.content -->
@stop