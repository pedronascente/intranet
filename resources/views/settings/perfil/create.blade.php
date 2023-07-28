@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Novo</h4>
                    </div>
                    <form action="{{ route('perfil.store') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nome:</label>
                                <input type="text" name="nome"
                                    class="form-control @error('nome') is-invalid  @enderror" placeholder="nome"
                                    value="{{ old('nome') }}">
                                @error('nome')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Descrição:</label>
                                <input type="text" name="descricao" class="form-control" placeholder="Breve descrição">
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover  table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="3"></th>
                                            <th width="5%" colspan="{{ count($permissoes) }}" class="text-center">
                                                Permissões Gerais</th>
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
                                            @foreach ($modulos as $item)
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox"
                                                                id="moduloCheckbox{{ $item->id }}"
                                                                value="{{ $item->id }}" name="modulo[]">
                                                            <label for="moduloCheckbox{{ $item->id }}"
                                                                class="custom-control-label"></label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $item->nome }}</td>
                                                    <td>{{ $item->descricao }}</td>
                                                    @if ($permissoes)
                                                        @foreach ($permissoes as $permissao)
                                                            <td class="text-center">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input class="" type="checkbox"
                                                                        value="{{ $permissao->id }}"
                                                                        name="permissoes[{{ $item->nome }}][]permissao[]">
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
