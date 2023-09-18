@extends('layouts.login')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('/dist/img/intraNet.png') }}" class=" mr-3 " width="200px">
        </div>
        <div class="card">
            <div class="card-body login-card-body text-center">
                <div class="row mt-3 ">
                    <div class="col-md-12">
                        <h4>Senha Cadastrada com Sucesso!</h4>
                    </div>
                </div>
                <p class="mt-3 mb-1"></p>
                <p><a href="/" class="btn btn-success">Efetuar Login</a></p>
                <p class="mt-3 mb-1"></p>
            </div>
        </div>
    </div>
@endsection
