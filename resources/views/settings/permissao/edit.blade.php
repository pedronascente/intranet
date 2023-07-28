@extends('layouts.app')
@section('content')
    <div class="card card-default">
        <div class="card-header">
            <h4>Editar</h4>
        </div>
        <form action="{{ route('permissao.update', $permissao->id) }}" method="POST" name="Formulario-permissao-edit">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" name="nome" class="form-control @error('nome') is-invalid  @enderror"
                        placeholder="nome" value="{{ $permissao->nome }}">
                    @error('nome')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn bg-gradient-primary">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    Salvar</button>
            </div>
        </form>
    </div>
@endsection
