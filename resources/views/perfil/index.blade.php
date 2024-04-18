@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('perfil.index') }}">Perfil</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card-header">
            <h3>
                <x-botao.btn-cadastrar :rota="route('perfil.create')"  :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />   
            </h3>
        </div>
        @if (in_array('Listar',$arrayListPermissoesDoModuloDaRota))
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap  table-striped">
                        <thead>
                            <tr>
                                <th>Perfil</th>
                                <th>Descrição</th>
                                <th width="5%" class="text-center">Permissões</th>
                            </tr>
                        </thead>
                        <tbody> 
                            @if ($arrayListPerfil) 
                                @foreach ($arrayListPerfil as $item)
                                    <tr>
                                        <td>{{ $item->nome }}</td>
                                        <td>{{ $item->descricao }}</td>
                                        <td class="text-center">
                                            <x-botao.btn-editar :rota="route('perfil.edit', $item->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                            <x-botao.btn-excluir :rota="route('perfil.destroy', $item->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
