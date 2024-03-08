@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('usuario.index') }}">Usuário</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card">
            <form action="{{ route('usuario.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Id Colaborador:</label>
                                <input type="text" name="colaborador_id"
                                    class="form-control @error('colaborador_id') is-invalid @enderror"
                                    placeholder="Id " value="{{ old('colaborador_id') }}">
                                @error('colaborador_id')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Token:</label>
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Ativo:</label>
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
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="senha"
                                    value="{{ old('password') }}">
                                @error('password')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Confirma senha:</label>
                                <input type="password" name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    placeholder="confirmar senha" value="{{ old('password_confirmation') }}">
                                @error('password_confirmation')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <x-ui.panel-dica-boa-senha />
                        </div>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <x-botao.btn-salvar />
                    <x-botao.btn-voltar :rota="route('usuario.index')" />
                </div>
            </form>
        </div>
    </div>
@endsection