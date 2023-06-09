@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <form action="{{ route('usuario.update', $usuario->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <a href="/colaborador" title="Pesquisar cód. colaborador.">
                                <label> CÓD Colaborador:</label>
                            </a>
                            <input type="text" name="colaborador_id"
                                class="form-control @error('colaborador_id') is-invalid @enderror"
                                placeholder="Informe o cód." value="{{ $usuario->colaborador->id }}">
                            @error('colaborador_id')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Status:</label>
                            <select name="ativo" class="custom-select">
                                <option value="on" @if ($usuario->ativo == 'on') selected @endif> Sim</option>
                                <option value="off" @if ($usuario->ativo == 'off') selected @endif> Não</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Usuário:</label>
                            <input type="text" name="usuario" class="form-control @error('usuario') is-invalid @enderror"
                                placeholder="usuario" value="{{ $usuario->usuario }}">
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
                                value="{{ $usuario->password }}">
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
                                placeholder="email" value="{{ $usuario->email }}">
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
                            <select name="grupo_id" class="custom-select @error('grupo_id') is-invalid @enderror">
                                @foreach ($collection_grupo as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $usuario->grupo_id) selected @endif>
                                        {{ $item->nome }}</option>
                                @endforeach
                            </select>
                            @error('grupo')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value="Editar">
            </div>
        </form>
    </div>
@endsection
