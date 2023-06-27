@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <form action="{{ route('modulo.store') }}" method="POST" name="Formulario-modulo-create">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control  @error('nome') is-invalid  @enderror"
                        placeholder="nome">
                    @error('nome')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Descrição</label>
                    <input type="text" name="descricao" class="form-control  @error('descricao') is-invalid  @enderror"
                        placeholder="Escreva uma Descrição">
                    @error('descricao')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn bg-gradient-success">Salvar</button>
            </div>
        </form>
    </div>
@endsection
