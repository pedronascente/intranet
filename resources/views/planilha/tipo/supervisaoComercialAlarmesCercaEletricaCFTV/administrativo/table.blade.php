@if ($listaComissao->count() > 0)
    <table class="table table-hover table-bordered text-nowrap table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Data</th>
                <th>Cliente</th>
                <th>Conta / Pedido</th>
                <th>Serviço</th>
                <th>Inst. / Venda</th>
                <th>Mensal</th>
                <th>Consultor</th>
                <th>Comissão</th>
                <th>Desconto </th>
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
                        <td>{{ $comissao->servico->nome }}</td>
                        <td>{{ $comissao->ins_vendas }}</td>
                        <td>{{ $comissao->mensal }}</td>
                        <td>{{ $comissao->consultor }}</td>
                        <td>{{ $comissao->comissao }}</td>
                        <td>{{ $comissao->desconto_comissao }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="10">
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