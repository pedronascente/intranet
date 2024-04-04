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
          
        @include('cliente.cliente.cliente_cpf') 
         
        <div class="card">
            <div class="card-header">
              <h4> Veículo</h4>
          </div>
            <div class="card-body">
                 <form action="{{ route('endereco.store') }}" method="POST"   name="Formulario-create">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label>Placa:</label>
                                    <input type="text" name="placa" maxlength="190"
                                        class="form-control @error('placa') is-invalid  @enderror" placeholder="Placa"
                                        value="{{ old('placa') }}">
                                    @error('placa')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Combustive:</label>
                                    <select name="estado_civil" class="custom-select ">
                                        <option value="">Selecione...</option>
                                        <option value="2">Álcool</option>
                                        <option value="3" selected="">Bicombustível</option>
                                        <option value="4">Diesel</option>
                                        <option value="5">GNV</option>
                                        <option value="6">Gasolina</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Bloqueio:</label>
                                    <select name="estado_civil" class="custom-select ">
                                        <option value="s">SIM</option>
                                        <option value="n" selected="">NÃO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Marca:</label>
                                    <input type="text" name="marca" maxlength="190"
                                        class="form-control @error('marca') is-invalid  @enderror" placeholder="Marca"
                                        value="{{ old('marca') }}">
                                    @error('marca')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Modelo:</label>
                                    <input type="text" name="modelo" maxlength="190"
                                        class="form-control @error('modelo') is-invalid  @enderror" placeholder="modelo"
                                        value="{{ old('modelo') }}">
                                    @error('modelo')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                             <div class="col-md-2">
                                <div class="form-group">
                                    <label>Ano:</label>
                                    <input type="text" name="ano" maxlength="190"
                                        class="form-control @error('ano') is-invalid  @enderror" placeholder="ano"
                                        value="{{ old('ano') }}">
                                    @error('ano')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Chassi:</label>
                                    <input type="text" name="chassi" maxlength="190"
                                        class="form-control @error('chassi') is-invalid  @enderror" placeholder="Chassi"
                                        value="{{ old('chassi') }}">
                                    @error('chassi')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Renavam:</label>
                                    <input type="text" name="renavam" maxlength="190"
                                        class="form-control @error('renavam') is-invalid  @enderror" placeholder="renavam"
                                        value="{{ old('renavam') }}">
                                    @error('renavam')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cor:</label>
                                    <input type="text" name="cor" maxlength="190"
                                        class="form-control @error('cor') is-invalid  @enderror" placeholder="cor"
                                        value="{{ old('cor') }}">
                                    @error('cor')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <x-botao.btn-salvar />
                        <x-botao.btn-voltar :rota="route('cliente.show',1)" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection







