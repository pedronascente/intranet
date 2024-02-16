@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editar Meu Perfil  </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="/meu-perfil">Meu Perfil</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <form action="{{ route('colaborador.update', $colaborador->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Ramal:</label>
                            <input type="text" name="ramal" maxlength="4" class="form-control @error('ramal') is-invalid  @enderror" placeholder="Ramal"
                                value="{{ $colaborador->ramal}}">
                                @error('ramal')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nome:</label>
                            <input type="text" name="nome" maxlength="190" placeholder="Nome"
                                value="{{ $colaborador->nome }}" class="form-control @error('nome') is-invalid  @enderror">
                            @error('nome')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sobre Nome:</label>
                            <input type="text" name="sobrenome" maxlength="190" placeholder="Sobre Nome"
                                value="{{ $colaborador->sobrenome }}"
                                class="form-control @error('sobrenome') is-invalid  @enderror">
                            @error('sobrenome')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="text" name="email" maxlength="190" placeholder="Email"
                                value="{{ $colaborador->email }}"
                                class="form-control @error('email') is-invalid  @enderror">
                            @error('email')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>RG:</label>
                            <input type="text" name="rg" maxlength="20" placeholder="______________"
                                data-inputmask="'alias': '999999999999999'" data-mask="" inputmode="decimal"
                                value="{{ $colaborador->rg }}" class="form-control @error('rg') is-invalid  @enderror">
                            @error('rg')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>CPF:</label>
                            <input type="text" name="cpf" maxlength="20" placeholder="___.___.___/__"
                                data-inputmask="'alias': '999.999.999/99'" data-mask="" inputmode="decimal"
                                value="{{ $colaborador->cpf }}" class="form-control @error('cpf') is-invalid  @enderror">
                            @error('cpf')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cnpj:</label>
                            <input type="text" name="cnpj" maxlength="20" placeholder="__.__.___/_____-__"
                                data-inputmask="'alias': '99.999.999/9999-99'" data-mask="" inputmode="decimal"
                                class="form-control @error('cnpj') is-invalid  @enderror" value="{{ $colaborador->cnpj }}">
                            @error('cnpj')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Base:</label>
                            <select name="base_id" class="custom-select @error('base_id') is-invalid @enderror">
                                <option value="">...</option>
                                @foreach ($bases as $item)
                                    <option value="{{ $item->id }}" @if ($colaborador->base->id == $item->id) selected @endif>
                                        {{ $item->nome }}</option>
                                @endforeach
                            </select>
                            @error('base_id')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cargo:</label>
                            <select name="cargo_id" class="custom-select @error('cargo_id') is-invalid @enderror">
                                <option value="">...</option>
                                @foreach ($cargos as $item)
                                    <option value="{{ $item->id }}" @if ($colaborador->cargo->id == $item->id) selected @endif>
                                        {{ $item->nome }}</option>
                                @endforeach
                            </select>
                            @error('cargo_id')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Empresa:</label>
                            <select name="empresa_id" class="custom-select @error('empresa_id') is-invalid @enderror">
                                <option value="">...</option>
                                @foreach ($empresas as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($colaborador->empresa->id == $item->id) selected @endif>
                                        {{ $item->nome }}</option>
                                @endforeach
                            </select>
                            @error('empresa_id')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="customFile">Foto</label>
                            <div class="custom-file">
                                <input type="file" name="foto"
                                    class="custom-file-input @error('empresa_id') is-invalid @enderror" id="customFile">
                                <label class="custom-file-label" for="customFile"></label>
                                @error('foto')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="editProfile" value="1">
                <input type="hidden" name="numero_matricula" maxlength="10" value="{{ $colaborador->numero_matricula }}">  
                <x-botao.btn-salvar />
            </div>
        </form>
    </div>
@endsection
