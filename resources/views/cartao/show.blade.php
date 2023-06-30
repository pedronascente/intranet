@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-md table-striped">
                <tr>
                    <td><b>DADOS:</td>
                </tr>
            </table>
            <table class="table table-md">
                <tr>
                    <td><b>Status :</b> Ativo</td>
                </tr>
                <tr>
                    <th width="8%"><b> Cartão :</b> 001</td>
                </tr>
                <tr>
                    <td><b>Usuário :</b> Pedro jardim</td>
                </tr>

            </table>

            <table class="table table-md table-striped text">
                <tr>
                    <td> <b>TOKENS</b> </td>
                </tr>
            </table>
            <table class="table table-bordered ">
                <thead>
                    <th width="7%" class="text-center">Posição</th>
                    <th>Token</th>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 40; $i++)
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td>hrft8985</td>
                        </tr>
                    @endfor
                </tbody>

            </table>

            <table class="table table-md">
                <tr>
                    <td>
                        <a href="{{ route('cartao.index') }}" title="Voltar" style="padding-right: 10px">
                            <i class="fa fa-reply" aria-hidden="true"></i>
                        </a>

                        <a href="{{ route('cartao.edit', 1) }}" title="Editar" style="padding-right: 10px">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('cartao.destroy', 1) }}" method="post" style="display: inline ;"
                            title="Excluir">
                            @method('DELETE')
                            @csrf
                            <a href="{{ route('cartao.destroy', 1) }}"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                <i class="fas fa-trash"></i>
                            </a>
                        </form>

                        <a href="{{ route('cartao.edit', 1) }}" title="Voltar" style="padding-right: 10px">
                            <i class="fa fa-refresh" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
