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
            <form action="{{ route('comissao.administrativo.relatorio') }}" method="get">
                <div class=" col-md-12">
                    <div class="row">                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status:</label>
                                <select name="status" class="form-control">
                                    <option value="todos">Todos</option>
                                    @if ($arayLisStatus)
                                        @foreach ($arayLisStatus as $status)
                                             <option value="{{  $status->id }}">{{  $status->status }}</option>
                                        @endforeach
                                     @endif   
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Periodo:</label>
                                <input type="text" name="data_inicial" class="form-control  " data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" value="" maxlength="10">
                            </div>
                        </div>                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Até:</label>
                                <input type="text" name="data_final" class="form-control  " data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" value="" maxlength="10">
                            </div>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" name="filtro" class="form-control form-control-lg" value="{{ request('filtro') }}"
                                    placeholder="Pesquisar por">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-lg btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div> 
        <div class="card-body">
            <div class="table-responsive ">
                <table class="table table-hover table-bordered  text-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>data</th>
                            <th>Periodo</th>
                            <th>Cliente</th>
                            <th>Colaborador</th>
                            <th>Planilha</th>
                            <th>Conta / Pedido</th>
                            <th>Número OS</th>
                            <th>Placa</th>
                            <th>Serviço</th>
                            <th>Comissão</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            // dd($collection);
                        @endphp
                          @if($collection)
                            @foreach ($collection as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->data)->format('d/m/Y') }}</td>
                                    <td>{{ $item->periodo }}</td>
                                    <td>{{ $item->cliente }}</td>
                                    <td>{{ $item->colaborador }}</td>
                                    <td>{{ $item->planilha }}</td>
                                    <td>{{ $item->conta_pedido }}</td>
                                    <td>{{ $item->numero_os }}</td>
                                    <td>{{ $item->placa }}</td>
                                    <td>{{ $item->servico }}</td>
                                    <td>{{ $item->comissao }}</td>     
                                    <td>{{ $item->status }}</td>     
                                </tr>             
                            @endforeach
                          @endif 
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            @if (@isset($collection))
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        {!! $collection->links() !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
