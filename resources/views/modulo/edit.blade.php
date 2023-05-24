@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <form action="/modulo">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nome do Usuário:</label>
                                <input type="text" name="nome" class="form-control" placeholder="nome">
                            </div>
                            <div class="form-group">
                                <label for="exampleSelectRounded0">Ativo</label>
                                <select class="custom-select rounded-0">
                                    <option value="s">Sim</option>
                                    <option value="n">Não</option>
                                </select>
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
