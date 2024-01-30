@if ($listaComissao->count() > 0)
    <table class="table table-hover table-bordered text-nowrap table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Data</th>
                <th>Cliente</th>
                <th>Conta / Pedido</th>
                <th>Equipe / Serviço</th>
                <th>Inst. / Venda</th>
                <th>Mensal</th>
                <th>Comissão</th>
                <th>Desconto </th>
                <th width="5%" class="text-center">Permissões</th>
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
                        <td>{{ $comissao->equipe_servico }}</td>
                        <td>{{ 'R$ ' . number_format($comissao->ins_vendas, 2, ',', '.') }}</td>
                        <td>{{ 'R$ ' . number_format($comissao->mensal, 2, ',', '.') }}</td>
                        <td>{{ 'R$ ' . number_format($comissao->comissao, 2, ',', '.') }}</td>
                        <td>{{ 'R$ ' . number_format($comissao->desconto_comissao, 2, ',', '.') }}</td>
                         <td>
                            <x-botao.btn-editar :rota="route('comissao.administrativo.editarComissaoAdministrativo', ['planilha' => $comissao->planilha_id, 'comissao' => $comissao->id])"/>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="10">
                        <div class="row">
                            <div class="col-md-6"><b>{{ $listaComissao->total() }}</b> Registros Encontrados.</div>
                            <div class="col-md-6 text-right"> Valor Total <b>R$ {{ $valorTotalComissao }}</b> </div>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="10">
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
