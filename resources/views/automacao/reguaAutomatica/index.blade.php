@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('painelController.index') }}">Principal</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card-body text-center">
            <a href="{{ route('condominoController.index') }}" class="btn btn-info">Administrar</a>
            <a href="{{ route('monitoramentoController.index') }}" class="btn btn-primary">Monitorar</a>
        </div>
    </div>
@endsection