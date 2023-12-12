@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('planilha-colaborador.index') }}">Planilhas</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card card-default">
        <form action="{{ route('planilha-colaborador.update', $planilha->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Colaborador:</label>
                            <input type="text" class="form-control"
                                value="{{ $planilha->colaborador->nome }} {{ $planilha->colaborador->sobrenome }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>CTPS:</label>
                            <input type="text" name="ctps" maxlength="20"
                                class="form-control @error('ctps') is-invalid  @enderror" placeholder="Ctps"
                                value="{{ $planilha->ctps }}">
                            @error('ctps')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Matricula:</label>
                            <input type="text" name="matricula"
                                class="form-control @error('matricula') is-invalid  @enderror" placeholder="Matricula"
                                value="{{ $planilha->matricula }}">
                            @error('matricula')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Planilha:</label>
                            <select name="planlha_tipo_id"
                                class="form-control @error('planlha_tipo_id') is-invalid  @enderror" disabled>
                                <option value="">selecionar...</option>
                                @if ($tipos)
                                    @foreach ($tipos as $item)
                                        <option value="{{ $item->id }}"
                                            @if ($item->id == $planilha->tipo->id) selected @endif>{{ $item->nome }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('planlha_tipo_id')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Ano:</label>
                            <input type="text" name="ano" maxlength="4"
                                class="form-control @error('ano') is-invalid  @enderror" placeholder="Ano"
                                value="{{ $planilha->ano }}">
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
                                            {{ $planilha->periodo->id == $item->id ? 'selected' : '' }}>
                                            {{ $item->nome }}
                                        </option>
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
                <input type="hidden" name="colaborador_id" class="form-control" value="{{ $planilha->colaborador->id }}">
                <input type="hidden" name="planilha_tipo_id" class="form-control" value="{{ $planilha->tipo->id }}">
                <button type="submit" class="btn bg-gradient-primary btn-sm">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    Salvar
                </button>
                <a href="{{ route('planilha-colaborador.index') }}" title="Voltar" class="btn btn-danger btn-sm">
                    <i class="fa fa-reply"></i> Voltar
                </a>
            </div>
        </form>
    </div>
@endsection