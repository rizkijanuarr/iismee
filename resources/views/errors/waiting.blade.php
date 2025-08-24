<!DOCTYPE html>
<html>

<head>
    <title>{{ __('messages.waiting_title') }}</title>

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
            <div class="title">{{ __('messages.waiting_title') }}...⏳</div>
            <p>{{ __('messages.waiting_process') }} <br>{{ __('messages.waiting_instruction') }}</p>
            <a href="{{ url('login') }}">{{ __('messages.back_to_login') }}</a>
        </div>
    </div>
</body>

</html>
