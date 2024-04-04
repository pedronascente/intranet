
<div class="card">
  <div class="card-header">
      <h4>Sócios</h4>
  </div> 
  <div class="card-body table-responsive">
    <table class="table table-hover text-nowrap table-striped">
        <thead>
          <tr>
              <th>Sócio</th>
              <th>CPF</th>
              <th width="5%" class="text-center">Permissões</th>
          </tr>
        </thead>
        <tbody>
          @for ($a=4;$a < 10; $a++)
              <tr>
                <td>Fulano de tal -  {{ $a }}</td>
                <td>82{{ $a }}.84{{ $a }}.85{{ $a }}-5{{ $a }}</td>
                <td>
                    <x-botao.btn-editar :rota="route('socio.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                    <x-botao.btn-excluir :rota="route('socio.edit', 33)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
                </td>
            </tr>
          @endfor
        </tbody>
    </table>
  </div> 
  <div class="card-footer">
      <x-botao.btn-cadastrar :rota="route('socio.create')" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota" />
  </div> 
</div>