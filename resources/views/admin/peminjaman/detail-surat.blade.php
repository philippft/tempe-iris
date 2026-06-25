<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="{{ route('admin.download.surat', $surat->id) }}"
        class="inline-block px-3 py-1.5 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition text-xs shadow-sm">
        Cetak PDF
    </a>
</body>
</html>