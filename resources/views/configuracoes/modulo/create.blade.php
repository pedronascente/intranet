@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Módulo | Cadastrar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/configuracoes">Configurações/</a>módulo</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card card-default">
        <form action="{{ route('modulo.store') }}" method="POST" name="Formulario-modulo-create">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" name="nome" class="form-control  @error('nome') is-invalid  @enderror"
                        placeholder="nome" value="{{ old('nome') }}">
                    @error('nome')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Rota:</label>
                    <input type="text" name="rota" class="form-control  @error('rota') is-invalid  @enderror"
                        placeholder="http://" value="{{ old('rota') }}">
                    @error('nome')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Descrição:</label>
                    <textarea type="text" name="descricao" rows="5" class="form-control  @error('descricao') is-invalid  @enderror"
                        placeholder="Escreva uma Descrição">{{ old('descricao') }}</textarea>
                    @error('descricao')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn bg-gradient-primary">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    Salvar
                </button>
                <a href="{{ route('modulo.index') }}" title="Voltar" class="btn btn-danger">
                    <i class="fa fa-reply"></i> Voltar
                </a>
            </div>
        </form>
    </div>
@endsection
