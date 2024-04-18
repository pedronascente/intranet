@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('condominoController.index') }}">Condominio</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card-header">
            <h3>
               <x-botao.btn-cadastrar :rota="route('condominoController.create')"  :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />  
            </h3>
        </div>
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Condominio</th>
                            <th width="5%" class="text-center">Permissões</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($collerction)
                            @foreach ($collerction as $condominio)
                                <tr>
                                <td> {{ $condominio->id }}</td>
                                    <td> {{ $condominio->condominio }}</td>
                                    <td class="text-center">
                                        <x-botao.btn-visualizar :rota="route('condominoController.show', $condominio->id )" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />                                    
                                        <x-botao.btn-excluir :rota="route('condominoController.destroy', $condominio->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection