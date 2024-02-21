@if (in_array('Editar',$arrayListPermissoesDoModuloDaRota))
    <a href="{{ $rota }}" class="btn btn-sm btn-info" title="Editar">
        <i class="nav-icon fas fa-edit"></i> Editar
    </a>
@endif