<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#0b1120">
    <title>@yield('title', 'E-Journal')</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://unpkg.com/lucide-static@latest/font/lucide.css">
</head>
<body>
    <div class="app-container">
        {{-- Auth pages have no header/bottom nav --}}
        @yield('content')
    </div>
</body>
</html>
