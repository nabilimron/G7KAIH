<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Sistem Laporan G7KAIH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @include('includes.admin._style')
    @stack('styles')
</head>
<body>
    @include('includes.admin._sidebar')

    <div class="area">
        @include('includes.admin._navbar')

        <main>
            @yield('content')
        </main>

        @include('includes.admin._footer')
    </div>

    <div class="toast" id="toast" role="status"></div>

    @include('includes.admin._js')
    @stack('scripts')
</body>
</html>