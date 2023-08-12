@extends('layouts.iframe')
@section('content')
    <div class="card">
        <form action="{{ route('empresa.update', $empresa->id) }}" method="POST">
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
            </div>
            <div class="card-footer">
                <button type="submit" class="btn bg-gradient-primary">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    Editar
                </button>
            </div>
        </form>
    </div>
@endsection
