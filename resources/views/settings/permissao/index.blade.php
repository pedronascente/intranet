@extends('layouts.app')
@section('content')
    <div class="card">
        <x-botao.criar rota="permissao" :permissoes="$permissoes" />
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collection)
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{ $item->nome }}</td>
                                <td class="text-center">
                                    @if ($permissoes)
                                        @foreach ($permissoes as $permissao)
                                            @if ($permissao->nome == 'Editar')
                                                <!--a href="{{ route('permissao.edit', $item->id) }}" class="btn btn-primary"
                                                        title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a-->
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
    <x-ui.modalDelete modulo="permissao" />
@endsection
