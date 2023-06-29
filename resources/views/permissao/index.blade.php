@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('permissao.create') }}" class="btn btn-block bg-gradient-primary" title="Novo registro">
                    Novo registro
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collection)
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{ $item->nome }}</td>
                                <td>
                                    <div class="float-right">
                                        <a href="/permissao/{{ $item->id }}/edit" class="btn bg-gradient-primary"
                                            title="Editar">
                                            <i class="fas fa-pencil-alt"></i> Editar
                                        </a>
                                        <form action="{{ route('permissao.destroy', $item->id) }}" method="post"
                                            style="display: inline">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn bg-gradient-danger" title="Excluir">
                                                <i class="fas fa-trash"></i> Excluir
                                            </button>
                                        </form>
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
                <div class="col-sm-12 col-md-7">
                    {!! $collection->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
