<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-100">
    <!-- 画面全体を中央に配置するコンテナ -->
    <div class="flex flex-col justify-center items-center py-6 px-4">
        <div class="1g:w-3/5 mx-auto bg-white shadow-md rounded-lg p-4 sm:p-8">
            {{ $slot }}
        </div>

    </div>
</body>

</html>