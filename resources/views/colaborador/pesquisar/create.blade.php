@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('planilha.create') }}">Planilhas</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card-header">
            <form action="{{ route('colaborador.showPesquisar') }}" method="get">
                <div class=" col-md-8 offset-md-2">
                    <div class="input-group input-group-lg">
                        <input type="text" name="filtro" class="form-control form-control-lg" placeholder="Pesquisar por"
                            value="">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <x-botao.btn-voltar :rota="route('planilha.create')" />
        </div>
    </div>
@endsection  
 