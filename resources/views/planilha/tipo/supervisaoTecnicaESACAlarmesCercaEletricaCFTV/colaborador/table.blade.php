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
                    <td>{{ $comissao->ins_vendas }}</td>
                    <td>{{ $comissao->mensal }}</td>
                    <td>{{ $comissao->comissao }}</td>
                    <td>{{ $comissao->desconto_comissao }}</td>
                    <td>
                        <a href="{{ route('stsace-cftv.edit', $comissao->id) }}" class="btn btn-primary btn-sm"
                            title="Editar comissão">
                            <i class="nav-icon fas fa-edit"></i> Editar
                        </a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#deleteModal" data-route="{{ route('stsace-cftv.destroy', $comissao->id) }}"
                            title="Excluir comissão">
                            <i class="fas fa-trash"></i> Excluir
                        </a>
                    </td>
                </tr>
            @endforeach
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
<x-ui.modalDelete />