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
    <div class="card card-default">
        <form action="{{ route('planilha.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Colaborador:</label>
                            <input type="text" class="form-control"
                                value="{{ $colaborador->nome }} {{ $colaborador->sobrenome }}" disabled>
                            <input type="hidden" name="colaborador_id" class="form-control "
                                value="{{ $colaborador->id }}">
                        </div>
                    </div>
                    <div class="col-md-1 text-center">
                        <label>Ou</label>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Pesquisar Colaborador:</label>
                            <a href="{{ route('planilha.pesquisar.colaborador') }}" title="Pesquisar"
                                class="btn btn-danger form-control">
                                <i class="fa fa-search"></i> Pesquisar
                            </a>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Matricula:</label>
                            <input type="text" name="matricula" maxlength="20"
                                class="form-control @error('matricula') is-invalid  @enderror" placeholder="Matricula"
                                value="{{ old('matricula') }}">
                            @error('matricula')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tipo Planilha:</label>
                            <select name="tipo_planilha_id"
                                class="form-control @error('tipo_planilha_id') is-invalid  @enderror">
                                <option value="">selecionar...</option>
                                @if ($tipoPlanilhas)
                                    @foreach ($tipoPlanilhas as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('tipo_planilha_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nome }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('tipo_planilha_id')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Ano:</label>
                            <input type="text" name="ano" maxlength="4"
                                class="form-control @error('ano') is-invalid  @enderror" placeholder="Ano"
                                value="{{ date('Y') }}">
                            @error('ano')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Periodo:</label>
                            <select name="periodo_id" class="form-control @error('periodo') is-invalid  @enderror">
                                <option value="">selecionar...</option>
                                @if ($periodos)
                                    @foreach ($periodos as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('periodo_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nome }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('periodo_id')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn bg-gradient-primary btn-sm">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    Salvar
                </button>
                <a href="{{ route('planilha.index') }}" title="Voltar" class="btn btn-danger  btn-sm">
                    <i class="fa fa-reply"></i> Voltar
                </a>
            </div>
        </form>
    </div>
@endsection
