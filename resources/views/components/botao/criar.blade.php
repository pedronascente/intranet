 @if ($permissoes)
     @foreach ($permissoes as $item)
         @if ($item->nome == 'Criar')
             <div class="card-header">
                 <h3>
                     <a href="{{ $rota }}" class="btn btn-primary">
                         <i class="fas fa-solid fa-plus"></i> Cadastrar
                     </a>
                 </h3>
             </div>
         @endif
     @endforeach
 @endif