@extends('layouts.login')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('/dist/img/intraNet.png') }}" class=" mr-3 " style="width:200px">
        </div>
        <div class="card">
            <div class="card-body login-card-body  ">
                <form action="{{ route('user.recuperarSenhaCreate') }}" method="post">
                    @csrf
                    <div class="input-group mb-3 mt-3">
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Informe seu E-mail">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
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
