@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cargo | Cadastrar </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="/configuracoes">Configurações</a> /
                            <a href="/configuracoes/cargo">cargos</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card card-default">
        <form action="{{ route('cargo.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" name="nome" class="form-control @error('nome') is-invalid  @enderror"
                        placeholder="Nome">
                    @error('nome')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn bg-gradient-primary">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    Salvar
                </button>
                <a href="{{ route('cargo.index') }}" title="Voltar" class="btn btn-danger">
                    <i class="fa fa-reply"></i> Voltar
                </a>
            </div>
        </form>
    </div>
@endsection
