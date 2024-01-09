@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('planilha-administrativo.arquivado') }}">Planilha</a>
        </li>
    </ol>
@endsection

@section('content')
  <div class="card p-3">
    <div class="card">
        <div class="card-header">
            <x-filtro-form-planilha :route="route('planilha-administrativo.filtro', 'arquivado')" />
        </div> 
        <div class="card-body">
            <div class="table-responsive ">
                <table class="table table-hover table-bordered  text-nowrap table-striped">
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
                                    $valorTotalComissao = app('App\Http\Controllers\Planilha\PlanilhaAdministrativoController')->getValorTotalComissao($item);
                                @endphp
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->ano }}</td>
                                    <td>{{ $item->periodo->nome }}</td>
                                    <td>{{ $item->colaborador->nome }}</td>
                                    <td>{{ $item->colaborador->empresa->nome }}</td>
                                    <td>{{ $item->tipo->nome }}</td>
                                    <td>R$ {{ $valorTotalComissao }}</td>
                                    <td>{{ $item->status->status }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('planilha-administrativo.recuperar', $item->id) }}"
                                            class="btn btn-primary btn-sm" title="Recuperar Planilha">
                                            Recuperar
                                        </a>
                                    </td>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
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
@endsection
