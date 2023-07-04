@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <form action="{{ route('cartao.update', 3) }}" method="POST" name="formulario-cartao-update">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group @error('status') is-invalid   @enderror">
                            <label>Status :</label>
                            <select name="status"class="custom-select rounded-0">
                                <option value="on" seleted> Ativo</option>
                                <option value="off"> Inativo</option>
                            </select>
                            @error('status')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
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
