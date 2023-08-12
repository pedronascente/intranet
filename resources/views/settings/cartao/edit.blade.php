@extends('layouts.iframe')
@section('content')
    <div class="card">
        <form action="{{ route('cartao.update', $cartao->id) }}" method="POST" name="formulario-cartao-update">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group @error('status') is-invalid   @enderror">
                            <label>Status :</label>
                            <select name="status"class="custom-select rounded-0">
                                <option value="on" @if ($cartao->status == 'on') selected @endif> Ativo</option>
                                <option value="off" @if ($cartao->status == 'off') selected @endif> Inativo</option>
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
                            <input type="text" name="user_id" value="{{ $cartao->user->name }}" class="form-control"
                                disabled>
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
                                    <option value="{{ $i }}" @if (old('qtdToken') == $i) selected @endif
                                        @if ($cartao->qtdToken == $i) selected @endif>
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
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" name="resetToken" class="form-check-input" id="resetToken"
                                value="on">
                            <label class="form-check-label" for="resetToken">Resetar Token</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn bg-gradient-primary">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    Editar</button>
            </div>
        </form>
    </div>
@endsection
