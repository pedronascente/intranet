<table class="table table-hover table-bordered text-nowrap ">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Empresa</th>
            <th>Matricula</th>
            <th>CTPS</th>
            <th>Periodo</th>
            <th>Ano</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $planilha->colaborador->nome }}</td>
            <td>{{ $planilha->colaborador->empresa->nome }}</td>
            <td>{{ $planilha->matricula }}</td>
            <td>{{ $planilha->ctps }}</td>
            <td>{{ $planilha->periodo->nome }}</td>
            <td>{{ $planilha->ano }}</td>
        </tr>
    </tbody>
</table>
