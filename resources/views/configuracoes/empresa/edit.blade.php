@extends('layouts.app')

@section('titulo', 'Empresa | Editar')

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
        <form action="{{ route('empresa.update', $empresa->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nome:</label>
                            <input type="text" name="nome" maxlength="190"
                                class="form-control @error('nome') is-invalid  @enderror" placeholder="Nome"
                                value="{{ $empresa->nome }}">
                            @error('nome')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cnpj:</label>
                            <input type="text" name="cnpj" maxlength="20" placeholder="__.__.___/_____-__"
                                class="form-control @error('cnpj') is-invalid  @enderror"
                                data-inputmask="'alias': '99.999.999/9999-99'" data-mask="" inputmode="decimal"
                                value="{{ $empresa->cnpj }}">
                            @error('cnpj')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
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
                <button type="submit" class="btn btn-sm bg-gradient-primary">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    Salvar
                </button>
                <a href="{{ route('empresa.index') }}" title="Voltar" class="btn btn-sm btn-danger">
                    <i class="fa fa-reply"></i> Voltar
                </a>
            </div>
        </form>
    </div>
@endsection
