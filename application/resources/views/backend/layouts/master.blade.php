<!DOCTYPE html>
<html lang="en">
<head>
    @include('backend.layouts.seo')
    <!-- FAVICONS -->
    <link rel="apple-touch-icon" sizes="144x144" href="assets/apple-touch-icon.png">
    <link rel="shortcut icon" href="assets/favicon.ico">
    @include('backend.layouts.css')
    @yield('headjs')
</head>
<body>
<!-- .app -->
<div class="app">
    @include('backend.layouts.header')
    <!--[if lt IE 10]>
    <div class="page-message" role="alert">You are using an <strong>outdated</strong> browser. Please <a class="alert-link" href="http://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</div>
    <![endif]-->

    <!-- .app-main -->
    <main class="app-main">
        <!-- .wrapper -->
        <div class="wrapper">
            <!-- .page -->
            <div class="page">
                <!-- .page-inner -->
                @hasSection('content-filter')
                    <nav class="card" cclass="page-navs h-auto pt-2">
                        <div class="card-body py-2 pt-3 px-5">
                            @yield('content-filter')
                        </div>
                    </nav>
                @endif
                <div class="page-inner px-2 py-0">
                   @include('backend.layouts.content_wrapper')
                </div><!-- /.page-inner -->
            </div><!-- /.page -->
        </div><!-- .app-footer -->
        @include('backend.layouts.footer')
        <!-- /.wrapper -->
    </main><!-- /.app-main -->
</div><!-- /.app -->
@include('backend.layouts.js')

@yield('cusjs')
</body>

</html>
