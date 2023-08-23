@extends('layouts.app')
@section('content')
    <div class="card">
        <x-botao.criar rota="modulo" :permissoes="$permissoes" />
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>Módulo</th>
                        <th>Descrição</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($collection as $item)
                        <tr>
                            <td>{{ $item->nome }}</td>
                            <td>{{ $item->descricao }}</td>
                            <td class="text-center">
                                @if ($permissoes)
                                    @foreach ($permissoes as $permissao)
                                        @if ($permissao->nome == 'Editar')
                                            <a href="{{ route('modulo.edit', $item->id) }}" class="btn btn-primary"
                                                title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if ($permissao->nome == 'Excluir')
                                            <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal"
                                                data-target="#deleteModal" data-id="{{ $item->id }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer ">
            <div class="row">
                <div class="col-sm-12 col-md-7">
                    {!! $collection->links() !!}
                </div>
            </div>
        </div>
    </div>
    <x-ui.modalDelete modulo="modulo" />
@endsection
