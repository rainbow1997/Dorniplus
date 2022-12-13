<!DOCTYPE html>
<html lang="{{  app()->getLocale() }}" dir="{{__('site.dir')}}"> <!-- temprary x method -->
<head>

    <title inertia>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">

    <!-- Styles -->


    <!-- Scripts -->
    @routes
    @vite('resources/js/app.js')

    @inertiaHead

</head>

<body dir="rtl" class="bg-gray-100 dark:bg-gray-800 rounded-2xl  overflow-scroll relative font-body">
@inertia

<script src="{{asset('js/flowbite.js')}} " defer></script>
</body>
</html>
