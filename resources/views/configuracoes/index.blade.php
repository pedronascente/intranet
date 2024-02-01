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
            @if ($ModuloCategoria)
                @foreach ($ModuloCategoria as $categoria)
                    <ul>
                        <li> {{  $categoria->nome}}
                            <ul>
                                @foreach ( $categoria->modulos as $modulo)
                                    <li>
                                        <a href="{{  $modulo->rota  }}">{{ $modulo->nome }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                @endforeach
            @endif   
        </div>
    </div>
@endsection
