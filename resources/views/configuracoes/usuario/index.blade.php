@extends('layouts.app')

@section('titulo', 'Usuários')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes">Configurações</a> /
            <a href="{{ route('usuario.index') }}">usuário</a>
       </li>
    </ol>
@endsection

@section('content')
   <div class="card p-3">
        <x-botao.btn-cadastrar :rota="route('usuario.create')" />
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap  table-striped">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th>Usuário</th>
                            <th>Perfil</th>
                            <th>Status</th>
                            <th width="5%" class="text-center">Permissões</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($collections)
                            @foreach ($collections as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->perfil->nome }}</td>
                                    <td>
                                        @if ($item->status == 'on')
                                            Ativo
                                        @else
                                            Inativo
                                        @endif
                                    </td>
                                    <td class="text-center">                                       
                                        <a href="{{ route('usuario.show', $item->id) }}" title="Visualizar"
                                                    class="btn btn-sm btn-primary">
                                                <i class="fas fa-folder"></i> Visualizar
                                        </a>
                                        <a href="{{ route('usuario.edit', $item->id) }}" 
                                                class="btn  btn-sm btn-info"
                                                title="Editar">
                                                    <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <x-botao.btn-excluir :rota="route('usuario.destroy', $item->id)" titulo="Excluir Usuário" />    
                                    </td>
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
    </div>
    <x-ui.modalDelete/>
@endsection