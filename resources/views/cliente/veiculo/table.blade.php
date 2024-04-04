 <div class="card">
  <div class="card-header">
      <h4>Veículos</h4>
  </div> 
  <div class="card-body table-responsive">
      <table class="table table-hover text-nowrap table-striped">
        <thead>
            <tr>
                <th>Placa</th>
                <th>Combustível</th>
                <th>Bloqueio</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Ano</th>
                <th>bateria</th>
                <th>Chassi</th>
                <th>Renavam</th>
                <th>Cor</th>
                <th width="5%" class="text-center">Permissões</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>IMW-8888</td>
                <td>GASOLINA</td>
                <td>NÃO</td>
                <td>FIAT</td>
                <td>WOLKSWAGEM</td>
                <td>2016</td>
                <td>12V</td>
                <td>2151454851884848</td>
                <td>2342342342342332423</td>
                <td>PRETO</td>
                <td>
                    <x-botao.btn-editar :rota="route('veiculo.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                    <x-botao.btn-excluir :rota="route('veiculo.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                  </td>
            </tr>
            <tr>
                <td>RRR-8RR8</td>
                <td>GASOLINA</td>
                <td>NÃO</td>
                <td>FIAT</td>
                <td>WOLKSWAGEM</td>
                <td>2016</td>
                <td>12V</td>
                <td>9999999999</td>
                <td>777777777777</td>
                <td>VERDE</td>
                <td>
                    <x-botao.btn-editar :rota="route('veiculo.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                    <x-botao.btn-excluir :rota="route('veiculo.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                </td>
            </tr>
        </tbody>
      </table> 
    </div> 
    <div class="card-footer">
      <x-botao.btn-cadastrar :rota="route('veiculo.create')" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
    </div>
</div>