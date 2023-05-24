@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">

                    <form action="/perfil">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nome do Perfil</label>
                                <input type="text" name="nome" class="form-control" placeholder="perfil">
                            </div>
                            <div class="form-group">
                                <label>Descrição</label>
                                <input type="text" name="descricao" class="form-control" placeholder="Breve descrição">
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover  table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="3"></th>
                                            <th width="5%" colspan="4" class="text-center">Permissões Gerais</th>
                                        </tr>
                                        <tr>
                                            <th>Permissões</th>
                                            <th>Modulo</th>
                                            <th>Descrição</th>
                                            <th class="text-center">Visualizar</th>
                                            <th class="text-center">Editar</th>
                                            <th class="text-center">Criar</th>
                                            <th class="text-center">Exluir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 0; $i < 8; $i++)
                                            <tr>
                                                <td class="text-center">
                                                    <div
                                                        class="custom-control
                                                    custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="moduloCheckbox{{ $i }}" value="on">
                                                        <label for="moduloCheckbox{{ $i }}"
                                                            class="custom-control-label"></label>
                                                    </div>
                                                </td>
                                                <td>Acionamento VTR</td>
                                                <td>MÓDULO BLÁ BLÁ</td>
                                                <td class="text-center">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="visualizarCheckbox{{ $i }}" value="on">
                                                        <label for="visualizarCheckbox{{ $i }}"
                                                            class="custom-control-label"></label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="editarCheckbox{{ $i }}" value="on">
                                                        <label for="editarCheckbox{{ $i }}"
                                                            class="custom-control-label"></label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="criarCheckbox{{ $i }}" value="on">
                                                        <label for="criarCheckbox{{ $i }}"
                                                            class="custom-control-label"></label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="excluirCheckbox{{ $i }}" value="on">
                                                        <label for="excluirCheckbox{{ $i }}"
                                                            class="custom-control-label"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
