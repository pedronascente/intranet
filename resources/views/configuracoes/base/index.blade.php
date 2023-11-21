@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bases</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="/configuracoes">Configurações</a> /
                            <a href="/configuracoes/base">base</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <x-botao.criar rota="base" :permissoes="$permissoes" />
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
                                    @if ($permissoes)
                                        @foreach ($permissoes as $item)
                                            @if ($item->nome == 'Editar')
                                                <a href="{{ route('base.edit', $base->id) }}" class="btn btn-primary"
                                                    title="Editar">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                            @endif
                                            @if ($item->nome == 'Excluir')
                                                <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#deleteModal" data-id="{{ $base->id }}">
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
    </div>
    <x-ui.modalDelete modulo="base" />
@endsection
