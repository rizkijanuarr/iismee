<!DOCTYPE html>
<html>

<head>
    <title>Waiting</title>

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
            <img src="{{ URL::asset('/img/waiting.svg') }}" height="300" alt="">
            <div class="title">Waiting</div>
            <p>Pendaftaran akun anda sedang diproses <br>Harap menunggu atau hubungi Admin</p>
            <a href="{{ url('login') }}"> Kembali ke halaman login</a>
        </div>
    </div>
</body>

</html>
