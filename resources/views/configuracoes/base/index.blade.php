@extends('layouts.app')

@section('titulo', 'Base')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes">Configurações</a> /
            <a href="/configuracoes/base">base</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <x-botao.btn-cadastrar :rota="route('base.create')"  />
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>Base</th>
                            <th width="5%" class="text-center">Permissões</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (@isset($collection))
                            @foreach ($collection as $base)
                                <tr>
                                    <td>{{ $base->nome }}</td>
                                    <td class="text-center">
                                        <x-botao.btn-editar :rota="route('base.edit', $base->id)"/>
                                        <x-botao.btn-excluir :rota="route('base.destroy', $base->id)" titulo="Excluir Base" />
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <x-ui.modalDelete modulo="base" />
@endsection
