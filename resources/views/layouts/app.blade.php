<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMPRAK')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-bg-light h-screen font-sans overflow-x-auto">
    <div class="flex h-screen min-h-0">
        {{-- Sidebar --}}
        <x-sidebar class="flex-shrink-0" />
        {{-- Content --}}
        <main class="flex-1 min-h-0 overflow-y-auto m-5">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>