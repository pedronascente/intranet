@extends('layouts.app')

@section('titulo', $titulo)

@section('content')
    
<div class="card p-3">
    <div class="card-header">
        <h3>
            <a href="{{ route('planilha.create') }}" class="btn btn-primary  btn-sm"
                title="Criar Planilha">
                <i class="fas fa-solid fa-plus"></i> Planilha
            </a>
        </h3>
    </div>
    <div class="card">
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
                    @if ($collections)
                        @foreach ($collections as $item)
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
                                    <x-botao.btn-editar :rota="route('planilha.edit', $item->id)"/>
                                    <a href="{{ route('planilha-colaborador-tipo.index', $item->id) }}"
                                        class="btn btn-primary btn-sm" title="Gerenciar Comissão">
                                        <i class="fas fa-solid fa-plus"></i> Comissão
                                    </a>
                                    <a href="{{ route('planilha.homologar', $item->id, 'edit') }}"
                                        class="btn btn-success btn-sm" title="Lançar Planilha">
                                        Homologar
                                    </a>
                                    <x-botao.btn-excluir :rota="route('planilha.destroy', $item->id)" titulo="Excluir Comissão" />
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if (@isset($collections))
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        {!! $collections->links() !!}
                    </div>
                </div>
            @endif
         </div>
    </div>
</div>    
    <x-ui.modalDelete />
@endsection
