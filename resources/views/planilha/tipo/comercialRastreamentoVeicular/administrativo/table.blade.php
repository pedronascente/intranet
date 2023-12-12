@if ($listaComissao->count() > 0)
    <table class="table table-hover table-bordered text-nowrap table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Data</th>
                <th>Cliente</th>
                <th>ID Contrato</th>
                <th>Placa</th>
                <th>Tx. Instalação</th>
                <th>Mensal</th>
                <th>Comissão</th>
                <th>Desconto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listaComissao as $comissao)
                <tr>
                    <td>{{ $comissao->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($comissao->data)->format('d/m/Y') }}</td>
                    <td>{{ $comissao->cliente }}</td>
                    <td>{{ $comissao->id_contrato }}</td>
                    <td>{{ $comissao->placa }}</td>
                    <td>R$ {{ $comissao->taxa_instalacao }}</td>
                    <td>R$ {{ $comissao->mensal }}</td>
                    <td>R$ {{ $comissao->comissao }}</td>
                    <td>R$ {{ $comissao->desconto_comissao }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="9">
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