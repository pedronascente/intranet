@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('cargo.create') }}" class="btn btn-block bg-gradient-primary btn-md">
                    Novo registro
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>Cargo</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if (@isset($collection))
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{ $item->nome }}</td>
                                <td>
                                    <div class="float-right">
                                        <a href="/cargo/{{ $item->id }}/edit" class="btn btn-md btn-primary">
                                            <i class="fas fa-pencil-alt"></i> Editar
                                        </a>
                                        <form action="{{ route('cargo.destroy', $item->id) }}" method="post"
                                            style="display: inline">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn  btn-md btn-danger">
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
        @if (@isset($collection))
            <div class="card-footer">
                <div class="row">

                    <div class="col-sm-12 col-md-7">

                        {!! $collection->links() !!}

                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
