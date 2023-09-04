@extends('layouts.login')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('/dist/img/intraNet.png') }}" class=" mr-3 " style="width:200px">
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="mt-3 mb-1">
                    <ion-icon name="chevron-back-outline"></ion-icon> <a href="/login">Voltar</a>
                </p>
                <h1>Redefinição de senha!</h1>
                <p class="">Informe um email e enviaremos um link para recuperação da sua senha.</p>
                <form action="{{ route('user.reset-password') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email">
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
                            <button type="submit" class="btn btn-primary btn-block">Enviar link de recuperação</button>
                        </div>
                    </div>
                </form>
                <p class="mt-3 mb-1">
                </p>
            </div>
        </div>
    </div>
@endsection
