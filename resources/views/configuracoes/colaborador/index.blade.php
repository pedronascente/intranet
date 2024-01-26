@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
           <a href="/configuracoes">Configurações</a> /
           <a href="{{ route('colaborador.index') }}">colaborador</a>
        </li>
    </ol>
@endsection 

@section('content')
    <div class="card p-3">
        <x-botao.btn-cadastrar :rota="route('colaborador.create')" />
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap table-striped">
                    <thead>
                        <tr>
                            <th width="5%">Foto</th>
                            <th width="5%"> Matricula</th>
                            <th>Colaborador</th>
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
                                    <td>{{ $item->numero_matricula }}</td>
                                    <td>{{ $item->nome }} {{ $item->sobrenome }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('colaborador.show', $item->id) }}" title="Visualizar"
                                            class="btn btn-sm btn-primary ">
                                            <i class="fas fa-folder"></i> Visualizar
                                        </a>
                                        <x-botao.btn-editar :rota="route('colaborador.edit', $item->id)"/>
                                        <x-botao.btn-excluir :rota="route('colaborador.destroy', $item->id)" titulo="Excluir Colaborador" />
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
    </div>
    <x-ui.modalDelete />
@endsection
