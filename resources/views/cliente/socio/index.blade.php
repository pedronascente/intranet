@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
           <a href="{{ route('socio.index') }}">Cliente</a>
        </li>
    </ol>
@endsection 

@section('content')
    <div class="card p-3">
        <div class="card-header text-center">
             <h3>Digite o CPF do Sócio</h3>
             <x-search-form />
        </div>
         @include('cliente.socio.table')  
    </div>
@endsection