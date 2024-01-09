@extends('layouts.app')

@section('titulo', 'Perfil | Cadastrar')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
           <a href="/configuracoes">Configurações</a> /
           <a href="/configuracoes/perfil">perfil</a> 
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <form action="{{ route('perfil.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" name="nome" class="form-control @error('nome') is-invalid  @enderror"
                        placeholder="nome" value="{{ old('nome') }}">
                    @error('nome')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Descrição:</label>
                    <input type="text" name="descricao" class="form-control @error('descricao') is-invalid  @enderror"
                        placeholder="Breve descrição" value="{{ old('descricao') }}">
                    @error('descricao')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
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
                                <th width="5%" >Permissões</th>
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
                                @foreach ($modulos as $modulo)
                                    <tr>
                                        <td class="text-center">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox"
                                                    id="moduloCheckbox{{ $modulo->id }}" value="{{ $modulo->id }}"
                                                    name="modulos[]">
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
                                                            value="{{ $permissao->id }}" class="custom-control-input"
                                                            id="permissaoCheckbox{{ $modulo->id }}{{ $permissao->id }}">
                                                        <label
                                                            for="permissaoCheckbox{{ $modulo->id }}{{ $permissao->id }}"
                                                            class="custom-control-label">
                                                        </label>
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
                <x-botao.btn-salvar />
                <a href="{{ route('perfil.index') }}" title="Voltar" class="btn btn-sm btn-danger">
                    <i class="fa fa-reply"></i> Voltar
                </a>
            </div>
        </form>
    </div>
@endsection
