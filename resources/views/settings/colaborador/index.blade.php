@extends('layouts.iframe')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3>
                <a href="{{ route('colaborador.create') }}" class="btn btn-primary  btn-block ">
                    <i class="fas fa-solid fa-plus"></i> Cadastrar
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th width="5%">Foto</th>
                        <th width="50%">Nome</th>
                        <th width="5%" class="text-center">Permissões</th>
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
                                <td class="text-center">
                                    <a href="{{ route('colaborador.show', $item->id) }}" title="Visualizar"
                                        class="btn btn-warning">
                                        <i class="fas  fa-eye"></i>
                                    </a>
                                    <a href="{{ route('colaborador.edit', $item->id) }}" title="Editar"
                                        class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal"
                                        data-target="#deleteModal" data-id="{{ $item->id }}">
                                        <i class="fas fa-trash"></i>
                                    </a>
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
    <x-ui.modalDelete modulo="colaborador" />
@endsection
