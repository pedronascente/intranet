@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <form action="{{ route('usuario.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <a href="/colaborador" class="" title="Pesquisar cód. colaborador.">
                                <label> CÓD Colaborador:</label>
                            </a>
                            <input type="text" name="colaborador_id"
                                class="form-control @error('colaborador_id') is-invalid @enderror"
                                placeholder="Informe o cód. " value="{{ old('colaborador_id') }}">
                            @error('colaborador_id')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Usuário:</label>
                            <input type="text" name="usuario" class="form-control @error('usuario') is-invalid @enderror"
                                placeholder="usuario" value="{{ old('usuario') }}">
                            @error('usuario')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="text" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="password"
                                value="{{ old('password') }}">
                            @error('password')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Grupo:</label>
                            <select name="grupo" class="custom-select @error('grupo') is-invalid @enderror">
                                <option value="">...</option>
                                <option value="1" @if (old('grupo') == '1') selected @endif>
                                    Monitoramento</option>
                                <option value="2" @if (old('grupo') == '2') selected @endif>
                                    Comercial</option>
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
