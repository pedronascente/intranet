@extends('layouts.iframe')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3>
                <a href="{{ route('user.create') }}" class="btn btn-primary  btn-block ">
                    <i class="fas fa-solid fa-plus"></i> Cadastrar
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap  table-striped">
                <thead>
                    <tr>
                        <th width="50%">Usuário</th>
                        <th width="45%"> Status</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collections)
                        @foreach ($collections as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @if ($item->status == 'on')
                                        Ativo
                                    @else
                                        Inativo
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('user.show', $item->id) }}" title="Visualizar"
                                        class="btn btn-warning">
                                        <i class="fas  fa-eye"></i>
                                    </a>
                                    <a href="{{ route('user.edit', $item->id) }}" class="btn btn-primary" title="Editar">
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
            @if (@isset($collections))
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        {!! $collections->links() !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
    <x-ui.modalDelete modulo="usuario" />
@endsection
