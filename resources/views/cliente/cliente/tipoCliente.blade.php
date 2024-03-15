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
            <h3>Tipo Pessoa</h3>
        </div>
           <form action="{{ url()->current() }}" method="get"> 
                <div class="card-body">
                    <div class="row">
                        <div class="form-group">
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="customRadio1" name="pessoa" value="f"  @if ( request('pessoa') == 'f') checked="" @endif>
                          <label for="customRadio1" class="custom-control-label">Pessoa Fisica</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="customRadio2" name="pessoa"  value="j"   @if ( request('pessoa') == 'j') checked="" @endif>
                          <label for="customRadio2" class="custom-control-label">Pessoa Juridica</label>
                        </div>
                      </div>    
                    </div>
                </div>
                <div class="card-footer">
                    <x-botao.btn-salvar />
                    <x-botao.btn-voltar :rota="route('cliente.index')" />
                </div>
            </form>
        </div>
    </div>
@endsection
