<table class="table table-hover text-nowrap table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Data</th>
            <th>Cliente</th>
            <th>Conta / Pedido</th>
            <th>Placa</th>
            <th>Comissão</th>
            <th>Desconto</th>
            <th>Observação</th>
            <th width="5%" class="text-center">Permissões</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < 20; $i++)
            <tr>
                <td>23</td>
                <td>17/08/2023</td>
                <td>Rosemarie da Costa Pfitscher</td>
                <td>333</td>
                <td>IMW-1988</td>
                <td>R$ 69.00</td>
                <td>efefef</td>
                <td>efefef</td>
                <td>
                    <a href="{{ route('comissao.edit', $i) }}" class="btn btn-primary" title="Editar Planilha">
                        <i class="nav-icon fas fa-edit"></i> Editar
                    </a>
                    <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"
                        data-id="1" title="Excluir Planilha">
                        <i class="fas fa-trash"></i> Excluir
                    </a>
                </td>
            </tr>
        @endfor
    </tbody>
</table>
