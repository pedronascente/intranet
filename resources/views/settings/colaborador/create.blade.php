@extends('layouts.app')
@section('content')
    <div class="card card-default">
        <form action="{{ route('colaborador.store') }}" method="POST" enctype="multipart/form-data"
            name="Formulario-Colaborador-create">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sobre Nome:</label>
                            <input type="text" name="sobrenome" maxlength="190"
                                class="form-control @error('sobrenome') is-invalid  @enderror" placeholder="Sobre Nome"
                                value="{{ old('sobrenome') }}">
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
                            <label>Cargo:</label>
                            <select name="cargo_id" class="custom-select @error('cargo_id') is-invalid @enderror">
                                <option value="">...</option>
                                @foreach ($cargos as $item)
                                    <option value="{{ $item->id }}" @if (old('cargo_id') == $item->id) selected @endif>
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
                                    <option value="{{ $item->id }}" @if (old('empresa_id') == $item->id) selected @endif>
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
                <button type="submit" class="btn bg-gradient-primary">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    Salvar
                </button>
            </div>
        </form>
    </div>
@endsection
