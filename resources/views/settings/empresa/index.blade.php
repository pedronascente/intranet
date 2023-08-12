@extends('layouts.iframe')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3>
                <a href="{{ route('empresa.create') }}" class="btn btn-primary  btn-block ">
                    <i class="fas fa-solid fa-plus"></i> Cadastrar
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Cnpj</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collection)
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{ $item->nome }}</td>
                                <td>{{ $item->cnpj }}</td>
                                <td class="text-center">
                                    <a href="{{ route('empresa.edit', $item->id) }}" title="Editar" class="btn btn-primary">
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
            <div class="row">
                <div class="col-sm-12 col-md-7">
                    {!! $collection->links() !!}
                </div>
            </div>
        </div>
    </div>
    <x-ui.modalDelete modulo="empresa" />
@endsection
