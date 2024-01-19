@extends('layouts.app')

@section('titulo', 'Permissão')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes">Configurações</a> /
            <a href="/configuracoes/permissao">permissão</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <x-botao.btn-cadastrar :rota="route('permissao.create')"  />
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th width="5%" class="text-center">Permissões</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($collection)
                            @foreach ($collection as $item)
                                <tr>
                                    <td>{{ $item->nome }}</td>
                                    <td class="text-center">
                                       <a href="{{ route('permissao.edit', $item->id) }}" class="btn  btn-sm btn-primary"
                                            title="Editar">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <x-botao.btn-excluir :rota="route('permissao.destroy', $item->id)" titulo="Excluir Permissão" />  
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
