@extends('layouts.app')

@section('titulo', 'Módulo')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes">Configurações</a> 
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <x-botao.btn-cadastrar :rota="route('modulo.create')" :permissoes="$permissoes" />
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>Módulo</th>
                            <th>slug</th>
                            <th>Descrição</th>
                            <th width="5%" class="text-center">Permissões</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($collection)
                            @foreach ($collection as $item)
                                <tr>
                                    <td>{{ $item->nome }}</td>
                                    <td>{{ $item->slug }}</td>
                                    <td>{{ $item->descricao }}</td>
                                    <td class="text-center">
                                        @if ($permissoes)
                                            @foreach ($permissoes as $permissao)
                                                @if ($permissao->nome == 'Editar')
                                                    <a href="{{ route('modulo.edit', $item->id) }}" class="btn btn-sm btn-info"
                                                        title="Editar">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>
                                                @endif
                                                @if ($permissao->nome == 'Excluir')
                                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm"
                                                        data-toggle="modal" data-target="#deleteModal"
                                                        data-route="{{ route('modulo.destroy', $item->id) }}"
                                                        title="Excluir Planilha">
                                                        <i class="fas fa-trash"></i> Excluir
                                                    </a>
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-7">
                        {!! $collection->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
       <x-ui.modalDelete />
@endsection
