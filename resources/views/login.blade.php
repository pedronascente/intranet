@extends('layouts.applogin')
@section('content')
    <div class="login-logo">
        <a href="../../index2.html">
            <img src="{{ asset('/dist/img/intraNet.png') }}" class=" mr-3 " style="width:200px">
        </a>
    </div>

    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Inicie sessão para iniciar a sessão</p>

            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Lembrar-me
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <a href="/home" class="btn btn-primary btn-block">Entrar</a>
                        <!--  <button type="submit" class="btn btn-primary btn-block">Entrar</button> -->
                    </div>
                </div>
            </form>

            <p class="mb-1">
                <a href="forgot-password.html">Esqueci minha senha</a>
            </p>

        </div>
        <!-- /.login-card-body -->
    </div>
@endsection
