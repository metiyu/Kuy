<?php use Illuminate\Support\Facades\Session; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- @vite('resources/css/app.css','public/build/assets/*.css') --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <div class="flex flex-col">
        @include('components.header')
        <div class="flex-grow">
            @yield('content')
        </div>
    </div>
    <div>
        @include('components.footer')
    </div>
    @include('sweetalert::alert')
</body>

</html>
