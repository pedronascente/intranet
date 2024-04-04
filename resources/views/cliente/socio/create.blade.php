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
              <h4>Sócio</h4>
          </div>
            <div class="card-body">
                 <form action="{{ route('contato.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Sócio:</label>
                                    <input type="text" name="socio" maxlength="190"
                                        class="form-control @error('socio') is-invalid  @enderror" placeholder="Sócio"
                                        value="{{ old('socio') }}">
                                    @error('socio')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cpf:</label>
                                    <input type="text" name="cpf_socio" maxlength="20" placeholder="___.___.___-__"
                                        class="form-control @error('cpf_socio') is-invalid  @enderror" value="{{ old('cpf_socio') }}"
                                        data-inputmask="'alias': '99.999.999-99'" data-mask="" inputmode="decimal">
                                    @error('cpf_socio')
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


































