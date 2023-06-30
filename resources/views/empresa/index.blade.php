@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('empresa.create') }}" class="btn btn-info btn-block ">
                    Adicionar novo empresa
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Cnpj</th>
                        <th width="20%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collection)
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{ $item->nome }}</td>
                                <td>{{ $item->cnpj }}</td>
                                <td class="text-center">
                                    <a href="{{ route('empresa.edit', $item->id) }}" title="Editar"
                                        style="padding-right: 10px">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('empresa.show', $item->id) }}" title="visualizar"
                                        style="padding-right: 10px">
                                        <i class="fas fa-solid fa-eye"></i>
                                    </a>
                                    <form action="{{ route('empresa.destroy', $item->id) }}" method="post"
                                        style="display: inline ;" title="Excluir">
                                        @method('DELETE')
                                        @csrf
                                        <a href="{{ route('empresa.destroy', $item->id) }}"
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
                <div class="col-sm-12 col-md-7">
                    {!! $collection->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
