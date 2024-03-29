 @include('comissao.planilhas._imprimir_header')

 <table>
     <thead>
         <tr>
             <th>Linha</th>
             <th>Data</th>
             <th>Cliente</th>
             <th>Conta</th>
             <th>Meio</th>
             <th>Ins. / Vendas</th>
             <th>Mensal</th>
             <th>Comissão</th>
             <th>Desconto</th>
         </tr>
     </thead>
     <tbody>
         @if ($planilha->portariaVirtual)
             @foreach ($planilha->portariaVirtual as $index => $comissao)
                 <tr class="{{ $index % 2 == 0 ? 'even-row' : 'odd-row' }}">
                     <td>{{ $comissao->id }}</td>
                     <td>{{ \Carbon\Carbon::parse($comissao->data)->format('d/m/Y') }}</td>
                     <td>{{ $comissao->cliente }}</td>
                     <td>{{ $comissao->conta_pedido }}</td>
                     <td>{{ $comissao->meio->nome }}</td>
                     <td>R$ {{ $comissao->ins_vendas }}</td>
                     <td>R$ {{ $comissao->mensal }}</td>
                     <td>R$ {{ $comissao->comissao }}</td>
                     <td>R$ {{ $comissao->desconto_comissao }}</td>
                 </tr>
             @endforeach
         @endif
     </tbody>
 </table>
 @include('comissao.planilhas._imprimir_rodape')
