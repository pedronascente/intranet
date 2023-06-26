@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('colaborador.create') }}" class="btn btn-block bg-gradient-primary btn-md">
                    Novo registro
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th width="5%">Foto</th>
                        <th>Nome</th>
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
                                    <a href="/colaborador/{{ $item->id }}" title="Visualizar">
                                        <img src="{{ asset('img/colaborador/' . $item->foto . '') }}"
                                            alt="{{ $item->nome }}" width="35" class="rounded-circle">
                                    </a>
                                </td>
                                <td>{{ $item->nome }} {{ $item->sobrenome }}</td>
                                <td>{{ $item->empresa->nome }}</td>
                                <td>{{ $item->cargo->nome }}</td>
                                <td>
                                    <div class=" float-right">
                                        <a href="/colaborador/{{ $item->id }}/edit" class="btn btn-md btn-primary"
                                            title="Editar">
                                            <i class="fas fa-pencil-alt"></i> Editar
                                        </a>

                                        <a href="/colaborador/{{ $item->id }}" class="btn  btn-md btn-warning"
                                            title="Visualizar">
                                            <i class="fas fa-solid fa-eye"></i> Visualizar
                                        </a>
                                        <form action="{{ route('colaborador.destroy', $item->id) }}" method="post"
                                            style="display: inline">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn  btn-md btn-danger" title="Excluir">
                                                <i class="fas fa-times"></i> Excluir
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

    </div>
@endsection
