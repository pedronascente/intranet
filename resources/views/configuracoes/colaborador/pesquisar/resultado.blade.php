@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('planilha-colaborador.create') }}">Planilhas</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
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
        <div class="card-body mb-3  mt-3">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="list-group">
                        @if ($colaboradores)
                            @foreach ($colaboradores as $k => $colaborador)
                              <div class="list-group-item">
                                <div class="row">
                                    <div class="col-auto">
                                        <img src="{{ asset('img/colaborador/' . $colaborador->foto . '') }}"
                                            alt="{{ $colaborador->nome }}" width="50" class="rounded-circle">
                                    </div>
                                    <div class="col px-3">
                                        <div>
                                            <div class="float-right">
                                                <a href="{{ route('planilha-colaborador.create','id='.$colaborador->id) }}"
                                                    title="Adicionar colaborador" class="btn btn-success btn-sm">
                                                    <i class="fas fa-solid fa-plus"></i> Adicionar
                                                </a>
                                            </div>
                                            <p>{{ $colaborador->nome }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="row">
                                <div class="text-center">
                                    Nenhum regitro encontrado!
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('planilha-colaborador.create') }}" title="Voltar" class="btn btn-danger  btn-sm">
                <i class="fa fa-reply"></i> Voltar
            </a>
        </div>
    </div>
@endsection
