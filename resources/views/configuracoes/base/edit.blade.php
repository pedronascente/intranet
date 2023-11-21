@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Base | Editar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="/configuracoes">Configurações</a> /
                            <a href="/configuracoes/base">base</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
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
                <button type="submit" class="btn bg-gradient-primary">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    Salvar
                </button>
                <a href="{{ route('base.index') }}" title="Voltar" class="btn btn-danger">
                    <i class="fa fa-reply"></i> Voltar
                </a>
            </div>
        </form>
    </div>
@endsection
