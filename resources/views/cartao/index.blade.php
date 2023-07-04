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
                        <th width="5%">Cartão</th>
                        <th>Usuário</th>
                        <th>Status</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($cartoes)
                        @foreach ($cartoes as $cartao)
                            <tr>
                                <td>{{ $cartao->id }}</td>
                                <td>
                                    @if ($cartao->user)
                                        {{ $cartao->user->name }}
                                    @endif

                                </td>
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
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
