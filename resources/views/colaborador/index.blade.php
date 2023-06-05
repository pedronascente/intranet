@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('colaborador.create') }}" class="btn btn-block bg-gradient-primary btn-sm">
                    Novo
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th width="5%">COD</th>
                        <th width="5%">Foto</th>
                        <th>Nome</th>
                        <th>Sobre Nome</th>
                        <th>Cargo</th>
                        <th>Empresa</th>
                        <th width="5%" class="text-center">Permições</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($collection)
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    <img src="{{ asset('dist/img/dummy-round.png') }}" alt="" width="50">
                                </td>
                                <td>{{ $item->nome }}</td>
                                <td>{{ $item->sobrenome }}</td>
                                <td>{{ $item->cargo->nome }}</td>
                                <td>{{ $item->empresa->nome }}</td>
                                <td>
                                    <div class="btn-group float-right">
                                        <a href="/colaborador/{{ $item->id }}/edit" class="btn btn-sm btn-default">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('colaborador.destroy', $item->id) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn  btn-sm btn-default">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                        <a href="/colaborador/{{ $item->id }}" class="btn  btn-sm btn-default">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
                        Mostrando 1 à 10 de 57 entradas</div>
                </div>
                <div class="col-sm-12 col-md-7">
                    {!! $collection->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
