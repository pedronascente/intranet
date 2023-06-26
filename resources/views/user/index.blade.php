@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('user.register') }}" class="btn btn-block bg-gradient-primary btn-md">
                    Novo registro
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
                                    <div class="float-right">
                                        <a href="/user/{{ $item->id }}/edit" class="btn btn-primary" title="Editar">
                                            <i class="fas fa-pencil-alt"></i> Editar
                                        </a>
                                        <form action="{{ route('user.destroy', $item->id) }}" method="post"
                                            title="Desativar" style="display:inline">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                        <a href="user/{{ $item->id }}" class="btn btn-warning" title="Visualizar">
                                            <i class="fas fa-solid fa-eye"></i> Visualizar
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
