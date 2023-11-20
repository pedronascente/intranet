@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> {{ $titulo }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('planilha.index') }}">Planilhas</a> /
                            <a href="#">comisão</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card card-primary">
        <div class="card-body">
            <h4>Editar Comissão</h4>
            <form action="{{ route('comercialRastreamentoVeicular.update', $comissao->id) }}" method="POST"
                name="formulario-edit">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Cliente:</label>
                                <input type="text" name="cliente" maxlength="200"
                                    class="form-control @error('cliente') is-invalid  @enderror" placeholder="Cliente"
                                    value="{{ $comissao->cliente ? $comissao->cliente : old(cliente) }} ">
                                @error('cliente')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Data:</label>
                                <input type="text" name="data" maxlength="15"
                                    class="form-control @error('data') is-invalid  @enderror" placeholder="Data"
                                    value="{{ \Carbon\Carbon::parse($comissao->data)->format('d/m/Y') ? \Carbon\Carbon::parse($comissao->data)->format('d/m/Y') : old('data') }}">
                                @error('data')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>ID Contrato:</label>
                                <input type="text" name="id_contrato" maxlength="10"
                                    class="form-control @error('id_contrato') is-invalid  @enderror"
                                    placeholder="ID Contrato"
                                    value="@if ($comissao->id_contrato) {{ $comissao->id_contrato }} @endif ">
                                @error('id_contrato')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Placa:</label>
                                <input type="text" name="placa" maxlength="10"
                                    class="form-control @error('placa') is-invalid  @enderror" placeholder="Placa"
                                    value="{{ $comissao->placa ? $comissao->placa : old(placa) }}">
                                @error('placa')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Taxa Instalação:</label>
                                <input type="text" name="taxa_instalacao" maxlength="10"
                                    class="form-control @error('taxa_instalacao') is-invalid  @enderror"
                                    placeholder="Taxa Instalação"
                                    value="{{ $comissao->taxa_instalacao ? $comissao->taxa_instalacao : old(taxa_instalacao) }} ">
                                @error('taxa_instalacao')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mensal:</label>
                                <input type="text" name="mensal" maxlength="10"
                                    class="form-control @error('mensal') is-invalid  @enderror" placeholder="Mensal"
                                    value="{{ $comissao->mensal ? $comissao->mensal : old(mensal) }} ">
                                @error('mensal')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Comissão:</label>
                                <input type="text" name="comissao" maxlength="10"
                                    class="form-control @error('comissao') is-invalid  @enderror" placeholder="Comissão"
                                    value="{{ $comissao->comissao ? $comissao->comissao : old(comissao) }} ">
                                @error('comissao')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Desconto:</label>
                                <input type="text" name="desconto_comissao" maxlength="10"
                                    class="form-control @error('desconto_comissao') is-invalid  @enderror"
                                    placeholder="Desconto"
                                    value="{{ $comissao->desconto_comissao ? $comissao->desconto_comissao : old(desconto_comissao) }} ">
                                @error('desconto_comissao')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn bg-gradient-primary">
                        <i class="fas fa-save" aria-hidden="true"></i>
                        Salvar
                    </button>
                    <a href="{{ route('comissao.index', $comissao->planilha_id) }}" title="Voltar" class="btn btn-danger">
                        <i class="fa fa-reply"></i> Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection