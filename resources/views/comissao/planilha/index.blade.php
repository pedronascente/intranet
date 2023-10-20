@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Planilhas </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="/comissao/planilha">Planilhas</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <div class="card-header">
            <h3>
                <a href="{{ route('planilha.create') }}" class="btn btn-primary">
                    <i class="fas fa-solid fa-plus"></i> Planilha
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ano</th>
                        <th>Periodo</th>
                        <th>Colaborador</th>
                        <th>Empresa</th>
                        <th>Status</th>
                        <th>Planilha</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collections)
                        @foreach ($collections as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->ano }}</td>
                                <td>{{ $item->periodo->nome }}</td>
                                <td>{{ $item->colaborador->nome }}</td>
                                <td>{{ $item->colaborador->empresa->nome }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->tipoPlanilha->nome }}</td>
                                <td class="text-center">
                                    <a href="{{ route('planilha.edit', $item->id, 'edit') }}" class="btn btn-primary"
                                        title="Editar Planilha">
                                        <i class="nav-icon fas fa-edit"></i> Editar
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal"
                                        data-target="#deleteModal" data-id="{{ $item->id }}" title="Excluir Planilha">
                                        <i class="fas fa-trash"></i> Excluir
                                    </a>
                                    <a href="{{ route('comissao.addcomissao', $item->id) }}" class="btn btn-primary"
                                        title="Conissão">
                                        <i class="fas fa-solid fa-plus"></i> Comissão
                                    </a>
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
    <x-ui.modalDelete modulo="planilha" />
@endsection
