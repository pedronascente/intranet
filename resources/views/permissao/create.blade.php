@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
           <a href="{{ route('permissao.index') }}">Permissão</a>
        </li>
    </ol>
@endsection
@section('content')
    <div class="card p-3">
        <div class="card">
            <form action="{{ route('permissao.store') }}" method="POST">
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
                    <x-botao.btn-voltar :rota="route('permissao.index')" />
                </div>
            </form>
        </div>
    </div>
@endsection
