  <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item">
          <a href="{{ route('planilha-colaborador.index') }}">Planilhas</a> /
          <a href="{{ route('planilha-colaborador-tipo.index', $comissao->planilha_id) }}">
              {{ $titulo }}
          </a>
      </li>
  </ol>
