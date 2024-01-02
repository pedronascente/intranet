@extends('layouts.app')

@section('titulo', $titulo)

@section('content')
    <div class="card p-3">
        <div class="card-header table-responsive">
            <x-filtro-form-planilha :route="route('planilha-administrativo.filtro', 'arquivado')" />
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
                        <th>Comissão</th>
                        <th>Status</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collections)
                        @foreach ($collections as $item)
                            @php
                                $valorTotalComissao = app('App\Http\Controllers\Planilha\PlanlhaAdministrativoController')->getValorTotalComissao($item);
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
