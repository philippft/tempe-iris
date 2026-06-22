<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body class="font-sans">
    <h1>Ini Dashboard {{ auth()->user()->username }}</h1>
    <x-statecard
        title="Total Aktif"
        value="21"
        label="Peminjaman"
        bg="bg-[#E6F0F2]"
        border="border-l-[#0F6378]"
        iconBg="bg-[#DCE3E4]"
    >

        <svg xmlns="http://www.w3.org/2000/svg"
            class="size-4 text-[#ffffff]"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">

            <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 4v6h6M20 20v-6h-6M20 9a8 8 0 00-13.66-5.66L4 6m16 12l-2.34-2.34A8 8 0 014 15"/>
        </svg>

    </x-statecard>

    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
    @csrf <button type="submit" style="color: red; background: none; border: none; cursor: pointer; font-weight: bold;">
        Logout
    </button>
</form>
</body>
</html>