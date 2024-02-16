@include('comissao.planilhas._imprimir_header')

<table>
    <thead>
        <tr>
            <th>Linha</th>
            <th>Data</th>
            <th>Cliente</th>
            <th>Conta / Pedido</th>
            <th>Serviço</th>
            <th>Consultor</th>
            <th>Inst. / Venda</th>
            <th>Mensal</th>

            <th>Comissão</th>
            <th>Desconto </th>
        </tr>
    </thead>
    <tbody>
        @if ($planilha->supervisaoComercialAlarmesCercaEletricaCFTV)
            @foreach ($planilha->supervisaoComercialAlarmesCercaEletricaCFTV as $index => $comissao)
                <tr class="{{ $index % 2 == 0 ? 'even-row' : 'odd-row' }}">
                    <td>{{ $comissao->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($comissao->data)->format('d/m/Y') }}</td>
                    <td>{{ $comissao->cliente }}</td>
                    <td>{{ $comissao->conta_pedido }}</td>
                    <td>{{ $comissao->servico->nome }}</td>
                    <td>{{ $comissao->consultor }}</td>
                    <td>{{ 'R$ ' . number_format($comissao->ins_vendas, 2, ',', '.') }}</td>
                    <td>{{ 'R$ ' . number_format($comissao->mensal, 2, ',', '.') }}</td>
                    <td>{{ 'R$ ' . number_format($comissao->comissao, 2, ',', '.') }}</td>
                    <td>{{ 'R$ ' . number_format($comissao->desconto_comissao, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

@include('comissao.planilhas._imprimir_rodape')
