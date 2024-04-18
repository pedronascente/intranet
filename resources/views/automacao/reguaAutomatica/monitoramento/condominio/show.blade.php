@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('condominoController.index') }}">Condominio</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card">
            <div class="card-header">
                <h4>Condominio</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover text-nowrap table-bordered table-striped">
                    <tbody>
                        <tr>
                            <td>Condominio :</td>
                            <td>{{ $condominio->condominio }}</td>
                        </tr>
                        <tr>
                            <td>IP:</td>
                            <td>{{ $condominio->regua->ip }}</td>
                        </tr>
                        <tr>
                            <td>Tomadas</td>
                            <td>{{ $condominio->regua->tomadas->count() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4>Tomadas</h4>
            </div>
            <div class="card-body table-responsive">
                <div class="row ">
                    <div class="col-md-4">
                        <table class="table table-hover text-nowrap table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>TOMADA</th>
                                    <th>AÇÃO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($condominio->regua->tomadas)
                                    @foreach ($condominio->regua->tomadas as $tomada)
                                        <tr class="text-center">
                                            <td>
                                                <a href="" class="btn btn-primary statusBtn"
                                                    data-id="{{ $tomada->id }}" style="min-width: 200px">
                                                    {{ $tomada->tomada }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-info ligaDesligaTomada"
                                                    data-id="{{ $tomada->id }}">
                                                    ON/OFF
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        $(document).ready(function() {
        $('.ligaDesligaTomada').click(function(e) {
        e.preventDefault();
        var btn = $(this);
        var tomadaId = btn.data('id');
        var statusBtn = btn.closest('tr').find('.statusBtn');

        // Simula o estado atual da tomada (ligado/desligado)
        var isLigado = statusBtn.hasClass('btn-primary');

        // Alterna a cor do botão
        if (isLigado) {
        statusBtn.removeClass('btn-primary').addClass('btn-danger');
        } else {
        statusBtn.removeClass('btn-danger').addClass('btn-primary');
        }

        // Aqui você pode adicionar a lógica para enviar uma requisição para ligar/desligar a tomada ao backend
        // $.post('/ligar-desligar-tomada', { tomada_id: tomadaId }, function(response) {
        // // Lida com a resposta do servidor
        // });

        // Neste exemplo, apenas simulamos a alteração da cor do botão sem enviar uma requisição real ao backend
        });
        });
    @endpush
@endsection
