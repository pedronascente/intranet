@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('planilha.index') }}">Planilhas</a> /
            <a href="{{ route('planilha.create') }}" title="Cadastrar nova Planilha">
                Voltar
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card card-default">
        <div class="card-body">
            <div class="row ">
                <div class="col-md-12">
                    <h2 class="text-center display-4">Procurar</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 offset-md-2 ">
                    <form action="{{ route('planilha.pesquisar.colaborador') }}" method="post">
                        @csrf
                        <div class="input-group input-group-lg">
                            <input type="search" class="form-control form-control-lg" name="filtro"
                                placeholder="Digite o nome do colaborador" value="">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-lg btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
