<table class="table table-hover table-bordered text-nowrap table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Data</th>
            <th>Cliente</th>
            <th>Conta</th>
            <th>Meio</th>
            <th>Ins. / Vendas</th>
            <th>Mensal</th>
            <th>Comissão</th>
            <th>Desconto</th>
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
                    <td>{{ $comissao->meio->nome }}</td>
                    <td>R$ {{ $comissao->ins_vendas }}</td>
                    <td>R$ {{ $comissao->mensal }}</td>
                    <td>R$ {{ $comissao->comissao }}</td>
                    <td>R$ {{ $comissao->desconto_comissao }}</td>
                    <td>
                        <a href="{{ route('portaria-virtual.edit', $comissao->id) }}" class="btn btn-info btn-sm"
                            title="Editar comissão">
                            <i class="nav-icon fas fa-edit"></i> Editar
                        </a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#deleteModal"
                            data-route="{{ route('portaria-virtual.destroy', $comissao->id) }}"
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
