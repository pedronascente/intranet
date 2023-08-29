@extends('layouts.app')
@section('content')
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
                    Editar
                </button>
            </div>
        </form>
    </div>
@endsection
