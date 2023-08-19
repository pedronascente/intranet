@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3>
                <a href="{{ route('perfil.create') }}" class="btn btn-primary btn-block ">
                    <i class="fas fa-solid fa-plus"></i> Cadastrar
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap  table-striped">
                <thead>
                    <tr>
                        <th>Perfil</th>
                        <th>Descrição</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collections)
                        @foreach ($collections as $item)
                            <tr>
                                <td>{{ $item->nome }}</td>
                                <td>{{ $item->descricao }}</td>
                                <td class="text-center">
                                    <a href="{{ route('perfil.edit', $item->id) }}" class="btn btn-primary" title="Editar">
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
    </div>
    <x-ui.modalDelete modulo="perfil" />
@endsection
