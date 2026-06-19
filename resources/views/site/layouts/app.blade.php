<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ data_get($settings, 'general.site_name', 'NEN') }} - {{ $pageTitle ?? 'Welcome' }}</title>
    <meta name="description" content="{{ data_get($settings, 'general.site_about', '') }}">
    <meta name="keywords" content="">
    <!-- Favicons -->
    <link href="{{ asset(data_get($settings, 'media.fav_icon', '/assets/favicon.png')) }}" rel="icon">
    <link href="{{ asset(data_get($settings, 'media.fav_icon', '/assets/favicon.png')) }}" rel="apple-touch-icon">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files (critical) -->
    <link href="{{asset('site/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('site/swiper-bundle.min.css')}}" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="{{asset('site/main.min.css')}}{{assetVersion()}}" rel="stylesheet">
    <link href="{{asset('site/custom.min.css')}}{{assetVersion()}}" rel="stylesheet">

    <!-- Preload hero image (first render) -->
    @if(isset($sliders) && $sliders->isNotEmpty())
    <link rel="preload" as="image" href="{{ asset($sliders->first()->getImage()) }}">
    @endif

    <!-- Non-critical CSS (loaded asynchronously) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/4.1.5/css/flag-icons.min.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" media="print" onload="this.media='all'">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/4.1.5/css/flag-icons.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    </noscript>

    @stack('styles')

    <!-- Preload critical scripts -->
    <link rel="preload" href="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" as="script">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-18065928371"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'AW-18065928371');

        // Event snippet for Page view conversion page
        gtag('event', 'conversion', {'send_to': 'AW-18065928371/rsdoCJ25n5ccELPhwKZD'});
    </script>

</head>

<body class="index-page @yield('body_class')">

{{-- Google Translate mounts here so the widget exists before /translate_a/element.js callback runs (loaded in footer after jQuery) --}}
<div id="google_translate_element" style="display:none" aria-hidden="true"></div>

<!-- Preloader -->
<div id="preloader"></div>

@include('site.layouts.header')

@yield('content')
@include('site.helpers.image-modal')
@include('site.helpers.offer-html5-video-modal')
@include('site.layouts.footer')

@stack('scripts')

</body>

</html>