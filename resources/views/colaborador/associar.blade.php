@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <form action="{{ route('update_associar', $colaborador->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas fa-exclamation-triangle"></i>Selecione um usuário abaixo, para ser associado!
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Usuário:</label>
                            <select name="user_id" class="custom-select @error('user_id') is-invalid @enderror">
                                <option value="">...</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}" @if (old('user_id') == $item->id) selected @endif>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Colaborador:</label>
                            <input type="text" name="nome" maxlength="190"
                                class="form-control @error('nome') is-invalid  @enderror" placeholder="Nome"
                                value="{{ $colaborador->nome }} {{ $colaborador->sobrenome }}" disabled>
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
                    Salvar</button>
            </div>
        </form>
    </div>
@endsection
