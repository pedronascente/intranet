@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('cartao.create') }}" class="btn btn-info btn-block ">
                    Adicionar novo cartão
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th width="50%">Cartão</th>
                        <th width="45%">Status</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collections)
                        @foreach ($collections as $cartao)
                            <tr>
                                <td>{{ $cartao->nome }}</td>

                                <td>
                                    @if ($cartao->status == 'on')
                                        Ativo
                                    @else
                                        Inativo
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('cartao.show', $cartao->id) }}" title="visualizar"
                                        style="padding-right: 10px">
                                        <i class="fas fa-solid fa-eye"></i>
                                    </a>

                                    <a href="{{ route('cartao.edit', $cartao->id) }}" title="Editar"
                                        style="padding-right: 10px">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('cartao.destroy', $cartao->id) }}" method="post"
                                        style="display: inline ;" title="Excluir">
                                        @method('DELETE')
                                        @csrf
                                        <a href="{{ route('cartao.destroy', $cartao->id) }}"
                                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </form>
                                    <a href="{{ route('cartao.edit', $cartao->id) }}" title="Voltar"
                                        style="padding-right: 10px">
                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
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
@endsection
