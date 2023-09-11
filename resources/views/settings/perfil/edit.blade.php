@extends('layouts.app')
@section('content')
    <div class="card">
        <form action="{{ route('perfil.update', $perfil->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" name="nome" class="form-control" value="{{ $perfil->nome }}">
                </div>
                <div class="form-group">
                    <label>Descrição:</label>
                    <input type="text" name="descricao" class="form-control" value="{{ $perfil->descricao }}">
                </div>
            </div>
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover  table-striped">
                        <thead>
                            <tr>
                                <th colspan="3"></th>
                                <th width="5%" colspan="{{ count($permissoes) }}" class="text-center">
                                    Permissões Gerais
                                </th>
                            </tr>
                            <tr>
                                <th>Permissões</th>
                                <th>Modulo</th>
                                <th>Descrição</th>
                                @if ($permissoes)
                                    @foreach ($permissoes as $permissao)
                                        <th class="text-center">{{ $permissao->nome }}</th>
                                    @endforeach
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if ($modulos)
                                @foreach ($modulos as $k => $modulo)
                                    <tr>
                                        <td class="text-center">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox"
                                                    id="moduloCheckbox{{ $modulo->id }}" value="{{ $modulo->id }}"
                                                    name="modulos[]" @if (in_array($modulo->id, $listArrayModulos)) checked @endif>
                                                <label for="moduloCheckbox{{ $modulo->id }}"
                                                    class="custom-control-label"></label>
                                            </div>
                                        </td>
                                        <td>{{ $modulo->nome }}</td>
                                        <td>{{ $modulo->descricao }}</td>
                                        @if ($permissoes)
                                            @foreach ($permissoes as $permissao)
                                                <td class="text-center">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox"
                                                            name="permissoes[{{ $modulo->id }}][]permissao[]"
                                                            class="custom-control-input"
                                                            id="permissaoCheckbox{{ $modulo->id }}{{ $permissao->id }}"
                                                            value="{{ $permissao->id }}"
                                                            @if (array_key_exists($modulo->id, $listArraypermissoes)) @foreach ($listArraypermissoes as $modusssslo => $ssss)
                                                                    @if ($modusssslo == $modulo->id)
                                                                        @foreach ($ssss as $item)
                                                                            @if ($item->permissao_id == $permissao->id)
                                                                                checked @endif
                                                            @endforeach
                                            @endif
                                        @endforeach
                                @endif
                                >
                                <label for="permissaoCheckbox{{ $modulo->id }}{{ $permissao->id }}"
                                    class="custom-control-label"></label>
                </div>
                </td>
                @endforeach
                @endif
                </tr>
                @endforeach
                @endif
                </tbody>
                </table>
            </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn bg-gradient-primary">
            <i class="fas fa-save" aria-hidden="true"></i>
            Salvar
        </button>
        <a href="{{ route('perfil.index') }}" title="Voltar" class="btn btn-danger">
            <i class="fa fa-reply"></i> Voltar
        </a>
    </div>
    </form>
    </div>
@endsection
