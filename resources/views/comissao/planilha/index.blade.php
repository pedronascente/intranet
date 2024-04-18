@extends('layouts.app')

@section('titulo', $titulo)

@section('content')
    
<div class="card p-3">
    <div class="card-header">
        <h3>
            <x-botao.btn-cadastrar :rota="route('planilha.create')"  :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota"  />
        </h3>
    </div>
    <div class="card">
        @if (in_array('Listar',$arrayListPermissoesDoModuloDaRota))
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered text-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ano</th>
                            <th>Periodo</th>
                            <th>Colaborador</th>
                            <th>Empresa</th>
                            <th>Planilha</th>
                            <th>Status</th>
                            <th>Observação</th>
                            <th width="5%" class="text-center">Permissões</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($arrayListPlanilha)
                            @foreach ($arrayListPlanilha as $item)
                                <tr @if ($item->status->status == 'Reprovado') style="color:red" @endif>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->ano }}</td>
                                    <td>{{ $item->periodo->nome }}</td>
                                    <td>{{ $item->colaborador->nome }}</td>
                                    <td>{{ $item->colaborador->empresa->nome }}</td>
                                    <td>{{ $item->tipo->nome }}</td>
                                    <td>{{ $item->status->status }}</td>
                                    <td style="max-width:400px">
                                        <div style=" margin: 0;padding:0; white-space:normal ;">
                                            {{ $item->motivo_reprovacao }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <x-botao.btn-editar :rota="route('planilha.edit', $item->id)"  :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota"/>
                                        <x-botao.btn-cadastrar-comissao :rota="route('planilha-colaborador-tipo.index', $item->id)"/>
                                        <x-botao.btn-homologar-planilha :rota="route('planilha.homologar', $item->id, 'edit') "/>
                                        <x-botao.btn-excluir :rota="route('planilha.destroy', $item->id)"  :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota"/>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @if (@isset($arrayListPlanilha))
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            {!! $arrayListPlanilha->links() !!}
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>    
@endsection
