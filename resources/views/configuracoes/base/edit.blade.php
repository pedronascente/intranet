@extends('layouts.app')

@section('titulo', 'Base | Editar')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes">Configurações</a> /
            <a href="/configuracoes/base">base</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card">
            <form action="{{ route('base.update', $base->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nome:</label>
                                <input type="text" name="nome" maxlength="190"
                                    class="form-control @error('nome') is-invalid  @enderror" placeholder="Nome"
                                    value="{{ $base->nome }}">
                                @error('nome')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <x-botao.btn-salvar />
                    <x-botao.btn-voltar :rota="route('base.index')" />
                </div>
            </form>
        </div>
    </div>
@endsection
