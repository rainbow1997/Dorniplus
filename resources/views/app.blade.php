<!DOCTYPE html>
<html lang="{{  app()->getLocale() }}" dir="{{__('site.dir')}}"> <!-- temprary method -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ __('site.appName') }}</title>

    <meta name="description" content="{{__('site.description')}}"/>
    <meta property="og:locale" content="{{app()->getLocale()}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{__('site.appName')}}"/>
    <meta property="og:description" content="{{__('site.description')}}"/>
    <meta property="og:url" content="{{config('app.url')}}"/>
    <meta property="og:site_name" content="{{__('site.appName')}}: {{__('site.description')}}"/>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->

    <!-- Scripts -->
    @vite('resources/js/app.js')

    @routes
    @inertiaHead
</head>
<body class="font-sans antialiased">
@inertia

{{--@env ('local')--}}
{{--    <script src="{{asset('js/bundle.js')}}"></script>--}}
{{--@endenv--}}
<script src="{{asset('js/flowbite.js')}} " defer></script>
</body>
</html>
