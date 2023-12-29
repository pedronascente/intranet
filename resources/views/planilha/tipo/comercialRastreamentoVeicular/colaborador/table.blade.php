@if ($listaComissao->count() > 0)
    <table class="table table-hover table-bordered text-nowrap table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Data</th>
                <th>Cliente</th>
                <th>ID Contrato</th>
                <th>Placa</th>
                <th>Tx. Instalação</th>
                <th>Mensal</th>
                <th>Comissão</th>
                <th>Desconto</th>
                <th width="5%" class="text-center">Permissões</th>
            </tr>
        </thead>
        <tbody>
            @if ($listaComissao)
                @foreach ($listaComissao as $comissao)
                    <tr>
                        <td>{{ $comissao->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($comissao->data)->format('d/m/Y') }}</td>
                        <td>{{ $comissao->cliente }}</td>
                        <td>{{ $comissao->id_contrato }}</td>
                        <td>{{ $comissao->placa }}</td>
                        <td>R$ {{ $comissao->taxa_instalacao }}</td>
                        <td>R$ {{ $comissao->mensal }}</td>
                        <td>R$ {{ $comissao->comissao }}</td>
                        <td>R$ {{ $comissao->desconto_comissao }}</td>
                        <td>
                            <a href="{{ route('comercial-rastreamento-veicular.edit', $comissao->id) }}"
                                class="btn btn-primary btn-sm" title="Editar comissão">
                                <i class="nav-icon fas fa-edit"></i> Editar
                            </a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#deleteModal"
                                data-route="{{ route('comercial-rastreamento-veicular.destroy', $comissao->id) }}"
                                title="Excluir comissão">
                                <i class="fas fa-trash"></i> Excluir
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
            <tr>
                <td colspan="10">
                    <div class="row">
                        <div class="col-md-6"><b>{{ $listaComissao->total() }}</b> Registros Encontrados.</div>
                        <div class="col-md-6 text-right">Valor Total <b>R$ {{ $valorTotalComissao }}</b></div>
                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="10">
                    @if ($listaComissao)
                        {{ $listaComissao->links() }}
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>
@else
    <p class="text-center">Nenhum registro encontrado.</p>
@endif
