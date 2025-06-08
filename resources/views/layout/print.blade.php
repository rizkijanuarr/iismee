<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    <style>
        table,
        th,
        td {
            border: 1px solid;
            border-collapse: collapse;
            padding: 5px;
        }
    </style>

    {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet"> --}}

</head>

<body>
    @yield('konten')
</body>

</html>
