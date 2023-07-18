@extends('layouts.login')
@section('content')
    <div class="login-logo">
        <img src="{{ asset('/dist/img/intraNet.png') }}" class=" mr-3 " style="width:200px" alt="intraNet.png">
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ $mensagem }}, para continuar insira seu Token</p>
            <form action="{{ route('token.create') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" value="POSIÇÃO : {{ $posicaoDoToken }}" disabled="true">
                    <input type="hidden" name="posicaoDoToken" value="{{ $posicaoDoToken }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-address-card"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="token" class="form-control" placeholder="Token">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <a href="/login/recuperar-cartao-token">Perdi meu Cartão Token</a>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
