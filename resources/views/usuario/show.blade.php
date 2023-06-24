@extends('layouts.app')
@section('content')
    <div class="card col-md-12">
        <div class="card-header  ">

            <h3><img src="https://assets.plugcrm.net/assets/2.0/dummy-round-352479a0a86fd5b4720729bcfa3e3834646e1b5a7a9d4d7c86ff789f67844718.png"
                    alt="" width="100"></h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-sm table-striped">
                <tbody>

                    <tr>
                        <td><b>status : </b>{{ $user->ativo }} </td>
                    </tr>

                    <tr>
                        <td><b>Nome:</b> {{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td><b>Email: </b> {{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td>
                            <b>Perfil: </b><br>
                            <a href="/perfil/{{ $user->grupo->id }}" class="btn btn-default" title="Voltar">
                                {{ $user->grupo->nome }}
                            </a>
                        </td>

                    </tr>
                </tbody>
                <tfooter>
                    <tr>
                        <td>
                            <div class="btn-group ">
                                <a href="/usuario/{{ $user->id }}/edit" class="btn btn-default" title="Editar">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('usuario.destroy', $user->id) }}" method="post" title="Desativar">
                                    @method('DELETE')
                                    @csrf
                                </form>
                                <a href="/usuario" class="btn btn-default" title="Voltar">
                                    <i class="fa fa-reply" aria-hidden="true"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tfooter>
            </table>
        </div>
    </div>
@endsection
