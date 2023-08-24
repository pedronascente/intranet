@extends('layouts.app')
@section('content')
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
