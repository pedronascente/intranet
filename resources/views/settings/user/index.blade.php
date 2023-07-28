@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('user.create') }}" class="btn btn-info btn-block " title=" Adicionar novo usuário">
                    Novo
                </a>
            </h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Pesquisar">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
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
                                    <a href="user/{{ $item->id }}" title="Visualizar" style="padding-right: 10px">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('user.edit', $item->id) }}" title="Editar"
                                        style="padding-right: 10px">
                                        <i class="fas fa-edit"></i>
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
@endsection
