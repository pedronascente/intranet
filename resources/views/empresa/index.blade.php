@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('empresa.create') }}" class="btn btn-block bg-gradient-primary btn-sm">
                    Novo
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Empresa</th>
                        <th width="5%" class="text-center">Permições</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collection)
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->nome }}</td>
                                <td>
                                    <div class="btn-group float-right">
                                        <a href="/empresa/{{ $item->id }}/edit" class="btn btn-default">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('empresa.destroy', $item->id) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                        <a href="empresa/{{ $item->id }}" class="btn btn-default">
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
                        Mostrando 1 à 10 de 57 entradas</div>
                </div>
                <div class="col-sm-12 col-md-7">
                    {!! $collection->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
