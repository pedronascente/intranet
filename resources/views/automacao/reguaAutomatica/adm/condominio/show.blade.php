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
        <div class="card">
            <div class="card-header">
                <h4>Condominio</h4>
            </div> 
            <div class="card-body table-responsive">
                <table class="table table-hover text-nowrap table-striped">
                      <thead>
                          <tr>
                              <th>Condominio</th>
                              <th>IP</th>
                              <th>Usuário</th>
                              <th>Senha</th>
                              <th class="text-center">Total Tomadas</th>
                              <th></th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td>{{ $condominio->condominio}}</td>
                              <td>{{ $condominio->regua->ip}}</td>
                              <td>{{ $condominio->regua->usuario}}</td>
                              <td>{{ $condominio->regua->senha}}</td>
                              <td class="text-center">{{ $condominio->regua->tomadas->count() }}</td>
                              <td class="float-right">  
                                 <x-botao.btn-editar :rota="route('condominoController.edit', $condominio->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                              </td>
                          </tr>
                      </tbody>
                </table>
            </div>
        </div>    
        <div class="card">
            <div class="card-header">
                <h4>Tomadas</h4>
            </div> 
            <div class="card-body table-responsive">
                <table class="table table-hover text-nowrap table-striped">
                      <thead>
                          <tr>
                              <th>ID</th>
                              <th>Tomada</th>
                              <th colspan="2">Api</th>
                          </tr>
                      </thead>
                      <tbody>
                        @if ($condominio->regua->tomadas)
                            @foreach ( $condominio->regua->tomadas as $tomada )
                                <tr>
                                    <td>{{ $tomada->id }}</td>
                                    <td>{{ $tomada->tomada }}</td>
                                    <td>{{ $tomada->api }}</td>
                                    <td class="float-right">
                                        <x-botao.btn-editar-tomada :rota="route('tomada.edit',$tomada->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                        <x-botao.btn-excluir :rota="route('tomada.destroy', $tomada->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                    </td>
                                </tr>
                            @endforeach
                        @endif  
                      </tbody>
                </table>
            </div>
            <div class="card-body table-responsive">
                <x-botao.btn-cadastrar-tomada  />     
            </div>    
        </div>    
    </div>
    <x-ui.modalEditarTomada />
    <x-ui.modalCadastrarTomada :regua="$condominio->regua->id" />
@endsection