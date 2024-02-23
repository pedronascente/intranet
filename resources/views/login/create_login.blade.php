@extends('layouts.login')
@section('content')

@php
    /*
    *  [ VARIAVEI DE TESTE ]
    */
    $deBuglogin  = config('app.teste_login');
    $deBugpassword = config('app.teste_pass');

@endphp

<div class="login-logo">
    <img src="{{ asset('/dist/img/intraNet.png') }}" class=" mr-3 " style="width:200px">
</div>
<div class="card">
    <div class="card-body login-card-body">
        <h1>{{ $mensagem }}!</h1>
        <p>para iniciar insira seus <b>dados</b>.</p>
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    placeholder="Usuário" value="{{ $deBuglogin }}">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                @error('name')
                    <span class=" invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <input type="text" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Senha" value="{{ $deBugpassword }}">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="row">
                <div class="col-8">
                    <a href="{{ route('recuperarSenha.informarEmailRecuperarSenha') }}">Recuperar senha?</a>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                </div>
            </div>
        </form>
        <p class="mt-3 mb-1">
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
