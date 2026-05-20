<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Ini Dashboard  Admin Dekanat, Hallo {{ auth()->user()->organization_name}}</h1>

    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
    @csrf <button type="submit" style="color: red; background: none; border: none; cursor: pointer; font-weight: bold;">
        Logout
    </button>
</form>
</body>
</html>