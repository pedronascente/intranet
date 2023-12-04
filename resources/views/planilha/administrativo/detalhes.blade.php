@extends('layouts.app')

@section('titulo', $planilha->tipo->nome)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('planilha.index') }}">Planilha</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-body table-responsive p-0">
            <table class="table   table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Colaborador</th>
                        <th>Matricula</th>
                        <th>CTPS</th>
                        <th>Periodo</th>
                        <th>Ano</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $planilha->colaborador->nome }}</td>
                        <td>{{ $planilha->matricula }}</td>
                        <td>{{ $planilha->ctps }}</td>
                        <td>{{ $planilha->periodo->nome }}</td>
                        <td>{{ $planilha->ano }}</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    <div class="card card-primary">
        <div class="card-body table-responsive p-0">
            @include('comissao.table.' . $planilha->tipo->formulario)
        </div>
    </div>
@endsection
