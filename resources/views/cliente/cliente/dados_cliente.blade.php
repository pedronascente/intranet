<div class="card">
          <div class="card-header">
              <h4>Dados do cliente</h4>
          </div> 
          <div class="card-body table-responsive">
              <table class="table table-hover text-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Data Nascimento</th>
                            <th>Cpf</th>
                            <th>RG</th>
                            <th>Estado Civil</th>
                              <th>Tipo Pessoa</th>
                            <th width="5%" class="text-center">Permissões</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Pedro</td>
                            <td>06/06/2024</td>
                            <td>699.731.460-00</td>
                            <td>RG</th>
                            <td>casado</td>
                              <td>Fisica</td>
                            <td>
                                <x-botao.btn-editar :rota="route('cliente.edit', 1)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                            </td>
                        </tr>
                    </tbody>
              </table>
          </div>
        </div>    