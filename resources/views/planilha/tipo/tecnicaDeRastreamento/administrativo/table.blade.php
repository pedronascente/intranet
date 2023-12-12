@if ($listaComissao->count() > 0)
    <table class="table table-hover table-bordered  text-nowrap table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Data</th>
                <th>Cliente</th>
                <th>Conta / Pedido</th>
                <th>Placa</th>
                <th>Comissão</th>
                <th>Desconto</th>
                <th>Observação</th>
            </tr>
        </thead>
        <tbody>
            @if ($listaComissao)
                @foreach ($listaComissao as $comissao)
                    <tr>
                        <td>{{ $comissao->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($comissao->data)->format('d/m/Y') }}</td>
                        <td>{{ $comissao->cliente }}</td>
                        <td>{{ $comissao->conta_pedido }}</td>
                        <td>{{ $comissao->placa }}</td>
                        <td>R$ {{ $comissao->comissao }}</td>
                        <td>R$ {{ $comissao->desconto_comissao }}</td>
                        <td>
                            {{ $comissao->observacao }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8">
                    <p> <b>{{ $listaComissao->total() }}</b> Registros Encontrados. Valor Total <b>R$
                            {{ $valorTotalComissao }}</b></p>
                    @if ($listaComissao)
                        {{ $listaComissao->links() }}
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>
@else
   <p class="text-center">Nenhum registro encontrado.</p>
@endif
