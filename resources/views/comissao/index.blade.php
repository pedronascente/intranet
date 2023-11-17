@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> {{ $titulo }} </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('planilha.index') }}">Planilhas</a> /
                            <a href="#">comisão</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card card-primary">
        <div class="card-body">
            <div class="card-body table-responsive p-0">
                @include('comissao.table.' . $formulario)
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="card-body table-responsive p-0">
                <h4>Cadastrar Comissão</h4>
                @include('comissao.formulario.create.' . $formulario)
            </div>
        </div>
    </div>
@endsection
