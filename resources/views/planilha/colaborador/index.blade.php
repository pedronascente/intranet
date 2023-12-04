@extends('layouts.app')

@section('titulo', $titulo)

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>
                <a href="{{ route('planilha.create') }}" class="btn btn-primary  btn-sm" title="Cadastrar nova Planilha">
                    <i class="fas fa-solid fa-plus"></i> Planilha
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Colaborador</th>
                        <th>Empresa</th>
                        <th>Comissão</th>
                        <th>Planilha</th>
                        <th>Periodo</th>
                        <th>Ano</th>
                        <th>Status</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collections)
                        @foreach ($collections as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->colaborador->nome }}</td>
                                <td>{{ $item->colaborador->empresa->nome }}</td>
                                <td>R$</td>
                                <td>{{ $item->tipo->nome }}</td>
                                <td>{{ $item->periodo->nome }}</td>
                                <td>{{ $item->ano }}</td>
                                <td>{{ $item->status->status }}</td>
                                <td class="text-center">
                                    <a href="{{ route('planilha.edit', $item->id, 'edit') }}" class="btn btn-info btn-sm"
                                        title="Editar Planilha">
                                        <i class="nav-icon fas fa-edit"></i> Editar
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#deleteModal" data-route="{{ route('planilha.destroy', $item->id) }}"
                                        title="Excluir Planilha">
                                        <i class="fas fa-trash"></i> Excluir
                                    </a>
                                    <a href="{{ route('comissao.index', $item->id) }}" class="btn btn-primary btn-sm"
                                        title="Cadastrar Comissão">
                                        <i class="fas fa-solid fa-plus"></i> Comissão
                                    </a>
                                    <a href="{{ route('planilha.homologar', $item->id, 'edit') }}"
                                        class="btn btn-success btn-sm" title="Lançar Planilha">
                                        Homologar
                                    </a </td>
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
    <x-ui.modalDelete />
@endsection
