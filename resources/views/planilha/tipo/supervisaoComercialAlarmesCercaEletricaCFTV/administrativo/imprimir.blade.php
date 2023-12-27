@include('planilha.tipo._imprimir_header')

<table>
    <thead>
        <tr>
            <th>Linha</th>
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
        @if ($planilha->supervisaoComercialAlarmesCercaEletricaCFTV)
            @foreach ($planilha->supervisaoComercialAlarmesCercaEletricaCFTV as $index => $comissao)
                <tr class="{{ $index % 2 == 0 ? 'even-row' : 'odd-row' }}">
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
</table>

@include('planilha.tipo._imprimir_rodape')
