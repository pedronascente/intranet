@extends('layouts.applogin')
@section('content')
    <div class="login-logo">
        <img src="{{ asset('/dist/img/intraNet.png') }}" class=" mr-3 " style="width:200px">
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ $mensagem }}, para iniciar insira seus <b>dados</b>.</p>
            <form action="/login/auth-token" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Usuário">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Senha">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <a href="forgot-password.html">Esqueci minha senha</a>
                    </div>
                    <div class="col-4">
                        <a href="/login/auth-token" class="btn btn-primary btn-block">Entrar</a>
                        <!--  <button type="submit" class="btn btn-primary btn-block">Entrar</button> -->
                    </div>
                </div>
            </form>
            <p class="mb-1">

            </p>
        </div>
    </div>
    <div class="row mt-5 text-center">
        <div class="col-md-12">
            <a href="forgot-password.html">Link XPOT</a> |
            <a href="forgot-password.html">Link XPOT</a> |
            <a href="forgot-password.html">Link XPOT</a>
        </div>
    </div>
@endsection
