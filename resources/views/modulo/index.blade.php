@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('modulo.create') }}" class="btn btn-block bg-gradient-primary btn-sm">
                    Novo
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>Módulo</th>
                        <th>Descrição</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($collection as $item)
                        <tr>
                            <td>{{ $item->nome }}</td>
                            <td>{{ $item->descricao }}</td>
                            <td>
                                <div class="btn-group float-right">
                                    <a href="/modulo/{{ $item->id }}/edit" class="btn btn-sm btn-default">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('modulo.destroy', $item->id) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-default">
                                            <i class="fas fa-times"></i>
                                        </button>
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
