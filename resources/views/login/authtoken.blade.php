@extends('layouts.applogin')
@section('content')
    <div class="login-logo">
        <img src="{{ asset('/dist/img/intraNet.png') }}" class=" mr-3 " style="width:200px">
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ $mensagem }},<br> para continuar insira seu <b>Token</b> </p>
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="senha" class="form-control" placeholder="Código do cartão">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Token">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <a href="forgot-password.html">Perdi meu cartao Token</a>
                    </div>
                    <div class="col-4">
                        <a href="/home" class="btn btn-primary btn-block">Entrar</a>
                        <!--  <button type="submit" class="btn btn-primary btn-block">Entrar</button> -->
                    </div>
                </div>
            </form>
            <p class="mb-1">

            </p>
        </div>
    </div>
@endsection
