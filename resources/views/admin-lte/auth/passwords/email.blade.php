@extends(theme()->viewPath('layouts.app'))

<!-- Main Content -->
@section('content')
    @include(theme()->viewPath('layouts.partials.simple-header'))
    <div class="login-box">
        <div class="login-logo">
            Reset Password
        </div>

        <!-- /.login-logo -->
        <div class="login-box-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form role="form" method="post" action="{{ backend_url('/password/email') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" name="email" class="form-control" placeholder="E-Mail Address" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-flat">
                        Send Password Reset Link
                    </button>
                </div>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@endsection
