@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Configurações</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="/settings">Configurações</a> /
                            <a href="/">Home</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th><i class="nav-icon fa fa-cog" aria-hidden="true"></i> Configurações</th>
                    </tr>
                </thead>
                <tbody>
                    @if (session()->get('perfil'))
                        @foreach (session()->get('perfil')['modulos'] as $item)
                            <tr>
                                <td>
                                    <a href="{{ $item['rota'] }}">
                                        {{ $item['nome'] }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
