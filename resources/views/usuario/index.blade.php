@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('usuario.create') }}" class="btn btn-block bg-gradient-primary btn-sm">
                    Novo
                </a>
            </h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Pesquisar">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap  table-striped">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="25%">Usuário</th>
                        <th width="25%">Colaborador</th>
                        <th>Email</th>
                        <th width="5%">Status</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collections)
                        @foreach ($collections as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->usuario }}</td>
                                <td>
                                    <a href="/colaborador/{{ $item->colaborador->id }}">{{ $item->colaborador->nome }}</a>
                                </td>
                                <td>{{ $item->colaborador->email }}</td>
                                <td>
                                    @if ($item->ativo == 'on')
                                        Sim - Ativo
                                    @else
                                        Não - Ativo
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group float-right">
                                        <a href="/usuario/{{ $item->id }}/edit" class="btn btn-default" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('usuario.destroy', $item->id) }}" method="post"
                                            title="Desativar">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-default">
                                                <i class="fa fa-toggle-on" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                        <a href="usuario/{{ $item->id }}" class="btn btn-default" title="Visualizar">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="card-footer ">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
                        Mostrando 1 à 10 de 57 entradas
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                        <ul class="pagination">
                            <li class="paginate_button page-item previous disabled" id="example2_previous">
                                <a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0"
                                    class="page-link">Previous</a>
                            </li>
                            <li class="paginate_button page-item active"><a href="#" aria-controls="example2"
                                    data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                            <li class="paginate_button page-item "><a href="#" aria-controls="example2"
                                    data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
                            <li class="paginate_button page-item "><a href="#" aria-controls="example2"
                                    data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
                            <li class="paginate_button page-item "><a href="#" aria-controls="example2"
                                    data-dt-idx="4" tabindex="0" class="page-link">4</a></li>
                            <li class="paginate_button page-item "><a href="#" aria-controls="example2"
                                    data-dt-idx="5" tabindex="0" class="page-link">5</a></li>
                            <li class="paginate_button page-item "><a href="#" aria-controls="example2"
                                    data-dt-idx="6" tabindex="0" class="page-link">6</a></li>
                            <li class="paginate_button page-item next" id="example2_next"><a href="#"
                                    aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
