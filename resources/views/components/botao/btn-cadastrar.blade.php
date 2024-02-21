@if (in_array('Criar',$arrayListPermissoesDoModuloDaRota))
    <a href="{{ $rota }}" class="btn btn-sm btn-primary" title="Cadastrar">
        <i class="fas fa-solid fa-plus"></i> Cadastrar
    </a>   
@endif