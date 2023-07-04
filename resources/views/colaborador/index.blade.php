@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('colaborador.create') }}" class="btn btn-info btn-block ">
                    Adicionar novo colaborador
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th width="5%">Foto</th>
                        <th width="15%">Nome</th>
                        <th>Empresa</th>
                        <th>Cargo</th>
                        <th width="10%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collection)
                        @foreach ($collection as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('colaborador.show', $item->id) }}" title="Visualizar">
                                        <img src="{{ asset('img/colaborador/' . $item->foto . '') }}"
                                            alt="{{ $item->nome }}" width="35" class="rounded-circle">
                                    </a>
                                </td>
                                <td>{{ $item->nome }} {{ $item->sobrenome }}</td>
                                <td>{{ $item->empresa->nome }}</td>
                                <td>{{ $item->cargo->nome }}</td>
                                <td class="text-center">
                                    <a href="{{ route('colaborador.edit', $item->id) }}" title="Editar"
                                        style="padding-right: 10px">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('colaborador.show', $item->id) }}" title="Visualizar"
                                        style="padding-right: 10px">
                                        <i class="fas  fa-eye"></i>
                                    </a>
                                    <form action="{{ route('colaborador.destroy', $item->id) }}" method="post"
                                        style="display: inline" title="Excluir">
                                        @method('DELETE')
                                        @csrf
                                        <a href="{{ route('colaborador.destroy', $item->id) }}"
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
            @if (@isset($collection))
                <div class="row">
                    <div class="col-sm-12 col-md-7">
                        {!! $collection->links() !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
