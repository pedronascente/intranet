@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('condominoController.index') }}">Condominio</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">    
        <div class="card">
            <form action="{{ route('condominoController.update',$condominio->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <h3>Contato</h3>
                    <div class="form-group">
                        <label>Condomínio:</label>
                        <input type="text" name="condominio" maxlength="190"
                            class="form-control @error('condominio') is-invalid  @enderror" placeholder="Condomínio"
                            value="{{ $condominio->condominio }}">
                        @error('condominio')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <h3>Régua</h3>
                    <div class="form-group">
                        <label>IP:</label>
                        <input type="ip" name="ip" maxlength="30"
                            class="form-control @error('ip') is-invalid  @enderror" placeholder="IP"
                            value="{{ $condominio->regua->ip }}">
                        @error('ip')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Usuário:</label>
                        <input type="text" name="usuario" maxlength="190"
                            class="form-control @error('usuario') is-invalid  @enderror" placeholder="Usuário"
                             value="{{ $condominio->regua->usuario }}">
                        @error('usuario')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Senha:</label>
                        <input type="text" name="senha" maxlength="190"
                            class="form-control @error('senha') is-invalid  @enderror" placeholder="Senha"
                          value="{{ $condominio->regua->senha }}">
                        @error('senha')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                   </div>
                <div class="card-footer">
                    <x-botao.btn-salvar />
                    <x-botao.btn-voltar :rota="route('condominoController.index')" />
                </div>
            </form>
        </div>
    </div>
@endsection