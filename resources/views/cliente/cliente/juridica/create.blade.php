@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('cliente.index') }}">cliente</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card">
            <div class="card-header">
                <h3>Pessoa Juridica</h3>
            </div>
            <div class="card-body">
                 <form action="{{ route('cliente.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Razão Social:</label>
                                    <input type="text" name="razao_social" maxlength="190"
                                        class="form-control @error('razao_social') is-invalid  @enderror" placeholder="Razão Ssocial"
                                        value="{{ old('razao_social') }}">
                                    @error('razao_social')
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
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Insc. Municipal:</label>
                                    <input type="text" name="socio_um" maxlength="190"
                                        class="form-control @error('socio_um') is-invalid  @enderror" placeholder="Sócio"
                                        value="{{ old('socio_um') }}">
                                    @error('socio_um')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>RG / Insc. Estadual:</label>
                                    <input type="text" name="cpf_socio_um" maxlength="20" placeholder="___.___.___-__"
                                        class="form-control @error('cpf_socio_um') is-invalid  @enderror" value="{{ old('cpf_socio_um') }}"
                                        data-inputmask="'alias': '99.999.999-99'" data-mask="" inputmode="decimal">
                                    @error('cpf_socio_um')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        </div>
                    </div>
                    <div class="card-footer">
                        <x-botao.btn-salvar />
                        <x-botao.btn-voltar :rota="route('cliente.create')" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection