@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
     @include('comissao.planilhas._breadcrumb_administrativo')
@endsection

@section('content')
    <div class="card p-3">
        <div class="card">
            <div class="card-header">
                <h4>Editar Comissão</h4>
            </div>
            <form action="{{ route('portaria-virtual.update', $comissao->id) }}" method="POST" name="formulario-edit">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Cliente:</label>
                                <input type="text" name="cliente" maxlength="190"
                                    class="form-control @error('cliente') is-invalid  @enderror" placeholder="Cliente"
                                    value="{{ $comissao->cliente ?? old(cliente) }} ">
                                @error('cliente')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Data:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" name="data"
                                        class="form-control  @error('data') is-invalid  @enderror"
                                        data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask=""
                                        inputmode="numeric"
                                        value="{{ \Carbon\Carbon::parse($comissao->data)->format('d/m/Y') ?? old('data') }}">
                                    @error('data')
                                        <span class=" invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Meio:</label>
                                <select name="meio_id" class="form-control @error('meio_id') is-invalid @enderror">
                                    <option value="">Selecione</option>
                                    @isset($meios)
                                        @foreach ($meios as $meio)
                                            <option value="{{ $meio->id }}"
                                                {{ ($comissao->meio->id ?? old('meio_id')) == $meio->id ? 'selected' : '' }}>
                                                {{ $meio->nome }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                                @error('meio_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Ins./Vendas :</label>
                                <input type="text" name="ins_vendas" maxlength="9"
                                    class="form-control @error('ins_vendas') is-invalid  @enderror" placeholder="0"
                                    value="{{ $comissao->ins_vendas ?? old(ins_vendas) }} ">
                                @error('ins_vendas')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mensal :</label>
                                <input type="text" name="mensal" maxlength="9"
                                    class="form-control @error('mensal') is-invalid  @enderror" placeholder="0"
                                    value="{{ $comissao->mensal ?? old(mensal) }} ">
                                @error('mensal')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Comissão:</label>
                                <input type="text" name="comissao" maxlength="9"
                                    class="form-control @error('comissao') is-invalid  @enderror" placeholder="0"
                                    value="{{ $comissao->comissao ?? old(comissao) }} ">
                                @error('comissao')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Desconto:</label>
                                <input type="text" name="desconto_comissao" maxlength="9"
                                    class="form-control @error('desconto_comissao') is-invalid  @enderror" placeholder="0"
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
                    <x-botao.btn-voltar :rota="route('comissao.administrativo.tipoAdministrativo.index',$comissao->planilha_id)" />
                </div>
            </form>
        </div>
    </div>
@endsection
