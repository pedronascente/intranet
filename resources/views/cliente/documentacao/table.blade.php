<div class="card">
  <div class="card-header">
    <h4>Documentação em anexo</h4>
  </div> 
  <div class="card-body table-responsive">
    <table class="table table-hover text-nowrap table-striped">
        <thead>
            <tr>
                <th>Arquivo</th>
                <th>Descrição</th>
                <th>Tipo Pessoa</th>
                <th width="5%" class="text-center">Permissões</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                  <img src="https://blog.usezapay.com.br/wp-content/uploads/2022/10/cnhmineiro.webp" width="50">
                </td>
                <td>CARTA_CANCELAMENTO</td>
                <td>Fisica</td>
                <td>
                    <x-botao.btn-editar :rota="route('cliente.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                    <x-botao.btn-excluir :rota="route('cliente.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                </td>
            </tr>
            <tr>
                <td>
                  <img src="https://blog.usezapay.com.br/wp-content/uploads/2022/10/cnhmineiro.webp" width="50">
                </td>
                <td>CARTA_CANCELAMENTO</td>
                <td>Fisica</td>
                <td>
                    <x-botao.btn-editar :rota="route('cliente.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                    <x-botao.btn-excluir :rota="route('cliente.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                </td>
            </tr>
        </tbody>
      </table>
  </div>  
  <div class="card-footer">
      <x-botao.btn-cadastrar :rota="route('cliente.create')" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
  </div>
</div>