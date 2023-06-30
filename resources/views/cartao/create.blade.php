@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <form action="{{ route('empresa.store') }}" method="POST" name="Formulario-Empresa-create">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleSelectRounded0">Status :</label>
                            <select class="custom-select rounded-0" id="exampleSelectRounded0">
                                <option> Ativo</option>
                                <option> Inativo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleSelectRounded0">Usuário:</label>
                            <select class="custom-select rounded-0" id="exampleSelectRounded0">
                                <option>Value 1</option>
                                <option>Value 2</option>
                                <option>Value 3</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn bg-gradient-primary">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    Salvar</button>
            </div>
        </form>
    </div>
@endsection
