@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
           <a href="{{ route('perfil.index') }}">Perfil</a> 
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <form action="{{ route('perfil.update',$perfil->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nome:</label>
                        <input type="text" name="nome" class="form-control @error('nome') is-invalid  @enderror"
                            placeholder="nome" value="{{ $perfil->nome }}">
                        @error('nome')
                            <span class=" invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Descrição:</label>
                        <input type="text" name="descricao" class="form-control @error('descricao') is-invalid  @enderror"
                            placeholder="Breve descrição" value="{{ $perfil->descricao }}">
                        @error('descricao')
                            <span class=" invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card"> 
                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-hover dataTable dtr-inline">
                        <thead>
                            <tr>
                                <th width="20%">Permissão</th>
                                <th>
                                    Modulo
                                    @error('ArrayListModulos')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </th>
                                <th>Descrição</th>
                                @foreach ($arrayListPermissoes as $permissao)
                                    <th class="text-center">{{ $permissao->nome }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @if($arraylistCategoriasEseusModulos)
                                @foreach ($arraylistCategoriasEseusModulos as $categoria)
                                    @php $firstModule = true; @endphp <!-- Flag para controlar a primeira linha de módulo -->
                                    @foreach ($categoria->modulos as $modulo)
                                        <tr>
                                            @if($firstModule)
                                                <!-- Mescla a célula de Permissão apenas na primeira linha do módulo -->
                                                <td rowspan="{{ count($categoria->modulos) }}">
                                                    <b>{{ $categoria->nome }}</b>
                                                </td>
                                                @php $firstModule = false; @endphp
                                            @endif
                                            <td class="p-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="moduloCheckbox{{ $modulo->id }}" value="{{ $modulo->id }}" name="ArrayListModulos[]" {{ in_array($modulo->id, $arrayListModulosAssociados) ? 'checked' : '' }}>
                                                    <label for="moduloCheckbox{{ $modulo->id }}" class="custom-control-label">
                                                        {{ $modulo->nome }}
                                                    </label>
                                                </div>
                                            </td>
                                            <td>{{ $modulo->descricao }}</td>
                                            @foreach ($arrayListPermissoes as $permissao)
                                                <td class="text-center">
                                                    <div class="custom-control custom-checkbox">
                                                        @php
                                                            $permissoesDoModulo = $perfil->getPermissao($modulo->id, $perfil->id)->pluck('id')->toArray();
                                                        @endphp
                                                        <input type="checkbox" name="ArrayListPermissoes[{{ $modulo->id }}][]" value="{{ $permissao->id }}" class="custom-control-input" id="permissaoCheckbox{{ $modulo->id }}{{ $permissao->id }}" {{ in_array($permissao->id, $permissoesDoModulo) ? 'checked' : '' }}>
                                                        <label for="permissaoCheckbox{{ $modulo->id }}{{ $permissao->id }}" class="custom-control-label"></label>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <x-botao.btn-salvar />
                <x-botao.btn-voltar :rota="route('perfil.index')" />
            </div>
        </form>
    </div>
@endsection
