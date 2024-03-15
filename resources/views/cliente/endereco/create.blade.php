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
                 <form action="{{ route('colaborador.store') }}" method="POST" enctype="multipart/form-data"  name="Formulario-create">
                    @csrf
                    <div class="card-body">
                           <div class="row">
                            <div class="col-md-12">
                                <h3>Endereço de Entrega</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Cep:</label>
                                    <input type="text" name="nome" maxlength="190"
                                        class="form-control @error('nome') is-invalid  @enderror" placeholder="Nome"
                                        value="{{ old('nome') }}">
                                    @error('nome')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>UF:</label>
                                    <input type="text" name="uf" maxlength="20" placeholder=""
                                        class="form-control @error('uf') is-invalid  @enderror" value="{{ old('uf') }}" >
                                    @error('cnpj')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Numero:</label>
                                    <input type="text" name="numero" maxlength="20" placeholder=""
                                        class="form-control @error('numero') is-invalid  @enderror" value="{{ old('numero') }}">
                                    @error('numero')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Endereço:</label>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cidade:</label>
                                    <input type="text" name="cidade" maxlength="190"
                                        class="form-control @error('cidade') is-invalid  @enderror" placeholder="cidade"
                                        value="{{ old('cidade') }}">
                                    @error('nome')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bairro:</label>
                                    <input type="text" name="cidade" maxlength="190"
                                        class="form-control @error('cidade') is-invalid  @enderror" placeholder="cidade"
                                        value="{{ old('cidade') }}">
                                    @error('nome')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Complemento:</label>
                                    <input type="text" name="cidade" maxlength="190"
                                        class="form-control @error('cidade') is-invalid  @enderror" placeholder="cidade"
                                        value="{{ old('cidade') }}">
                                    @error('nome')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
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
