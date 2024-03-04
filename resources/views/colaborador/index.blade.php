@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
           <a href="/configuracoes">Configurações</a> /
           <a href="{{ route('colaborador.index') }}">colaborador</a>
        </li>
    </ol>
@endsection 

@section('content')
    <div class="card p-3">
        <div class="card-header">
            <h3>
                <x-botao.btn-cadastrar :rota="route('colaborador.create')"  :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />   
            </h3>
        </div>
        @if (in_array('Listar',$arrayListPermissoesDoModuloDaRota))
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-striped">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="10%">Foto</th>
                                <th>Colaborador</th>
                                <th> Matricula</th>
                                <th width="5%" class="text-center">Permissões</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($arrayListDeColaboradores)
                                @foreach ($arrayListDeColaboradores as $item)
                                    <tr>
                                    <td>{{ $item->id }}</td>
                                        <td>
                                            <a href="{{ route('colaborador.show', $item->id) }}" title="Visualizar">
                                                <img src="{{ asset('img/colaborador/' . $item->foto . '') }}"
                                                    alt="{{ $item->nome }}" width="50" class="rounded-circle">
                                            </a>
                                        </td>
                                        <td>{{ $item->nome }}</td>
                                        <td>{{ $item->numero_matricula }}</td>
                                        <td class="text-center">
                                            <x-botao.btn-visualizar :rota="route('colaborador.show', $item->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                            <x-botao.btn-editar :rota="route('colaborador.edit', $item->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                            <x-botao.btn-excluir :rota="route('colaborador.destroy', $item->id)"  :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    @if (@isset($arrayListDeColaboradores))
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
                                {!! $arrayListDeColaboradores->links() !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
         @endif
    </div>
    <x-ui.modalDelete />
@endsection