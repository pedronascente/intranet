@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('permissao.index') }}">Permissão</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card-header">
            <h3>
                <x-botao.btn-cadastrar :rota="route('permissao.create')"  :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />   
            </h3>
        </div>
        @if (in_array('Listar',$arrayListPermissoesDoModuloDaRota))
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th width="5%" class="text-center">Permissões</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($arrayListPermissao)
                                @foreach ($arrayListPermissao as $item)
                                    <tr>
                                        <td>{{ $item->nome }}</td>
                                        <td class="text-center">
                                            <x-botao.btn-editar :rota="route('permissao.edit', $item->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                            <x-botao.btn-excluir :rota="route('permissao.destroy', $item->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-7">
                            {!! $arrayListPermissao->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
