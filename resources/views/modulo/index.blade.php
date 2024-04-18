@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('modulo.index') }}">Módulos</a> 
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card-header">
            <h3>
                <x-botao.btn-cadastrar :rota="route('modulo.create')"  :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />   
            </h3>
        </div>
        @if (in_array('Listar',$arrayListPermissoesDoModuloDaRota))
            <div class="card">
                <div class="card-header table-responsive">
                    <x-search-form />
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-striped">
                        <thead>
                            <tr>
                                <th>Módulo</th>
                                <th>Categoria</th>
                                <th>Posição do menu</th>
                                <th>slug</th>
                                <th>Descrição</th>
                                <th width="5%" class="text-center">Permissões</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($arrayListModulo)
                                @foreach ($arrayListModulo as $item)
                                    <tr>
                                        <td>{{ $item->nome }}</td>
                                        <td>{{ $item->categoria->nome }}</td>
                                        <td>{{ $item->posicao->nome }}</td>
                                        <td>{{ $item->slug }}</td>
                                        <td>{{ $item->descricao }}</td>
                                        <td class="text-center">
                                            <x-botao.btn-editar :rota="route('modulo.edit', $item->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                            <x-botao.btn-excluir :rota="route('modulo.destroy', $item->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row text-center">
                        <div class="col-md-6">
                            {!! $arrayListModulo->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection