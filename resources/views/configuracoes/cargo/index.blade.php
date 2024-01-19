@extends('layouts.app')

@section('titulo', "Cargos")

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes">Configurações</a> /
            <a href="/configuracoes/cargo">cargos</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <x-botao.btn-cadastrar :rota="route('cargo.create')"  />
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>Cargo</th>
                            <th width="5%" class="text-center">Permissões</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (@isset($collection))
                            @foreach ($collection as $cargo)
                                <tr>
                                    <td>{{ $cargo->nome }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('cargo.edit', $cargo->id) }}" 
                                            class="btn btn-sm btn-info"
                                            title="Editar">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                         <x-botao.btn-excluir :rota="route('cargo.destroy', $cargo->id)" titulo="Excluir Cargo" />
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @if (@isset($collection))
                    <div class="row">
                        <div class="col-sm-12 col-md-7">
                            {!! $collection->links() !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <x-ui.modalDelete />
@endsection
