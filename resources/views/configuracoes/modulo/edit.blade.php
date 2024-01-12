@extends('layouts.app')

@section('titulo', 'Módulo | Editar')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes">Configurações</a> 
            <a href="/configuracoes/modulo">modulo</a> 
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card">
            <form action="{{ route('modulo.update', $modulo->id) }}" method="POST" name="formulario-modulo-edit">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Posição do menu:</label>
                        <select name="tipo_menu" class="custom-select  @error('tipo_menu') is-invalid  @enderror">
                            <option value="">...</option>
                            <option value="menu-lateral" @if($modulo->tipo_menu == 'menu-lateral') selected @endif >Lateral Esquerdo</option>
                            <option value="menu-configuracao" @if($modulo->tipo_menu == 'menu-configuracao') selected @endif>Configurações</option>
                        </select>
                        @error('tipo_menu')
                            <span class=" invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Nome:</label>
                        <input type="text" name="nome" class="form-control @error('nome') is-invalid  @enderror"
                            placeholder="nome" value="{{ $modulo->nome }}">
                        @error('nome')
                            <span class=" invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Rota:</label>
                        <input type="text" name="rota" class="form-control @error('rota') is-invalid  @enderror"
                            placeholder="http://" value="{{ $modulo->rota }}">
                        @error('nome')
                            <span class=" invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Descrição:</label>
                        <textarea type="text" name="descricao" rows="5" class="form-control  @error('descricao') is-invalid  @enderror"
                            placeholder="Escreva uma Descrição">{{ $modulo->descricao }}</textarea>
                        @error('descricao')
                            <span class=" invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <x-botao.btn-salvar />              
                    <x-botao.btn-voltar :rota="route('modulo.index')" />
                </div>
            </form>
        </div>
    </div>
@endsection
