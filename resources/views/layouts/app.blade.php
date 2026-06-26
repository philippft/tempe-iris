<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMPRAK')</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-bg-light h-screen font-sans overflow-hidden">
    <div class="flex h-full">
        {{-- Sidebar --}}
        <x-sidebar class="flex-shrink-0" />
        {{-- Content --}}
        <main class="flex-1 p-10 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>