<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMPRAK')</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-bg-light min-h-screen font-sans">
    <div class="flex">
        {{-- Sidebar --}}
        <x-sidebar class="flex-shrink-0" />
        {{-- Content --}}
        <main class="flex-1 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>