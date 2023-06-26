@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('empresa.create') }}" class="btn btn-block bg-gradient-primary btn-md">
                    Novo registro
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Cnpj</th>
                        <th width="10%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collection)
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{ $item->nome }}</td>
                                <td>{{ $item->cnpj }}</td>
                                <td>
                                    <div class=" float-right">
                                        <a href="/empresa/{{ $item->id }}/edit" class="btn btn-md btn-primary">
                                            <i class="fas fa-pencil-alt"></i> Editar
                                        </a>
                                        <a href="empresa/{{ $item->id }}" class="btn  btn-md btn-warning">
                                            <i class="fas fa-solid fa-eye"></i> Visualizar
                                        </a>
                                        <form action="{{ route('empresa.destroy', $item->id) }}" method="post"
                                            style="display: inline">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn  btn-md btn-danger">
                                                <i class="fas fa-times"></i> Deletar
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
