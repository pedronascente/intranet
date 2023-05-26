@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <form action="{{ route('empresa.update', $empresa->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control   @error('nome') is-invalid  @enderror"
                        placeholder="Enter Empresa" value="{{ $empresa->nome }}">
                    @error('nome')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
@endsection
