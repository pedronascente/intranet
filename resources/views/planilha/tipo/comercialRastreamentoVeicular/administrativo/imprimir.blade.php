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
                    <td>R$ {{ $comissao->taxa_instalacao }}</td>
                    <td>R$ {{ $comissao->mensal }}</td>
                    <td>R$ {{ $comissao->comissao }}</td>
                    <td>R$ {{ $comissao->desconto_comissao }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

@include('planilha.tipo._imprimir_rodape')
