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
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap table-striped">
                    <thead>
                        <tr>
                            <th><i class="nav-icon fa fa-cog" aria-hidden="true"></i> Menu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (session()->get('usuarioAutenticado')->perfil->modulos)
                            @foreach (session()->get('usuarioAutenticado')->perfil->modulos as $modulo)
                                @if ($modulo->tipo_menu=="menu-configuracao")
                                    <tr>
                                        <td>
                                            <a href="{{ $modulo->rota }}">
                                                {{ $modulo->nome }}
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
