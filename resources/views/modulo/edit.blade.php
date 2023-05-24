@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <form action="/modulo">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nome do Módulo:</label>
                                <input type="text" name="nome" class="form-control" placeholder="nome">
                            </div>
                            <div class="form-group">
                                <label>Descrição:</label>
                                <input type="text" name="descricao" class="form-control"
                                    placeholder="Escreva uma breve descrição">
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
