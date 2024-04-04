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
              <h4> Contato</h4>
          </div>
            <div class="card-body">
                 <form action="{{ route('cliente.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
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
                                        class="form-control @error('email') is-invalid  @enderror" placeholder="email"
                                        value="{{ old('cemail') }}">
                                    @error('email')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> Telefone 1:</label>
                                    <input type="text" name="telefone1" maxlength="190"
                                        class="form-control @error('telefone1') is-invalid  @enderror" placeholder="telefone1"
                                        value="{{ old('telefone1') }}">
                                    @error('telefone1')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> Telefone 2:</label>
                                    <input type="text" name="telefone2" maxlength="190"
                                        class="form-control @error('telefone2') is-invalid  @enderror" placeholder="telefone1"
                                        value="{{ old('telefone1') }}">
                                    @error('telefone1')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> Telefone 3:</label>
                                    <input type="text" name="telefone1" maxlength="190"
                                        class="form-control @error('telefone1') is-invalid  @enderror" placeholder="telefone1"
                                        value="{{ old('telefone1') }}">
                                    @error('telefone1')
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