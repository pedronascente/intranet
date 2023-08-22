@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            @if (session()->get('perfil'))
                @foreach (session()->get('perfil')['permissoes'][1] as $item)
                    @if ($item->nome == 'Criar')
                        <h3>
                            <a href="{{ route('cargo.create') }}" class="btn btn-primary btn-block ">
                                <i class="fas fa-solid fa-plus"></i> Cadastrar
                            </a>
                        </h3>
                    @endif
                @endforeach
            @endif
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
                        @foreach ($collection as $cargo)
                            <tr>
                                <td>{{ $cargo->nome }}</td>
                                <td class="text-center">
                                    @if (session()->get('perfil'))
                                        @foreach (session()->get('perfil')['permissoes'][1] as $item)
                                            @if ($item->nome == 'Editar')
                                                <a href="{{ route('cargo.edit', $cargo->id) }}" class="btn btn-primary"
                                                    title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            @if ($item->nome == 'Excluir')
                                                <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#deleteModal" data-id="{{ $cargo->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif
                                        @endforeach
                                    @endif
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
    <x-ui.modalDelete modulo="cargo" />
@endsection
