@extends('layouts.login')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('/dist/img/intraNet.png') }}" class=" mr-3 " width="200px">
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <img src="  https://front-hub-service.rdops.systems/assets/accounts-frontend-login/0.9.59/static/media/recover-password-success.9ff93c18.svg"
                    class=" mr-3 " width="100%">
                <p class="mt-3 mb-1"></p>
                <h1>Redefinição de senha!</h1>
                <p>Acabamos de enviar um email com as instruções para redefinir sua senha.</p>
                <p><a href="/">Voltar para o Login </a></p>
                <p class="mt-3 mb-1"></p>
            </div>
        </div>
    </div>
@endsection
