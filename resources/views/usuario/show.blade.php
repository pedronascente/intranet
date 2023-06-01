@extends('layouts.app')
@section('content')
    <div class="card col-md-5">
        <div class="card-header  text-center">
            <h3><img src="https://assets.plugcrm.net/assets/2.0/dummy-round-352479a0a86fd5b4720729bcfa3e3834646e1b5a7a9d4d7c86ff789f67844718.png"
                    alt="" width="100"></h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-sm table-striped">
                <tbody>
                    <tr>
                        <td><b>Nome: </b> Pedro jarrim</td>
                    </tr>
                    <tr>
                        <td><b>Email: </b> email@bol.com</td>
                    </tr>
                    <tr>
                        <td><b>RG:</b> 888888888</td>
                    </tr>
                    <tr>
                        <td><b>CPF: </b> 888.888.888.95</td>
                    </tr>
                    <tr>
                        <td><b>CNPJ: </b> 44.444.44444-98</td>
                    </tr>
                    <tr>
                        <td><b>Empresa: </b> Empresa Volpato</td>
                    </tr>
                    <tr>
                        <td><b>Grupo: </b> Monitoramento</td>
                    </tr>
                    <tr>
                        <td><b>Status: </b> Ativo</td>
                    </tr>
                </tbody>
                <tfooter>
                    <tr>
                        <td class="text-center">
                            <div class="btn-group ">
                                <a href="/usuario/{{ 1 }}/edit" class="btn btn-default" title="Editar">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('usuario.destroy', 1) }}" method="post" title="Desativar">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-toggle-on" aria-hidden="true"></i>
                                    </button>
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
