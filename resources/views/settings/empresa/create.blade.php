@extends('layouts.iframe')
@section('content')
    <div class="card card-default">
        <div class="card-header">
            <h4>Novo</h4>
        </div>
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
                    Salvar</button>
            </div>
        </form>
    </div>
@endsection