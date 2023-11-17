<table class="table table-hover text-nowrap table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Data</th>
            <th>Cliente</th>
            <th>Conta / Pedido</th>
            <th>Serviço</th>
            <th>Inst. / Venda</th>
            <th>Mensal</th>
            <th>Consultor</th>
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
                    <td>{{ $comissao->conta }}</td>
                    <td>{{ $comissao->servico }}</td>
                    <td>{{ $comissao->ins_venda }}</td>
                    <td>{{ $comissao->mensal }}</td>
                    <td>{{ $comissao->consultor }}</td>
                    <td>{{ $comissao->comissao }}</td>
                    <td>{{ $comissao->desconto_comissao }}</td>
                    <td>
                        <a href="{{ route('supervisaoComercialAlarmesCercaEletricaCFTV.edit', $comissao->id) }}"
                            class="btn btn-primary" title="Editar comissão">
                            <i class="nav-icon fas fa-edit"></i> Editar
                        </a>
                        <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"
                            data-route="{{ route('supervisaoComercialAlarmesCercaEletricaCFTV.destroy', $comissao->id) }}"
                            title="Excluir comissão">
                            <i class="fas fa-trash"></i> Excluir
                        </a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@if ($listaComissao)
    {{ $listaComissao->links() }}
@endif
<x-ui.modalDelete />
