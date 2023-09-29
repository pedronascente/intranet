@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Usuários</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="/settings">Configurações</a> /
                            <a href="/settings/user">usuário</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <x-botao.criar rota="usuario" :permissoes="$permissoes" />
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap  table-striped">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th>Usuário</th>
                        <th>Perfil</th>
                        <th> Status</th>
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
                                    @if ($permissoes)
                                        @foreach ($permissoes as $permissao)
                                            @if ($permissao->nome == 'Visualizar')
                                                <a href="{{ route('user.show', $item->id) }}" title="Visualizar"
                                                    class="btn btn-warning">
                                                    <i class="fas  fa-eye"></i> Visualizar
                                                </a>
                                            @endif
                                            @if ($permissao->nome == 'Editar')
                                                <a href="{{ route('user.edit', $item->id) }}" class="btn btn-primary"
                                                    title="Editar">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                            @endif
                                            @if ($permissao->nome == 'Excluir')
                                                <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#deleteModal" data-id="{{ $item->id }}">
                                                    <i class="fas fa-trash"></i> Excluir
                                                </a>
                                            @endif
                                        @endforeach
                                    @endif
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
    <x-ui.modalDelete modulo="usuario" />
@endsection
