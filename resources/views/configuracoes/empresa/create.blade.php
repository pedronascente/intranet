@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Empresa | Cadastrar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/configuracoes">Configurações/</a>empresa</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card card-default">
        <form action="{{ route('empresa.store') }}" method="POST" name="Formulario-Empresa-create">
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
            </div>
            <div class="card-footer">
                <button type="submit" class="btn bg-gradient-primary">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    Salvar
                </button>
                <a href="{{ route('empresa.index') }}" title="Voltar" class="btn btn-danger">
                    <i class="fa fa-reply"></i> Voltar
                </a>
            </div>
        </form>
    </div>
@endsection
