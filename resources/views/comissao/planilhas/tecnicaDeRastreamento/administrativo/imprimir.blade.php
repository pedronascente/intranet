@include('comissao.planilhas._imprimir_header')

<table>
    <thead>
        <tr>
            <th>Linha</th>
            <th>Data</th>
            <th>Cliente</th>
            <th>Conta / Pedido</th>
            <th>Placa</th>
            <th>Comissão</th>
            <th>Desconto</th>
            <th class="observacao-column">Observação</th>
        </tr>
    </thead>
    <tbody>
        @if ($planilha->tecnicaDeRastreamento)
            @foreach ($planilha->tecnicaDeRastreamento as $index => $comissao)
                <tr class="{{ $index % 2 == 0 ? 'even-row' : 'odd-row' }}">
                    <td>{{ $comissao->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($comissao->data)->format('d/m/Y') }}</td>
                    <td>{{ $comissao->cliente }}</td>
                    <td>{{ $comissao->conta_pedido }}</td>
                    <td>{{ $comissao->placa }}</td>
                    <td>{{ 'R$ ' . number_format($comissao->comissao, 2, ',', '.') }}</td>
                    <td>{{ 'R$ ' . number_format($comissao->desconto_comissao, 2, ',', '.') }}</td>
                    <td class="observacao-column">{{ $comissao->observacao }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

@include('comissao.planilhas._imprimir_rodape')
