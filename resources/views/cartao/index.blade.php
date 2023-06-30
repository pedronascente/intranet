@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="{{ route('cartao.create') }}" class="btn btn-info btn-block ">
                    Adicionar novo cartão
                </a>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th width="5%">Cartão</th>
                        <th>Usuário</th>
                        <th>Status</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>001</td>
                        <td>pedro.jardim</td>
                        <td>Ativo</td>
                        <td class="text-center">
                            <a href="{{ route('cartao.show', 1) }}" title="visualizar" style="padding-right: 10px">
                                <i class="fas fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>002</td>
                        <td>mario.dias</td>
                        <td>Inativo</td>
                        <td class="text-center">
                            <a href="{{ route('cartao.show', 1) }}" title="visualizar" style="padding-right: 10px">
                                <i class="fas fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>003</td>
                        <td>juliano.joaquim</td>
                        <td>Ativo</td>
                        <td class="text-center">
                            <a href="{{ route('cartao.show', 1) }}" title="visualizar" style="padding-right: 10px">
                                <i class="fas fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
@endsection
