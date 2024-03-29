@include('comissao.planilhas._imprimir_header')
<table>
    <thead>
        <tr>
            <th>Linha</th>
            <th>Data</th>
            <th>Cliente</th>
            <th>Conta</th>
            <th>Comissão</th>
            <th>Desconto</th>
        </tr>
    </thead>
    <tbody>
        @if ($planilha->entregaDeAlarmes)
            @foreach ($planilha->entregaDeAlarmes as $index => $comissao)
                <tr class="{{ $index % 2 == 0 ? 'even-row' : 'odd-row' }}">
                    <td>{{ $comissao->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($comissao->data)->format('d/m/Y') }}</td>
                    <td>{{ $comissao->cliente }}</td>
                    <td>{{ $comissao->conta_pedido }}</td>
                    <td>{{ 'R$ ' . number_format($comissao->comissao, 2, ',', '.') }}</td>
                    <td>{{ 'R$ ' . number_format($comissao->desconto_comissao, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@include('comissao.planilhas._imprimir_rodape')
