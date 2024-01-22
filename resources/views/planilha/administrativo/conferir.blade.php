@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('comissao.administrativo.index') }}">Planilha</a>
        </li>
    </ol>
@endsection

@section('content')

<div class="card p-3">  
    <div class="card">  
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('comissao.administrativo.arquivo.index') }}" class="btn btn-sm btn-info ">
                    <i class="fas fa-folder"></i> Arquivos
                </a>
                <a href="{{ route('comissao.administrativo.relatorio') }}" class="btn btn-sm btn-info ">
                    <i class="fas fa-folder"></i> Relatorio
                </a>
            </div>    
        </div>
    </div>
    </div>
    <div class="card">  
        <div class="card-header">
             <x-filtro-form-planilha :route="route('comissao.administrativo.index')" />
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ano</th>
                            <th>Periodo</th>
                            <th>Colaborador</th>
                            <th>Empresa</th>
                            <th>Planilha</th>
                            <th>Comissão</th>
                            <th>Status</th>
                            <th width="5%" class="text-center">Permissões</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($collections)
                            @foreach ($collections as $item)
                                @php
                                    $valorTotalComissao = app('App\Http\Controllers\Planilha\AdministrativoController')->getValorTotalComissao($item);
                                @endphp
                                <tr class="{{ $item->status->status === 'Recuperado' ? 'bg-warning' : '' }}">
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->ano }}</td>
                                    <td>{{ $item->periodo->nome }}</td>
                                    <td>{{ $item->colaborador->nome }}</td>
                                    <td>{{ $item->colaborador->empresa->nome }}</td>
                                    <td>{{ $item->tipo->nome }}</td>
                                    <td>R$ {{ $valorTotalComissao }}</td>
                                    </td>
                                    <td>{{ $item->status->status }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('comissao.administrativo.reprovar', $item->id) }}"
                                            class="btn btn-danger btn-sm" title="Editar Planilha">
                                            <i class="nav-icon fas fa-edit"></i> Reprovar
                                        </a>
                                        <a href="{{ route('comissao.administrativo.tipoAdministrativo.index', $item->id) }}"
                                            class="btn btn-primary btn-sm" title="Conissão">
                                            <i class="fas fa-folder"></i> Visualizar
                                        </a>
                                        <a href="{{ route('comissao.administrativo.imprimirPDF', $item->id) }}"
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
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                        @if (@isset($collections))
                    {!! $collections->links() !!}
                    @endif
                </div>
            </div>
        </div>        
    </div>
</div>    
@endsection