@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('planilha.index') }}">Planilhas</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card">
            <form action="{{ route('planilha.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Colaborador:</label>
                                <input type="text" class="form-control"
                                    value="{{ $colaborador->nome }}" disabled>
                                <input type="hidden" name="colaborador_id" class="form-control "
                                    value="{{ $colaborador->id }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Matricula:</label>
                                <input type="text" maxlength="20" class="form-control"  value="{{  $colaborador->numero_matricula }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Planilha:</label>
                                <select name="planilha_tipo_id"
                                    class="form-control @error('planilha_tipo_id') is-invalid  @enderror">
                                    <option value="">selecionar...</option>
                                    @if ($tipos)
                                        @foreach ($tipos as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('planilha_tipo_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nome }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('planilha_tipo_id')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CTPS:</label>
                                <input type="text" name="ctps" maxlength="20"
                                    class="form-control @error('ctps') is-invalid  @enderror" placeholder="Ctps"
                                    value="{{ old('ctps') }}">
                                @error('ctps')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Ano:</label>
                                <select name="ano" class="form-control  @error('ano') is-invalid  @enderror">
                                    <option value="">Ano</option>
                                    @for ($ano = date('Y'); $ano >= 2020; $ano--)
                                        <option value="{{ $ano }}" {{ old('ano') == $ano ? 'selected' : '' }}>
                                            {{ $ano }}</option>
                                    @endfor
                                </select>
                                @error('ano')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Periodo:</label>
                                <select name="planilha_periodo_id"
                                    class="form-control @error('planilha_periodo_id') is-invalid  @enderror">
                                    <option value="">selecionar...</option>
                                    @if ($periodos)
                                        @foreach ($periodos as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('planilha_periodo_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nome }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('planilha_periodo_id')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <x-botao.btn-salvar />
                    <!--
                    <a href="{{ route('colaborador.pesquisar') }}" title="Pesquisar" class="btn btn-warning btn-sm">
                        <i class="fa fa-search"></i> Pesquisar Colaborador
                    </a>-->
                    <x-botao.btn-voltar :rota="route('planilha.index')" />
                </div>
            </form>
        </div>
    </div>
@endsection
