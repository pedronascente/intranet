@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('perfil.create') }}" class="btn btn-block bg-gradient-primary ">
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
                        <th>ID</th>
                        <th>Perfil</th>
                        <th>Descrição</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collections)
                        @foreach ($collections as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->nome }}</td>
                                <td>{{ $item->descricao }}</td>
                                <td>
                                    <div class="float-right">
                                        <form action="{{ route('perfil.destroy', $item->id) }}" method="post"
                                            title="Excluir" style="display: inline">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn bg-gradient-danger">
                                                <i class="fas fa-times" aria-hidden="true"></i> Excluir
                                            </button>
                                        </form>
                                        <a href="perfil/{{ $item->id }}" class="btn bg-gradient-warning"
                                            title="Visualizar">
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
        <div class="card-footer">
            <div class="row">


            </div>
        </div>
    </div>
@endsection
