@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('modulo.create') }}" class="btn btn-info btn-block ">
                    Adicionar novo modulo
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>Módulo</th>
                        <th>Descrição</th>
                        <th width="10%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($collection as $item)
                        <tr>
                            <td>{{ $item->nome }}</td>
                            <td>{{ $item->descricao }}</td>
                            <td>
                                <div class="text-center">
                                    <a href="{{ route('modulo.edit', $item->id) }}" title="Editar"
                                        style="padding-right: 10px">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('modulo.destroy', $item->id) }}" method="post"
                                        style="display: inline" title="Excluir">
                                        @method('DELETE')
                                        @csrf
                                        <a href="{{ route('modulo.destroy', $item->id) }}"
                                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer ">
            <div class="row">
                <div class="col-sm-12 col-md-7">
                    {!! $collection->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
