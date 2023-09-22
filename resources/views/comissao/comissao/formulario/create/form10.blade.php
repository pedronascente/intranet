@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Comissão</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('planilha.index') }}">Comissão/</a>planilha</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Lançar Comissão</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('comissao.store') }}" method="POST" name="Formulario-create">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cliente:</label>
                                <input type="text" name="cliente" maxlength="190"
                                    class="form-control @error('cliente') is-invalid  @enderror" placeholder="Cliente"
                                    value="{{ old('cliente') }}">
                                @error('cliente')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Conta / Pedido:</label>
                                <input type="text" name="conta_pedido" maxlength="190"
                                    class="form-control @error('conta_pedido') is-invalid  @enderror"
                                    placeholder="Conta/Periodo" value="{{ old('conta_pedido') }}">
                                @error('conta_pedido')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Data:</label>
                                <input type="text" name="data"
                                    class="form-control @error('data') is-invalid  @enderror" placeholder="Data"
                                    value="{{ old('data') }}">
                                @error('data')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Placa:</label>
                                <input type="text" name="meio" maxlength="190"
                                    class="form-control @error('meio') is-invalid  @enderror" placeholder="Meio"
                                    value="{{ old('meio') }}">
                                @error('meio')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Comissão:</label>
                                <input type="text" name="comissao" maxlength="190"
                                    class="form-control @error('comissao') is-invalid  @enderror" placeholder="Comissão"
                                    value="{{ old('comissao') }}">
                                @error('comissao')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Desconto da Comissão:</label>
                                <input type="text" name="desconto" maxlength="190"
                                    class="form-control @error('desconto') is-invalid  @enderror"
                                    placeholder="Desconto da Comissão" value="{{ old('desconto') }}">
                                @error('desconto')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Observação:</label>
                                <input type="text" name="observacao" maxlength="190"
                                    class="form-control @error('observacao') is-invalid  @enderror" placeholder="Observação"
                                    value="{{ old('observacao') }}">
                                @error('observacao')
                                    <span class=" invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn bg-gradient-primary">
                        <i class="fas fa-save" aria-hidden="true"></i>
                        Salvar
                    </button>
                    <a href="{{ route('planilha.index') }}" title="Voltar" class="btn btn-danger">
                        <i class="fa fa-reply"></i> Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Planilha : {{ $planilha->tipoPlanilha->nome }}</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr>
                        <td><b>Colaborador:</b> {{ $planilha->colaborador->nome }}</td>
                        <td><b>Matricula:</b> {{ $planilha->matricula }}</td>
                        <td><b>CTPS :</b> {{ $planilha->ctps }}</td>
                        <td><b>Periodo:</b> {{ $planilha->periodo->nome }}</td>
                        <td><b>Ano:</b>{{ $planilha->ano }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Cliente</th>
                        <th>Serviço</th>
                        <th>Conta / Pedido</th>
                        <th>Meio</th>
                        <th>Ins. / Vendas</th>
                        <th>Mensal</th>
                        <th>Comissão</th>
                        <th>Desconto da Comissão</th>
                        <th width="5%" class="text-center">Permissões</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 20; $i++)
                        <tr>
                            <td>237158</td>
                            <td>17/08/2023</td>
                            <td>Rosemarie da Costa Pfitscher</td>
                            <td>b119</td>
                            <td>Alarme Monitorado</td>
                            <td>Captação </td>
                            <td>R$ 1495.00</td>
                            <td>R$ 140.00</td>
                            <td>R$ 144.75</td>
                            <td>0.00</td>
                            <td> <a href="http://127.0.0.1:8000/comissao/planilha/1" class="btn btn-primary"
                                    title="Editar Planilha">
                                    <i class="nav-icon fas fa-edit"></i> Editar
                                </a>
                                <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal"
                                    data-target="#deleteModal" data-id="1" title="Excluir Planilha">
                                    <i class="fas fa-trash"></i> Excluir
                                </a>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
