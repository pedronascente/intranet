<table class="table table-hover text-nowrap table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Data</th>
            <th>Cliente</th>
            <th>Conta</th>
            <th>Meio</th>
            <th>Ins. / Vendas</th>
            <th>Mensal</th>
            <th>Comissão</th>
            <th>Desconto da Comissão</th>
            <th width="5%" class="text-center">Permissões</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < 20; $i++)
            <tr>
                <td>237314</td>
                <td>17/08/2023</td>
                <td>Rosemarie da Costa Pfitscher</td>
                <td>3434534</td>
                <td>Captação</td>
                <td>R$ 149.00</td>
                <td>R$ 69.00</td>
                <td>R$ 35.00</td>
                <td></td>
                <td> <a href="http://127.0.0.1:8000/comissao/planilha/1" class="btn btn-primary" title="Editar Planilha">
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
