@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Cadastrar nova empresa</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="quickForm" novalidate="novalidate" action="/empresa">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Empresa</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Empresa">
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>


        </div>
        <!-- /.row -->
    </div>
@endsection
