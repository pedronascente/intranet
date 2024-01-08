@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('planilha-administrativo.index') }}">Planilha</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <form action="{{ route('planilha-administrativo.reprovarUpdate', $planilha->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Motivo da Reprovação:</label>
                            <textarea name="motivo_reprovacao" rows="4" cols="50"
                                class="form-control @error('motivo_reprovacao') is-invalid  @enderror"></textarea>
                            @error('motivo_reprovacao')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="planilha_id" class="form-control" value="{{ $planilha->id }}">
                <input type="hidden" name="planilha_status_id" class="form-control" value="4">
                <button type="submit" class="btn btn-sm bg-gradient-primary">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    Salvar
                </button>
                <a href="{{ route('planilha-administrativo.index') }}" title="Voltar" class="btn  btn-sm btn-danger">
                    <i class="fa fa-reply"></i> Voltar
                </a>
            </div>
        </form>
    </div>
@endsection
