@extends('layouts.app')

@section('titulo', $titulo)

@section('content')

    <div class="card">
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
                                <td>R$ 9999</td>
                                <td>{{ $item->tipo->nome }}</td>
                                <td>{{ $item->periodo->nome }}</td>
                                <td>{{ $item->ano }}</td>
                                <td>{{ $item->status->status }}</td>
                                <td class="text-center">
                                    <a href="{{ route('planilha.administrativo.edit', $item->id, 'edit') }}"
                                        class="btn btn-info btn-sm" title="Editar Planilha">
                                        <i class="nav-icon fas fa-edit"></i> Editar
                                    </a>
                                    <a href="{{ route('planilha.administrativo.visualizar', $item->id) }}"
                                        class="btn btn-primary btn-sm" title="Conissão">
                                        <i class="fas fa-folder">
                                        </i> Visualizar
                                    </a>
                                    <a href="" class="btn btn-danger  btn-sm" title="Conissão">
                                        Imprimir
                                    </a>
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
@endsection
