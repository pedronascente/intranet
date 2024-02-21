@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes">Configurações</a> /
            <a href="{{ route('cargo.index') }}">cargos</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card-header">
            <h3>
                <x-botao.btn-cadastrar :rota="route('cargo.create')"  :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />   
            </h3>
        </div>
        @if (in_array('Listar',$arrayListPermissoesDoModuloDaRota))
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-striped">
                        <thead>
                            <tr>
                                <th>Cargo</th>
                                <th width="5%" class="text-center">Permissões</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (@isset($arrayListCargos))
                                @foreach ($arrayListCargos as $cargo)
                                    <tr>
                                        <td>{{ $cargo->nome }}</td>
                                        <td class="text-center">
                                            <x-botao.btn-editar :rota="route('cargo.edit', $cargo->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                            <x-botao.btn-excluir :rota="route('cargo.destroy', $cargo->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    @if (@isset($arrayListCargos))
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
                                {!! $arrayListCargos->links() !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
    <x-ui.modalDelete />
@endsection
