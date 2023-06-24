@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('register') }}" class="btn btn-block bg-gradient-primary btn-sm">
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
                        <th width="30%">Usuário</th>
                        <th width="30%">Perfil</th>
                        <th width="5%"> Ativo</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collections)
                        @foreach ($collections as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->grupo->nome }}</td>
                                <td>
                                    @if ($item->ativo == 'on')
                                        Sim
                                    @else
                                        Não
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
    </div>
@endsection
