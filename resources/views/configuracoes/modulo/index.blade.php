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
        <x-botao.btn-cadastrar :rota="route('modulo.create')"  />
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>Módulo</th>
                            <th>Categoria</th>
                            <th>Posição do menu</th>
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
                                    <td>{{ $item->categoria->nome }}</td>
                                    <td>{{ $item->posicao->nome }}</td>
                                    <td>{{ $item->slug }}</td>
                                    <td>{{ $item->descricao }}</td>
                                    <td class="text-center">
                                        <x-botao.btn-editar :rota="route('modulo.edit', $item->id)"/>
                                        <x-botao.btn-excluir :rota="route('modulo.destroy', $item->id)" titulo="Excluir Modulo" />
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
