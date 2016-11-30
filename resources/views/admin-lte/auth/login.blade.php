@extends(theme()->viewPath('layouts.app'))

@section('content')
    @include(theme()->viewPath('layouts.partials.simple-header'))
    <div class="login-box">
        <div class="login-logo">
            Login page
        </div>

        <!-- /.login-logo -->
        <div class="login-box-body">

            @yield('block.header')

            <form role="form" method="post" action="{{ backend_url('/login') }}">
                {{ csrf_field() }}

                @yield('block.form.header')

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox">
                                <label> <input type="checkbox" name="remember"> Remember Me </label>
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">
                                Login
                            </button>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>

                @yield('block.form.footer')
            </form>

            <a class="btn btn-flat btn-link" href="{{ backend_url('/password/reset') }}"> Forgot Your Password? </a>

            @yield('block.buttons')
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@endsection
