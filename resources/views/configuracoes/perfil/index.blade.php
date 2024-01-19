@extends('layouts.app')

@section('titulo', 'Perfil')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes">Configurações</a> /
            <a href="/configuracoes/perfil">perfil</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <x-botao.btn-cadastrar :rota="route('perfil.create')"  />
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap  table-striped">
                    <thead>
                        <tr>
                            <th>Perfil</th>
                            <th>Descrição</th>
                            <th width="5%" class="text-center">Permissões</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($collections)
                            @foreach ($collections as $item)
                                <tr>
                                    <td>{{ $item->nome }}</td>
                                    <td>{{ $item->descricao }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('perfil.edit', $item->id) }}" 
                                            class="btn  btn-sm  btn-primary"
                                            title="Editar">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <x-botao.btn-excluir :rota="route('perfil.destroy', $item->id)" titulo="Excluir Perfil" />
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <x-ui.modalDelete />
@endsection
