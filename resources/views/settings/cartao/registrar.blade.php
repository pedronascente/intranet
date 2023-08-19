@extends('layouts.app')
@section('content')
    <div class="card card-default">
        <div class="card-header">
            <h4>Registrar Cartão Token</h4>
        </div>
        <form action="{{ route('cartao.register') }}" method="POST" name="formulario-cartao-register">
            @csrf
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
                            <input type="text" name="user_id" value="{{ $usuario->name }}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>QTD. de Tokens:</label>
                            <select name="qtdToken" class="custom-select @error('qtdToken') is-invalid @enderror">
                                <option value="">...</option>
                                @for ($i = 1; $i <= 40; $i++)
                                    <option value="{{ $i }}" @if (old('qtdToken') == $i) selected @endif>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('qtdToken')
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
            </div>
        </form>
    </div>
@endsection
