@extends('layouts.app')

@section('titulo', $titulo)

@section('content')
    <div class="card">
        <div class="card-header table-responsive">
            <form action="simple-results.html">
                <div class="input-group">
                    <input type="search" class="form-control form-control-lg" placeholder="Pesquisar por">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-lg btn-default">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-bordered  text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ano</th>
                        <th>Periodo</th>
                        <th>Colaborador</th>
                        <th>Empresa</th>
                        <th>Planilha</th>
                        <th>Status</th>
                        <th class="text-center">Permissões</th>
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
                                <td>{{ $item->tipo->nome }}</td>
                                <td>{{ $item->status->status }}</td>
                                <td class="text-center">
                                    <a href="{{ route('planilha-administrativo.edit', $item->id, 'edit') }}"
                                        class="btn btn-info btn-sm" title="Editar Planilha">
                                        <i class="nav-icon fas fa-edit"></i> Editar
                                    </a>
                                    <a href="{{ route('planilha-administrativo-tipo.index', $item->id) }}"
                                        class="btn btn-primary btn-sm" title="Conissão">
                                        <i class="fas fa-folder">
                                        </i> Visualizar
                                    </a>
                                    <a href="" class="btn btn-success btn-sm" title="Editar comissão">
                                        <i class="nav-icon fas fa-print"></i> Imprimir
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
