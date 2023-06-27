@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Ativo:</label>
                            <select name="ativo" class="custom-select">
                                <option value="on" @if (old('ativo') == 'on') selected @endif>
                                    Sim</option>
                                <option value="off" @if (old('ativo') == 'off') selected @endif>
                                    Não</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Usuário:</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="name" value="{{ old('name') }}">
                            @error('name')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Senha:</label>
                            <input type="text" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="password"
                                value="{{ old('password') }}">
                            @error('password')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Confirma senha:</label>
                            <input type="text" name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="password_confirmation" value="{{ old('password_confirmation') }}">
                            @error('password_confirmation')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i>Dicas para uma boa senha!</h5>
                            <ul>
                                <li>deve ter pelo menos 6 caracteres: [ min:6 ]</li>
                                <li>deve conter pelo menos uma letra minúscula: [a-z]</li>
                                <li>deve conter pelo menos uma letra maiúscula: [A-Z]</li>
                                <li>deve conter pelo menos um dígito: [0-9]</li>
                                <li>deve conter um caractere especial:[@$!%*#?&]</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="email" value="{{ old('email') }}">
                            @error('email')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Grupo:</label>
                            <select name="grupo" class="custom-select @error('grupo') is-invalid @enderror">
                                <option value="">Selecione...</option>
                                @if ($grupos)
                                    @foreach ($grupos as $item)
                                        <option value="{{ $item->id }}"
                                            @if (old('grupo')) selected @endif>
                                            {{ $item->nome }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('grupo')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value="Salvar">
            </div>
        </form>
    </div>
@endsection
