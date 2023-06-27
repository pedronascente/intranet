@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-md table-striped">
                <tr>
                    <td><b>DADOS: </td>
                </tr>
            </table>

            <table class="table table-md">
                <tbody>
                    <tr>
                        <td><b>Código :</b> {{ $perfil->id }}</td>
                    </tr>
                    <tr>
                        <td><b>Perfil:</b> {{ $perfil->nome }}</td>
                    </tr>
                    <tr>
                        <td><b>Descrição: </b> {{ $perfil->descricao }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-md table-striped">
                <tr>
                    <td><b>USUÁRIO(S): </td>
                </tr>
            </table>
            <table class="table table-md">
                <tbody>
                    <tr>
                        <td>Usuario xpto 001</td>
                        <td class="text-right">
                            <a href="user/1" class="btn btn-warning" title="Visualizar">
                                <i class="fas fa-solid fa-eye"></i> Visualizar
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Usuario xpto 001</td>
                        <td class="text-right">
                            <a href="user/1" class="btn btn-warning" title="Visualizar">
                                <i class="fas fa-solid fa-eye"></i> Visualizar
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Usuario xpto 001</td>
                        <td class="text-right">
                            <a href="user/1" class="btn btn-warning" title="Visualizar">
                                <i class="fas fa-solid fa-eye"></i> Visualizar
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-md table-striped">
                <tr>
                    <td><b>MÓDULOS(S): </td>
                </tr>
            </table>

            <table class="table table-md ">
                @for ($i = 3; $i < 10; $i++)
                    <tr>
                        <td>
                            <table class="table table-sm table-striped">
                                <tr>
                                    <td colspan="2">
                                        <b>RH XPTO000{{ $i }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <ul>
                                            <li><b>Permissões</b>
                                                <ul>
                                                    <li>Editar</li>
                                                    <li>Excluir</li>
                                                    <li>Visualizar</li>
                                                    <li>Criar</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endfor
            </table>


        </div>
        <div class="card-footer">
            <a href="/perfil" class="btn   btn-warning" title="Voltar">
                <i class="fa fa-reply" aria-hidden="true"></i> Voltar
            </a>
            <form action="/perfil/{{ $perfil->id }}" method="post" style="display:inline">
                @csrf()
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-times"></i> Excluir
                </button>
            </form>

        </div>
    </div>
@endsection
