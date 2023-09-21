@extends('layouts.app')
@section('content')
    <div class="card">
        <x-botao.criar rota="cartao" :permissoes="$permissoes" />
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>2FA</th>
                        <th>Usuário</th>
                        <th>Status</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collections)
                        @foreach ($collections as $cartao)
                            <tr>
                                <td>{{ $cartao->nome }}</td>
                                <td>{{ $cartao->user->name }}</td>
                                <td>
                                    @if ($cartao->status == 'on')
                                        Ativo
                                    @else
                                        Inativo
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($permissoes)
                                        @foreach ($permissoes as $item)
                                            @if ($item->nome == 'Editar')
                                                <a href="{{ route('cartao.edit', $cartao->id) }}" title="Editar"
                                                    class="btn btn-primary">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                            @endif
                                            @if ($item->nome == 'Visualizar')
                                                <a href="{{ route('cartao.show', $cartao->id) }}" title="visualizar"
                                                    class="btn btn-warning">
                                                    <i class="fas fa-solid fa-eye"></i> Visualizar
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
    <x-ui.modalDelete modulo="colaborador" />
@endsection
