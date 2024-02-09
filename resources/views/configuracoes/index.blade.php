@extends('layouts.app')

@section('titulo', "Configurações")

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes">Configurações</a> /
            <a href="/">Home</a>
        </li>
    </ol>
@endsection 
@section('content')
    <div class="card p-3">
        <div class="header">
            <i class="nav-icon fa fa-cog" aria-hidden="true"></i> Menu de Configurações
        </div>
        <div class="card-body">
            @php
                $modulosDoUsuarioAutenticadoId = session()->get('modulosDoUsuarioAutenticadoId');
                $categoriasDoUsuarioAutenticadoNome = session()->get('categoriasDoUsuarioAutenticadoNome');
            @endphp
            @if ($ModuloCategoria)
                @foreach ($ModuloCategoria as $categoria)
                    @if(in_array($categoria->nome,$categoriasDoUsuarioAutenticadoNome))
                        <ul>    
                            <li>
                            {{  $categoria->nome }}
                                <ul>
                                    @foreach ( $categoria->modulos as $modulo)
                                        @if (in_array($modulo->id, $modulosDoUsuarioAutenticadoId))
                                            <li >
                                                <a href="{{ $modulo->rota }}">{{ $modulo->nome}}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
@endsection

