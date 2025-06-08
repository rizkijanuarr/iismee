<!DOCTYPE html>
<html>

<head>
    <title>403 Forbidden</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
            font-family: 'Nunito', sans-serif;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 72px;
            margin-bottom: 40px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <img src="{{ URL::asset('/img/403.svg') }}" height="300" alt="">
            <div class="title">403 Forbidden</div>
            <p>Maaf, Anda tidak diizinkan untuk mengakses halaman ini.</p>
        </div>
    </div>
</body>

</html>
