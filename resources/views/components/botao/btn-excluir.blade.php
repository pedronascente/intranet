@if (in_array('Excluir',$arrayListPermissoesDoModuloDaRota))
   <a href="javascript:void(0)" class="btn btn-danger btn-sm"
        data-toggle="modal" data-target="#deleteModal"
        data-route="{{ $rota }}"
        title="Excluir">
        <i class="fas fa-trash"></i> Excluir
    </a>
@endif