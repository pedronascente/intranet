<div class="card">
  <div class="card-header">
    <h4>Documentação em anexo</h4>
  </div> 
  <div class="card-body table-responsive">
    <table class="table table-hover text-nowrap table-striped">
        <thead>
            <tr>
                <th>Arquivo</th>
                <th>Número Contrato</th>
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
                <td>00012</td>
                <td>CARTA_CANCELAMENTO</td>
                <td>Fisica</td>
                <td>
                   <a href="" class="btn btn-sm btn-dark" title="Baixar">
                           Baixar
                      </a>
                    <x-botao.btn-excluir :rota="route('documento.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                     
                  </td>
            </tr>
            <tr>
                <td>
                  <img src="https://blog.usezapay.com.br/wp-content/uploads/2022/10/cnhmineiro.webp" width="50">
                </td>
                <td>00012</td>
                <td>CARTA_CANCELAMENTO</td>
                <td>Fisica</td>
                <td>
                   <a href="" class="btn btn-sm btn-dark" title="Baixar">
                           Baixar
                      </a>
                    <x-botao.btn-excluir :rota="route('documento.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                </td>
            </tr>
        </tbody>
      </table>
  </div>  
  <div class="card-footer">
      <x-botao.btn-cadastrar :rota="route('documento.create')" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
  </div>
</div>