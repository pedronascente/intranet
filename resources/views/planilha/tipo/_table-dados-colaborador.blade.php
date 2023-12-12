<table class="table table-hover table-bordered text-nowrap table-striped">
    <thead>
        <tr>
            <th>NOME</th>
            <th>EMPRESA</th>
            <th>MATRICULA</th>
            <th>CTPS</th>
            <th>PERIODO</th>
            <th>ANO</th>
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
