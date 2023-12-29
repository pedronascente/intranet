@if ($listaComissao->count() > 0)
    <table class="table table-hover table-bordered text-nowrap table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Data</th>
                <th>Cliente</th>
                <th>Conta</th>
                <th>Comissão</th>
                <th>Desconto</th>
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
                        <td>R$ {{ $comissao->comissao }}</td>
                        <td>R$ {{ $comissao->desconto_comissao }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="6">
                        <div class="row">
                            <div class="col-md-6"><b>{{ $listaComissao->total() }}</b> Registros Encontrados.</div>
                            <div class="col-md-6 text-right">Valor Total <b>R$ {{ $valorTotalComissao }}</b></div>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6">
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
