@extends('layouts.app')

@section('titulo', 'Empresa')
 
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes">Configurações</a> /
            <a href="{{ route('empresa.index') }}">empresa</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card-header">
            <h3>
                <x-botao.btn-cadastrar :rota="route('empresa.create')"  :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />   
            </h3>
        </div>
        @if (in_array('Listar',$arrayListPermissoesDoModuloDaRota))
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-striped">
                        <thead>
                            <tr>
                                <th>Empresa</th>
                                <th>Cnpj</th>
                                <th>Logo</th>
                                <th width="5%" class="text-center">Permissões</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($arrayListEmpresa)
                                @foreach ($arrayListEmpresa as $item)
                                    <tr>
                                        <td>{{ $item->nome }}</td>
                                        <td>{{ $item->cnpj }}</td>
                                        <td><img src="{{ asset('/img/empresa/' . $item->imglogo) }}" width="100"></td>
                                        <td class="text-center">
                                            <x-botao.btn-editar :rota="route('empresa.edit', $item->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                            <x-botao.btn-excluir :rota="route('empresa.destroy', $item->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-7">
                            {!! $arrayListEmpresa->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <x-ui.modalDelete />
@endsection