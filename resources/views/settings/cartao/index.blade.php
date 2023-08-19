@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3>
                <a href="{{ route('cartao.create') }}" class="btn btn-primary btn-block ">
                    <i class="fas fa-solid fa-plus"></i> Cadastrar
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th width="50%">Cartão</th>
                        <th width="45%">Status</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collections)
                        @foreach ($collections as $cartao)
                            <tr>
                                <td>{{ $cartao->nome }}</td>
                                <td>
                                    @if ($cartao->status == 'on')
                                        Ativo
                                    @else
                                        Inativo
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('cartao.show', $cartao->id) }}" title="visualizar"
                                        class="btn btn-warning">
                                        <i class="fas fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('cartao.edit', $cartao->id) }}" title="Editar"
                                        class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal"
                                        data-target="#deleteModal" data-id="{{ $cartao->id }}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
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
    <x-ui.modalDelete modulo="colaborador" />
@endsection
