<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
        @yield('title_tag')
    </title>
    <meta name="description" content="@yield('meta_description')">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:type" content="article" />

    <meta property="og:title" content="@yield('title_tag')" />

    <meta property="og:description" content="@yield('meta_description')" />

    <meta property="og:image" content="@yield('meta_image')" />

    <meta property="og:url" content="@yield('meta_url')" />

    <meta property="og:site_name" content="@yield('meta_sitename')" />

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    
    <!-- CSS  ========================= -->
    @include('frontend.layouts.css')

</head>

<body>
   

    @include('frontend.layouts.notification')

    @include('frontend.layouts.header')
    @yield('page-content')  
    @include('frontend.layouts.footer')

    @yield('cusjs')
 
   <!-- Jquery cdn -->


