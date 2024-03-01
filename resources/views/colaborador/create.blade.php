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
        <div class="card">
            <form action="{{ route('colaborador.store') }}" method="POST" enctype="multipart/form-data"
                name="Formulario-create">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Número da Matricula:</label>
                                <input type="text" name="numero_matricula" maxlength="10"
                                    class="form-control @error('numero_matricula') is-invalid  @enderror" placeholder="000000000"
                                    value="{{ old('numero_matricula') }}">
                                @error('numero_matricula')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Ramal:</label>
                                <input type="text" name="ramal" maxlength="4"
                                    class="form-control @error('ramal') is-invalid  @enderror" placeholder="0000"
                                    value="{{ old('ramal') }}">
                                @error('ramal')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nome:</label>
                                <input type="text" name="nome" maxlength="190"
                                    class="form-control @error('nome') is-invalid  @enderror" placeholder="Nome"
                                    value="{{ old('nome') }}">
                                @error('nome')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="text" name="email" maxlength="190"
                                    class="form-control @error('email') is-invalid  @enderror" placeholder="Email"
                                    value="{{ old('email') }}">
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
                                    class="form-control @error('rg') is-invalid  @enderror" value="{{ old('rg') }}"
                                    data-inputmask="'alias': '999999999999999'" data-mask="" inputmode="decimal">
                                @error('rg')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>CPF:</label>
                                <input type="text" name="cpf" maxlength="20" placeholder="___.___.___/__"
                                    class="form-control @error('cpf') is-invalid  @enderror" value="{{ old('cpf') }}"
                                    data-inputmask="'alias': '999.999.999/99'" data-mask="" inputmode="decimal">
                                @error('cpf')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cnpj:</label>
                                <input type="text" name="cnpj" maxlength="20" placeholder="__.__.___/_____-__"
                                    class="form-control @error('cnpj') is-invalid  @enderror" value="{{ old('cnpj') }}"
                                    data-inputmask="'alias': '99.999.999/9999-99'" data-mask="" inputmode="decimal">
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
                                        <option value="{{ $item->id }}" @if (old('base_id') == $item->id) selected @endif>
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
                                <label>Empresa:</label>
                                <select name="empresa_id" class="custom-select @error('empresa_id') is-invalid @enderror">
                                    <option value="">...</option>
                                    @foreach ($empresas as $item)
                                        <option value="{{ $item->id }}"
                                            @if (old('empresa_id') == $item->id) selected @endif>
                                            {{ $item->nome }}</option>
                                    @endforeach
                                </select>
                                @error('empresa_id')
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
                                        <option value="{{ $item->id }}"
                                            @if (old('cargo_id') == $item->id) selected @endif>
                                            {{ $item->nome }}</option>
                                    @endforeach
                                </select>
                                @error('cargo_id')
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
                                    <input type="file" name="foto" class="custom-file-input" id="customFile"
                                        class=" @error('foto') is-invalid @enderror" value="{{ old('foto') }}">
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
                    <x-botao.btn-salvar />
                    <x-botao.btn-voltar :rota="route('colaborador.index')" />
                </div>
            </form>
        </div>
    </div>
@endsection
