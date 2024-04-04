
<div class="card">
  <div class="card-header">
      <h4>Contatos</h4>
  </div> 
  <div class="card-body table-responsive">
    <table class="table table-hover text-nowrap table-striped">
        <thead>
          <tr>
              <th>Nome</th>
              <th>Email</th>
              <th>Telefone1</th>
              <th>Telefone2</th>
              <th>Telefone3</th>
              <th width="5%" class="text-center">Permissões</th>
          </tr>
        </thead>
        <tbody>
          @for ($a=4;$a < 10; $a++)
              <tr>
                <td>Pedro</td>
                <td>pedro@bol.com</td>
                <td>(51)98999999</td>
                <td>(51)98999999</td>
                <td>(51)98999999</th>
                <td>
                    <x-botao.btn-editar :rota="route('contato.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                    <x-botao.btn-excluir :rota="route('contato.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                </td>
            </tr>
          @endfor
        </tbody>
    </table>
  </div> 
  <div class="card-footer">
      <x-botao.btn-cadastrar :rota="route('contato.create')" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
  </div> 
</div>