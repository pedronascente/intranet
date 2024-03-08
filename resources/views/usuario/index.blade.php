@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('usuario.index') }}">usuário</a>
       </li>
    </ol>
@endsection

@section('content')
   <div class="card p-3">
        <div class="card-header">
            <h3>
                <x-botao.btn-cadastrar :rota="route('usuario.create')"  :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />   
            </h3>
        </div>
        @if (in_array('Listar',$arrayListPermissoesDoModuloDaRota))
            <div class="card">
                <div class="card-header table-responsive">
                   <x-search-form />
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap  table-striped"> 
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Usuário</th>
                                <th>Colaborador</th>
                                <th>Empresa</th>
                                <th>Perfil</th>
                                <th>Status</th>
                                <th width="5%" class="text-center">Permissões</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($arrayListUsuario)
                                @foreach ($arrayListUsuario as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->colaborador->nome }}</td>
                                        <td>{{ $item->colaborador->empresa->nome }}</td>
                                        <td>{{ $item->perfil->nome }}</td>
                                        <td>
                                            @if ($item->status == 'on')   Ativo  @else Inativo    @endif
                                        </td>
                                        <td class="text-center">                                       
                                            <x-botao.btn-visualizar :rota="route('usuario.show', $item->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                            <x-botao.btn-editar :rota="route('usuario.edit', $item->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                                            <x-botao.btn-excluir :rota="route('usuario.destroy', $item->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />  
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    @if (@isset($arrayListUsuario))
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                {!! $arrayListUsuario->links() !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
    <x-ui.modalDelete/>
@endsection
