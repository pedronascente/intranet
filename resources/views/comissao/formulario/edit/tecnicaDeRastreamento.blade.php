@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('planilha.index') }}">Planilhas</a> /
            <a href="{{ route('comissao.index', $comissao->planilha_id) }}">
                {{ $titulo }}
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Editar Comissão</h4>
        </div>
        <form action="{{ route('tecnica-de-rastreamento.update', $comissao->id) }}" method="POST" name="formulario-edit">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>Cliente:</label>
                            <input type="text" name="cliente" maxlength="190"
                                class="form-control @error('cliente') is-invalid  @enderror" placeholder="Cliente"
                                value="{{ $comissao->cliente ?? old(cliente) }}">
                            @error('cliente')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Data:</label>
                            <input type="text" name="data" class="form-control  @error('data') is-invalid  @enderror"
                                maxlength="10" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy"
                                data-mask="" inputmode="numeric"
                                value="{{ \Carbon\Carbon::parse($comissao->data)->format('d/m/Y') ?? old('data') }}">
                            @error('data')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Conta / Pedido:</label>
                            <input type="text" name="conta_pedido" maxlength="50"
                                class="form-control @error('conta_pedido') is-invalid  @enderror"
                                placeholder="Conta/Periodo" value="{{ $comissao->conta_pedido ?? old('conta_pedido') }}">
                            @error('conta_pedido')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Placa:</label>
                            <input type="text" name="placa" maxlength="10"
                                class="form-control @error('placa') is-invalid  @enderror" placeholder="Placa"
                                value="{{ $comissao->placa ?? old('placa') }}">
                            @error('placa')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Comissão:</label>
                            <input type="text" name="comissao" maxlength="6"
                                class="form-control @error('comissao') is-invalid  @enderror" placeholder="0"
                                value="{{ $comissao->comissao ?? old('comissao') }}">
                            @error('comissao')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Desconto:</label>
                            <input type="text" name="desconto_comissao" maxlength="6"
                                class="form-control @error('desconto_comissao') is-invalid  @enderror" placeholder="0"
                                value="{{ $comissao->desconto_comissao ?? old('desconto_comissao') }} ">
                            @error('desconto_comissao')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Observação:</label>
                            <textarea name="observacao" class="form-control @error('observacao') is-invalid  @enderror" rows="3">{{ $comissao->observacao }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn bg-gradient-primary btn-sm">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    Salvar
                </button>
                <a href="{{ route('comissao.index', $comissao->planilha_id) }}" title="Voltar"
                    class="btn btn-danger btn-sm">
                    <i class="fa fa-reply"></i> Voltar
                </a>
            </div>
        </form>
    </div>
@endsection
