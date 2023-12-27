@extends('layouts.app')

@section('titulo', $titulo)

@section('content')
    <div class="card">
        <div class="card-header table-responsive">
            @include('planilha.administrativo.form-fitro')
        </div>
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
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collections)
                        @foreach ($collections as $item)
                            <tr class="{{ $item->status->status === 'Recuperado' ? 'bg-warning' : '' }}">
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->ano }}</td>
                                <td>{{ $item->periodo->nome }}</td>
                                <td>{{ $item->colaborador->nome }}</td>
                                <td>{{ $item->colaborador->empresa->nome }}</td>
                                <td>{{ $item->tipo->nome }}</td>
                                <td>{{ $item->status->status }}</td>
                                <td class="text-center">
                                    <a href="{{ route('planilha-administrativo.reprovar', $item->id) }}"
                                        class="btn btn-danger btn-sm" title="Editar Planilha">
                                        <i class="nav-icon fas fa-edit"></i> Reprovar
                                    </a>
                                    <a href="{{ route('planilha-administrativo-tipo.index', $item->id) }}"
                                        class="btn btn-primary btn-sm" title="Conissão">
                                        <i class="fas fa-folder"></i> Visualizar
                                    </a>
                                    <a href="{{ route('planilha-administrativo.imprimirPDF', $item->id) }}"
                                        class="btn btn-success btn-sm" title="Imprimir-planilha" target="_blank">
                                        <i class="nav-icon fas fa-print"></i> Imprimir
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
@endsection
