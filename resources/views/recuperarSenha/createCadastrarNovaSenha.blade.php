@extends('layouts.login')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('/dist/img/intraNet.png') }}" class=" mr-3 " style="width:200px">
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <form action="{{ route('recuperarSenha.resetarMinhaSenhaDeUsuario', $colaborador->usuario->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Nova Senha:</label>
                        <input type="text" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Cadastre uma nova senha:" value="{{ old('password') }}">
                        @error('password')
                            <span class=" invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Confirmar Senha:</label>
                        <input type="text" name="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            placeholder="Repita sua nova senha:" value="{{ old('password_confirmation') }}">
                        @error('password')
                            <span class=" invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Recuperar minha senha</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mt-3 ">
                            Você também pode:
                        </div>
                        <div class="col-6">
                            <p class="mt-3 ">
                                <a href="/login" class="btn btn-success btn-block">Voltar ao Login</a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
