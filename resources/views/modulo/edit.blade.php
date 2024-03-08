@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes/modulo">Módulo</a> 
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
                        <label>Categoria:</label>
                        <select name="modulo_categoria_id" class="custom-select @error('modulo_categoria_id') is-invalid  @enderror">
                            <option value="">...</option>
                            @if($modulo_categorias)
                                @foreach ( $modulo_categorias as $categoria)
                                   <option value="{{ $categoria->id }}" @if( $categoria->id == $modulo->categoria->id) selected @endif >
                                       {{ $categoria->nome }}  
                                   </option>             
                                @endforeach
                            @endif
                        </select>
                        @error('modulo_categoria_id')
                            <span class=" invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Posição do menu:</label>
                        <select name="modulo_posicao_id" class="custom-select  @error('modulo_posicao_id') is-invalid  @enderror">
                            <option value="">...</option>
                            @if($modulo_posicoes)
                                @foreach ( $modulo_posicoes as $posicao)
                                   <option value="{{ $posicao->id }}" @if($posicao->id ==$modulo->posicao->id ) selected @endif>
                                       {{ $posicao->nome }}  
                                   </option>             
                                @endforeach
                            @endif
                        </select>
                        @error('modulo_posicao_id')
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
