<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign In</title>
    @include('backend.layouts.seo')
    <!-- FAVICONS -->
    <link rel="apple-touch-icon" sizes="144x144" href="assets/apple-touch-icon.png">
    <link rel="shortcut icon" href="assets/favicon.ico">
    @include('backend.layouts.css')
    @yield('headjs')
</head>
<body>
<!--[if lt IE 10]>
<div class="page-message" role="alert">You are using an <strong>outdated</strong> browser. Please <a class="alert-link" href="http://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</div>
<![endif]-->
<!-- .auth -->
<main class="auth">
    <header id="auth-header" class="auth-header">
        <h1>
             <span class="">Sign In</span>
        </h1>
        <p> Don't have a account? <a href="auth-signup.html">Create One</a>
        </p>
    </header><!-- form -->
    <form class="auth-form" method="POST" action="{{ route('login') }}">
        @csrf
        <!-- .form-group -->
        <div class="form-group">
            <div class="form-label-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Username" value="{{ old('email') }}" required autocomplete="email" autofocus>
                <label for="email">Email</label>
                @error('email')
                    <span class="invalid-feedback mx-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div><!-- /.form-group -->
        <!-- .form-group -->
        <div class="form-group">
            <div class="form-label-group">
{{--                <input type="password" id="inputPassword" class="form-control" placeholder="Password"> <label for="inputPassword">Password</label>--}}
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                <label for="inputPassword">Password</label>
                @error('password')
                    <span class="invalid-feedback mx-1" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div><!-- /.form-group -->
        <!-- .form-group -->
        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign In</button>
        </div><!-- /.form-group -->
        <!-- .form-group -->
        <div class="form-group text-center">
            <div class="custom-control custom-control-inline custom-checkbox">
{{--                <input type="checkbox" class="custom-control-input" id="remember-me"> <label class="custom-control-label" for="remember-me">Keep me sign in</label>--}}
                <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><label class="custom-control-label" for="remember-me">Keep me sign in</label>
            </div>
        </div><!-- /.form-group -->
        <!-- recovery links -->
        <div class="text-center pt-3">
            <a href="{{ route('password.request') }}" class="link">Forgot Password?</a>
        </div><!-- /recovery links -->
    </form><!-- /.auth-form -->
    <!-- copyright -->
    @include('backend.layouts.footer')
    <!-- /.wrapper -->
</main><!-- /.app-main -->
@include('backend.layouts.js')
@yield('cusjs')
</body>

</html>
