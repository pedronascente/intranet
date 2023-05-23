@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <form action="/colaborador">
                        <div class="card-body">
                            <div class="form-group">
                                <label> ID do Usuario:</label>
                                <input type="text" name="usuario_id" class="form-control" placeholder="id do usuaario ">
                            </div>

                            <div class="form-group">
                                <label>Empresa:</label>
                                <select class="custom-select rounded-0">
                                    <option value="s">Empresa - XPTO </option>
                                    <option value="n">Empresa - XYZ </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Nome:</label>
                                <input type="text" name="nome" class="form-control" placeholder="nome">
                            </div>

                            <div class="form-group">
                                <label> Sobre Nome:</label>
                                <input type="text" name="sobreNome" class="form-control" placeholder="sobre nome">
                            </div>

                            <div class="form-group">
                                <label> RG:</label>
                                <input type="text" name="rg" class="form-control" placeholder="rg">
                            </div>

                            <div class="form-group">
                                <label> CPF:</label>
                                <input type="text" name="cpf" class="form-control" placeholder="cpf">
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
