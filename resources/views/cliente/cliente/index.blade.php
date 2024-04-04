@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
           <a href="{{ route('cliente.index') }}">Cliente</a>
        </li>
    </ol>
@endsection 

@section('content')
    <div class="card p-3">
        <div class="card-header">
            <h3>
                <x-botao.btn-cadastrar :rota="route('cliente.create')"  :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />   
            </h3>
        </div>
            <div class="card-header table-responsive">
                <x-search-form />
            </div>
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-striped">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tipo Pessoa</th>
                                <th>Cliente</th>
                                <th>CPF</th>
                                <th>CNPJ</th>
                                <th width="5%" class="text-center">Permissões</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>00001</td>
                                <td> Fisico</td>
                                <td> Fulano de tal</td>
                                <td></td>
                                <td>699.731.460-00</td>
                                <td class="text-center">
                                    <x-botao.btn-visualizar :rota="route('cliente.show', 1)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                    <x-botao.btn-excluir :rota="route('cliente.destroy', 1)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                </td>
                            </tr>
                            <tr>
                                <td>00001</td>
                                <td> Juridico</td>
                                <td>Empresa tabajara</td>
                                <td>86.293.080/0001-36</td>
                                <td></td>
                                <td class="text-center">
                                    <x-botao.btn-visualizar :rota="route('cliente.show', 2)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                    <x-botao.btn-excluir :rota="route('cliente.destroy', 2)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    
                </div>
            </div>
    </div>
    <x-ui.modalDelete />
@endsection




