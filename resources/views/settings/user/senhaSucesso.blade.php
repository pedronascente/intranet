@extends('layouts.login')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('/dist/img/intraNet.png') }}" class=" mr-3 " width="200px">
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <h4>Senha Cadastrada com Sucesso!</h4>
                <div class="row mt-3">
                    <div class="col-md-3">
                        <img src="{{ asset('/dist/img/email.jpg') }}" width="100%">
                    </div>
                    <div class="col-md-9">
                        <p>Acabamos de enviar um email com os dados de
                            acesso.</p>
                    </div>
                </div>
                <p><a href="/">Voltar para o Login </a></p>
                <p class="mt-3 mb-1"></p>
            </div>
        </div>
    </div>
@endsection
