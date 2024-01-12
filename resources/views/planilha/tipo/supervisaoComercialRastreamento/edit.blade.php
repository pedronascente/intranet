@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    @include('planilha.tipo._breadcrumb')
@endsection

@section('content')
    <div class="card p-3">
        <div class="card">
            <div class="card-header">
                <h4>Editar Comissão</h4>
            </div>
            <form action="{{ route('supervisao-c-r.update', $comissao->id) }}" method="POST" name="formulario-edit">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Cliente:</label>
                                <input type="text" name="cliente" maxlength="190"
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Conta:</label>
                                <input type="text" name="conta_pedido" maxlength="50"
                                    class="form-control @error('conta_pedido') is-invalid  @enderror" placeholder="Conta"
                                    value="{{ $comissao->conta_pedido ?? old(conta_pedido) }} ">
                                @error('conta_pedido')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Total de Rastreadores:</label>
                                <input type="text" name="total_rastreadores" maxlength="10"
                                    class="form-control @error('total_rastreadores') is-invalid  @enderror"
                                    placeholder="Total Rastreadores"
                                    value="{{ $comissao->total_rastreadores ?? old(total_rastreadores) }} ">
                                @error('total_rastreadores')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Comissão:</label>
                                <input type="text" name="comissao" maxlength="9"
                                    class="form-control @error('comissao') is-invalid  @enderror" placeholder="Comissão"
                                    value="{{ $comissao->comissao ?? old(comissao) }} ">
                                @error('comissao')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Desconto:</label>
                                <input type="text" name="desconto_comissao" maxlength="9"
                                    class="form-control @error('desconto_comissao') is-invalid  @enderror"
                                    placeholder="Desconto"
                                    value="{{ $comissao->desconto_comissao ?? old(desconto_comissao) }} ">
                                @error('desconto_comissao')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <x-botao.btn-salvar />
                    <x-botao.btn-voltar :rota="route('planilha-colaborador-tipo.index', $comissao->planilha_id)" />
                </div>
            </form>
        </div>
    </div>
@endsection
