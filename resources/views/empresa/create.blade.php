@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <form action="{{ route('empresa.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control @error('nome') is-invalid  @enderror"
                        placeholder="Nome">
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
