@extends('layouts.app')

@section('titulo', 'Empresa')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes">Configurações</a> /
             <a href="/configuracoes/empresa">empresa</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <x-botao.btn-cadastrar :rota="route('empresa.create')" :permissoes="$permissoes" />
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>Cnpj</th>
                            <th>Logo</th>
                            <th width="5%" class="text-center">Permissões</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($collection)
                            @foreach ($collection as $item)
                                <tr>
                                    <td>{{ $item->nome }}</td>
                                    <td>{{ $item->cnpj }}</td>
                                    <td><img src="{{ asset('/img/empresa/' . $item->imglogo) }}" width="100"></td>
                                    <td class="text-center">
                                        @if ($permissoes)
                                            @foreach ($permissoes as $permissao)
                                                @if ($permissao->nome == 'Editar')
                                                    <a href="{{ route('empresa.edit', $item->id) }}" title="Editar"
                                                        class="btn  btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>
                                                @endif
                                                @if ($permissao->nome == 'Excluir')
                                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm"
                                                        data-toggle="modal" data-target="#deleteModal"
                                                        data-route="{{ route('empresa.destroy', $item->id) }}"
                                                        title="Excluir Planilha">
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


