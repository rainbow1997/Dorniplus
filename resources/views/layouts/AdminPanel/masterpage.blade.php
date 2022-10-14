<!DOCTYPE html>
<html lang="{{  app()->getLocale() }}" dir="{{__('site.dir')}}"> <!-- temprary x method -->
<head>

    <title inertia>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">


    <!-- Scripts -->
    @routes
    <script src="{{ mix('js/app.js') }}" defer></script>

    @inertiaHead

</head>

<body dir="rtl" class="bg-gray-100 dark:bg-gray-800 rounded-2xl h-screen overflow-hidden relative font-body">
@inertia

<script src="{{asset('js/flowbite.js')}} " defer></script>
</body>
</html>
