@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <form action="{{ route('usuario.update', 4) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group ">
                    <label>Nome:</label>
                    <input type="text" name="name" class="form-control" placeholder="nome">
                </div>
                <div class="form-group">
                    <label>Usuário:</label>
                    <input type="text" name="usuario" class="form-control " placeholder="usuario">
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" placeholder="email">
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="text" name="password" class="form-control" placeholder="password">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>RG:</label>
                            <input type="text" name="rg" class="form-control" placeholder="rg">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>CPF:</label>
                            <input type="text" name="cpf" class="form-control" placeholder="cpf">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>CNPJ:</label>
                            <input type="text" name="cnpj" class="form-control" placeholder="cnpj">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Grupo:</label>
                            <select name="grupo" class="custom-select">
                                <option value="">Selecionar...</option>
                                <option value="1">Monitoramento</option>
                                <option value="2">Comercial</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Empresa:</label>
                            <select name="empresa" class="custom-select">
                                <option value="">Selecionar...</option>
                                <option value="1">Monitoramento</option>
                                <option value="2">Comercial</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Ativo:</label>
                            <select name="ativo" class="custom-select ">
                                <option value="">Selecionar...</option>
                                <option value="on">Sim</option>
                                <option value="off">Não</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value="Editar">
            </div>
        </form>
    </div>
@endsection
