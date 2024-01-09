@extends('layouts.app')

@section('titulo', 'Permissão | Cadastrar')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
           <a href="/configuracoes">Configurações</a> /
           <a href="/configuracoes/permissao">permissão</a>
        </li>
    </ol>
@endsection
@section('content')
    <div class="card p-3">
        <form action="{{ route('permissao.store') }}" method="POST" name="Formulario-permissao-create">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nome:</label>
                            <input type="text" name="nome" class="form-control  @error('nome') is-invalid  @enderror"
                                placeholder="nome">
                            @error('nome')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <x-botao.btn-salvar />
                <a href="{{ route('permissao.index') }}" title="Voltar" class="btn btn-sm btn-danger">
                    <i class="fa fa-reply"></i> Voltar
                </a>
            </div>
        </form>
    </div>
@endsection
