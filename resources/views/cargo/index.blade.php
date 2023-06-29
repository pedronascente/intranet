@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('cargo.create') }}" class="btn btn-info btn-block ">
                    Adicionar novo modulo
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>Cargo</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @if (@isset($collection))
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{ $item->nome }}</td>
                                <td class="text-center">
                                    <div class="float-right">
                                        <a href="/cargo/{{ $item->id }}/edit" title="Editar"
                                            style="padding-right: 10px">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('cargo.destroy', $item->id) }}" method="post"
                                            style="display: inline ;padding-right: 10px" title="Excluir">
                                            @method('DELETE')
                                            @csrf
                                            <a href="{{ route('cargo.destroy', $item->id) }}"
                                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        @if (@isset($collection))
            <div class="card-footer">
                <div class="row">

                    <div class="col-sm-12 col-md-7">

                        {!! $collection->links() !!}

                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
