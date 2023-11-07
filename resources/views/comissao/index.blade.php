@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> {{ $planilha->tipoPlanilha->nome }} </h1>
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
            <table class="table table-hover text-nowrap table-striped">
                <tbody>
                    <tr>
                        <td><b>Colaborador</b> <br>{{ $planilha->colaborador->nome }}</td>
                        <td><b>Matricula</b> <br>{{ $planilha->matricula }}</td>
                        <td><b>CTPS </b> <br>{{ $planilha->ctps }}</td>
                        <td><b>Periodo</b><br> {{ $planilha->periodo->nome }}</td>
                        <td><b>Ano</b> <br>{{ $planilha->ano }}</td>
                    </tr>
                </tbody>
            </table>
            @include('comissao.comissao.table.' . $formulario)
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="card-body table-responsive p-0">
                <h4>Cadastrar Comissão</h4>
                @include('comissao.comissao.formulario.create.' . $formulario)
            </div>
        </div>
    </div>
@endsection
