@extends('layouts.app')

@section('titulo', 'Empresa | Cadastrar')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes">Configurações</a> /
             <a href="/configuracoes/empresa">empresa</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card">
            <form action="{{ route('empresa.store') }}" method="POST" enctype="multipart/form-data"
                name="Formulario-Empresa-create">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Nome:</label>
                        <input type="text" name="nome" maxlength="190"
                            class="form-control @error('nome') is-invalid  @enderror" placeholder="Nome"
                            value="{{ old('nome') }}">
                        @error('nome')
                            <span class=" invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Cnpj:</label>
                        <input type="text" name="cnpj" maxlength="20" placeholder="__.__.___/_____-__"
                            class="form-control @error('cnpj') is-invalid  @enderror" value="{{ old('cnpj') }}"
                            data-inputmask="'alias': '99.999.999/9999-99'" data-mask="" inputmode="decimal">
                        @error('cnpj')
                            <span class=" invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="customFile">Logo:</label>
                        <div class="custom-file">
                            <input type="file" name="imglogo" class="custom-file-input" id="customFile"
                                class=" @error('imglogo') is-invalid @enderror" value="{{ old('imglogo') }}">
                            <label class="custom-file-label" for="customFile"></label>
                            @error('imglogo')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <x-botao.btn-salvar />
                    <x-botao.btn-voltar :rota="route('empresa.index')" />
                </div>
            </form>
        </div>
    </div>
@endsection
