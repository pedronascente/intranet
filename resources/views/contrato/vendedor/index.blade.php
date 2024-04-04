@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('contrato.index') }}">Contrato</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card-header">
            <h3>
                <x-botao.btn-cadastrar :rota="route('contrato.create')"  :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />   
            </h3>
        </div>
       
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap  table-striped">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Cliente</th>
                                <th>Tipo</th>
                                <th>Vigência</th>
                                <th width="5%" class="text-center">Permissões</th>
                            </tr>
                        </thead>
                        <tbody> 
                             @for ($i = 1;$i < 10;$i++)
                                <tr>
                                  <td>0{{ $i }}/0{{ $i }}/2024</td>
                                  <td>Fulano de Tall</td>
                                  <td>Comodato</td>
                                  <td>12 meses</td>
                                  <td class="text-center">
                                      <x-botao.btn-visualizar :rota="route('contrato.show', 5)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                      <a href="" class="btn btn-info btn-sm" title="Enviar contrato" onclick="return confirm('Tem certeza que deseja Enviar este contrato?');">
                                    Enviar controto
                                    </a>
                                  </td>
                              </tr>
                             @endfor
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    <x-ui.modalDelete />
@endsection
