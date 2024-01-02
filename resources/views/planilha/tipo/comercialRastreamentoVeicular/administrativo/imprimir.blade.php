@include('planilha.tipo._imprimir_header')

<table>
    <thead>
        <tr>
            <th>Linha</th>
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
        @if ($planilha->comercialRastreamentoVeicular)
            @foreach ($planilha->comercialRastreamentoVeicular as $index => $comissao)
                <tr class="{{ $index % 2 == 0 ? 'even-row' : 'odd-row' }}">
                    <td>{{ $comissao->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($comissao->data)->format('d/m/Y') }}</td>
                    <td>{{ $comissao->cliente }}</td>
                    <td>{{ $comissao->id_contrato }}</td>
                    <td>{{ $comissao->placa }}</td>
                    <td>{{ 'R$ ' . number_format($comissao->taxa_instalacao, 2, ',', '.') }}</td>
                    <td>{{ 'R$ ' . number_format($comissao->mensal, 2, ',', '.') }}</td>
                    <td>{{ 'R$ ' . number_format($comissao->comissao, 2, ',', '.') }}</td>
                    <td>{{ 'R$ ' . number_format($comissao->desconto_comissao, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

@include('planilha.tipo._imprimir_rodape')
