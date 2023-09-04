@extends('layouts.app')
@section('content')
    <div class="card card-default">
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Status:</label>
                            <select name="status" class="custom-select">
                                <option value="on" @if (old('status') == 'on') selected @endif>
                                    Sim</option>
                                <option value="off" @if (old('status') == 'off') selected @endif>
                                    Não</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Perfil:</label>
                            <select name="perfil" class="custom-select @error('perfil') is-invalid @enderror">
                                <option value="">Selecione...</option>
                                @if ($perfis)
                                    @foreach ($perfis as $item)
                                        <option value="{{ $item->id }}"
                                            @if (old('perfil')) selected @endif>
                                            {{ $item->nome }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('perfil')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Usuário:</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Nome" value="{{ old('name') }}">
                            @error('name')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Senha:</label>
                            <input type="text" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="senha"
                                value="{{ old('password') }}">
                            @error('password')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Confirma senha:</label>
                            <input type="text" name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="confirmar senha" value="{{ old('password_confirmation') }}">
                            @error('password_confirmation')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <x-ui.panel-dica-boa-senha />
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