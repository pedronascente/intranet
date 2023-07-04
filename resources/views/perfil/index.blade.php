@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('perfil.create') }}" class="btn btn-info btn-block ">
                    Adicionar novo perfil
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
                        <th>Perfil</th>
                        <th>Descrição</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collections)
                        @foreach ($collections as $item)
                            <tr>
                                <td>{{ $item->nome }}</td>
                                <td>{{ $item->descricao }}</td>
                                <td class="text-center">
                                    <a href="perfil/{{ $item->id }}" title="Visualizar" style="padding-right:10px">
                                        <i class="fas fa-solid fa-eye"></i>
                                    </a>
                                    <form action="{{ route('perfil.destroy', $item->id) }}" method="post"
                                        style="display: inline; padding-right: 10px" title="Excluir">
                                        @method('DELETE')
                                        @csrf
                                        <a href="{{ route('perfil.destroy', $item->id) }}"
                                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </form>
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
