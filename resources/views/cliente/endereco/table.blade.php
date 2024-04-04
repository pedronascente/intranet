<div class="card">
  <div class="card-header">
      <h4>Endereços</h4>
  </div> 
  <div class="card-body table-responsive">
      <table class="table table-hover text-nowrap table-striped">
        <thead>
            <tr>
                <th>Tipo Endereço</th>
                <th>CEP</th>
                <th>UF</th>
                <th>Endereço</th>
                <th>Numero</th>
                <th>Cidade</th>
                <th>Bairro</th>
                <th width="5%" class="text-center">Permissões</th>
            </tr>
        </thead>
        <tbody>
            <tr>
              <td>Residencial</td>
                <td>71505-275</td>
                <td>DF</td>
                <td>Quadra SHIN QL 3 Conjunto 7</td>
                <td>15</td>
                <td>Brasília</td>
                <td>Setor de Habitações Individuais Norte</td>
               
                <td>
                    <x-botao.btn-editar :rota="route('endereco.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                    <x-botao.btn-excluir :rota="route('endereco.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                </td>
            </tr>
            <tr>
                <td>Cobrança</td>
                <td>71505-275</td>
                <td>DF</td>
                <td>Quadra SHIN QL 3 Conjunto 7</td>
                <td>15</td>
                <td>Brasília</td>
                <td>Setor de Habitações Individuais Norte</td>
               
                <td>
                    <x-botao.btn-editar :rota="route('endereco.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                    <x-botao.btn-excluir :rota="route('endereco.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                </td>
            </tr>
        </tbody>
      </table>           
    </div>
    <div class="card-footer">
        <x-botao.btn-cadastrar :rota="route('endereco.create')" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
    </div> 
</div>