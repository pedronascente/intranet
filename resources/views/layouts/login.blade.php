<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Intranet | Login</title>
    <link rel="shortcut icon" href="{{ asset('dist/img/favicon96x96.png') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    <style>
        .login-page,
        .register-page {
            -ms-flex-align: center;
            align-items: center;
            background-image: url(../dist/img/background.jpg);
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            height: 100vh;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .login-box-msg,
        .register-box-msg {
            margin: 0;
            padding: 0 10px 20px;
            text-align: center;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible text-center">
                <h5><i class="icon fas fa-ban"></i>Acesso Negado! </h5>
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>

</html>
