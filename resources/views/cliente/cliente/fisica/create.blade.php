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
                <h3>Pessoa Física</h3>
            </div>
            <div class="card-body">
                 <form action="{{ route('cliente.store') }}" method="POST"   >
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>CPF:</label>
                                    <input type="text" name="cpf" maxlength="190"
                                        class="form-control @error('cpf') is-invalid  @enderror" placeholder="cpf"
                                        value="{{ old('cpf') }}">
                                    @error('cpf')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Data Nascimento:</label>
                                    <input type="text" name="data_nascimento" maxlength="20" placeholder=""
                                        class="form-control @error('data_nascimento') is-invalid  @enderror" value="{{ old('data_nascimento') }}">
                                    @error('data_nascimento')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>RG:</label>
                                    <input type="text" name="rg" maxlength="20" placeholder="rg"
                                        class="form-control @error('rg') is-invalid  @enderror" value="{{ old('rg') }}">
                                    @error('rg')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                     <label>Estado cívil:</label>
                                        <select name="estado_civil" class="custom-select ">
                                            <option value="">Selecione...</option>
                                            <option value="casado">Casado</option>
                                            <option value="solteiro" selected="">Solteiro</option>
                                            <option value="divorciado">Divorciado</option>
                                        </select>
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
