@extends('layouts.app')
@section('content')
    <!-- Profile Image -->
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="../../dist/img/user4-128x128.jpg"
                    alt="User profile picture">
            </div>
            <h3 class="profile-username text-center">{{ $usuario->name }}</h3>
            <p class="text-muted text-center">{{ $colaborador->cargo->nome }}</p>
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Base</b> <a class="float-right">{{ $colaborador->base->nome }}</a>
                </li>
                <li class="list-group-item">
                    <b>Empresa</b> <a class="float-right">{{ $colaborador->empresa->nome }}</a>
                </li>
                <li class="list-group-item">
                    <b>Cargo</b> <a class="float-right">{{ $colaborador->cargo->nome }}</a>
                </li>
                <li class="list-group-item">
                    <b>Ramal</b> <a class="float-right">521</a>
                </li>
                <li class="list-group-item">
                    <b>Perfil</b> <a class="float-right">{{ $perfil->nome }}</a>
                </li>
                <li class="list-group-item">
                    <b>Status</b> <a class="float-right">{{ $status }}</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Informações Pessoais</h3>
        </div>
        <div class="card-body">
            <strong> Nome</strong>
            <p class="text-muted">{{ $colaborador->nome }} {{ $colaborador->sobrenome }}</p>
            <hr>
            <strong>Email</strong>
            <p class="text-muted"> {{ $colaborador->email }}</p>
            <hr>
            <strong>RG</strong>
            <p class="text-muted">{{ $colaborador->rg }}</p>
            <hr>
            <strong>CPF</strong>
            <p class="text-muted">{{ $colaborador->cpf }}</p>
            <hr>
            <strong>CNPJ</strong>
            <p class="text-muted">{{ $colaborador->cnpj }}</p>
            <a href="submit" class="btn bg-gradient-primary">
                Alterar Informaçoes
            </a>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Informações de Acesso</h3>
        </div>
        <div class="card-body">
            <strong> Cartão</strong>
            <p class="text-muted">{{ $cartao->nome }}</p>
            <hr>
            <table class="table table-bordered ">
                <thead>
                    <th>Token</th>
                    <th class="text-center">Posição</th>
                </thead>
                <tbody>
                    @if ($cartao->tokens)
                        @foreach ($cartao->tokens as $item)
                            <tr>
                                <td>{{ $item->token }}</td>
                                <td class="text-center">{{ $item->posicao }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <hr>
        </div>
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Segurança</h3>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Senha atual:</label>
                                <input type="text" name="password" class="form-control" placeholder="senha"
                                    value="">
                                <span class=" invalid-feedback"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nova senha:</label>
                                <input type="text" name="password" class="form-control" placeholder="senha"
                                    value="">
                                <span class=" invalid-feedback"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Confirmar senha:</label>
                                <input type="text" name="password" class="form-control" placeholder="senha"
                                    value="">
                                <span class=" invalid-feedback"></span>
                            </div>
                        </div>
                    </div>
                    <x-ui.panel-dica-boa-senha />
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn bg-gradient-primary">
                        <i class="fas fa-save" aria-hidden="true"></i>
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
