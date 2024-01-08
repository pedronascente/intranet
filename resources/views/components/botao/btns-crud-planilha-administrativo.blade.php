<a href="{{ route('planilha-administrativo.imprimirPDF', $planilha->id) }}" class="btn btn-success btn-sm"
    title="Imprimir-planilha" target="_blank">
    <i class="nav-icon fas fa-print"></i> Imprimir
</a>

<a href="{{ route('planilha-administrativo.arquivar', $planilha->id) }}" class="btn  btn-dark  btn-sm"
    title="Arquivar Planilha">
    <i class="nav-icon fas fa-archive"></i> Arquivar
</a>

<a href="{{ route('planilha-administrativo.index') }}" class="btn btn-danger btn-sm" title="Voltar">
    <i class="fa fa-reply"></i> Voltar
</a>
