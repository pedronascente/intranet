@extends('layouts.app')
@section('content')
    <div class="card card-primary card-outline">

        <div class="card-body">

            <table class="table table-sm">
                <tbody>

                    <tr>
                        <td><b>Nome :</b> {{ $grupo->nome }}</td>
                        <td><b>ID :</b> {{ $grupo->id }}</td>
                    </tr>
                </tbody>
                @if ($grupo->users->count() >= 1)
                    <tfooter>
                        <tr>
                            <td colspan="2">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Usuario(s):</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($grupo->users as $K => $user)
                                            <tr>
                                                <td>

                                                    <a href="/user/{{ $user->id }}" class="btn btn-default" title="Voltar">
                                                        <b> Nome:</b> {{ $user->name }}
                                                    </a>
                                                    <ul>
                                                        <li><b>Modulos:</b>
                                                            <ul>
                                                                <li>MODULO-00{{ $K }}
                                                                    <ul>
                                                                        <li>
                                                                            <b>Permissões:</b>
                                                                            <ul>
                                                                                <li>editar</li>
                                                                                <li>excluir</li>
                                                                                <li>criar</li>
                                                                            </ul>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tfooter>
                @endif
            </table>
        </div>
        <div class="card-footer">
            <div class="btn-group ">
                <form action="/perfil/{{ $grupo->id }}" method="post">
                    @csrf()
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-default">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
                <a href="/perfil" class="btn  btn-sm btn-default" title="Voltar">
                    <i class="fa fa-reply" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
