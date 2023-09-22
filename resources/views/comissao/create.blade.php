@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Comissão</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('planilha.index') }}">Comissão/</a>planilha</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"> Adicionar comissão</h3>
        </div>
        <div class="card-body">
            @include('comissao.comissao.formulario.create.' . $formulario)
        </div>
    </div>
    <div class="card ">

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th> [ {{ $planilha->tipoPlanilha->nome }} ]</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>Colaborador:</b> <br>{{ $planilha->colaborador->nome }}</td>
                        <td><b>Matricula:</b> <br>{{ $planilha->matricula }}</td>
                        <td><b>CTPS :</b> <br>{{ $planilha->ctps }}</td>
                        <td><b>Periodo:</b><br> {{ $planilha->periodo->nome }}</td>
                        <td><b>Ano:</b> <br>{{ $planilha->ano }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @include('comissao.comissao.table.' . $formulario)
        </div>
    </div>
@endsection
