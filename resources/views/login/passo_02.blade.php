@extends('layouts.login')
@section('content')
    <div class="login-logo">
        <img src="{{ asset('/dist/img/intraNet.png') }}" class=" mr-3 " style="width:200px" alt="intraNet.png">
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <h1>{{ $mensagem }}!</h1>
            <p>
                para continuar insira seu <b>Token</b>
            </p>

            <form action="{{ route('token.store') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" value="Posição : {{ $posicaoDoToken }}" disabled="true">
                    <input type="hidden" name="posicaoDoToken" value="{{ $posicaoDoToken }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-address-card"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="token" class="form-control" placeholder="Token" value="0B81E594">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                    </div>
                    <div class="col-6">
                        <div id="timer" style="font-size:25px"></div>
                    </div>
                </div>
            </form>
            <p class="mt-3 mb-1">
            </p>
        </div>
    </div>
    <script type="text/javascript">
        function startTimer(duration, display) {
            getPosicaoDoTokenNoCartao()
            var timer = duration,
                minutes, seconds;
            setInterval(function() {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                display.textContent = minutes + ':' + seconds;
                console.log(seconds);
                if (--timer < 0) {
                    timer = duration;
                    getPosicaoDoTokenNoCartao()
                }
            }, 1000);
        }

        function getPosicaoDoTokenNoCartao() {
            $.get("/cartao/posicao", function(data) {
                console.log(data);
                $("#posicaoDoToken").val('Posição:' + data.posicao);
                $("#posicaoDoTokenHidden").val(data.posicao);
            });
        }

        window.onload = function() {
            var duration = 60 * 1; //Conversão para segundos
            let display = document.querySelector('#timer'); //Elemeto para exibir o timer
            startTimer(duration, display) //Inicia a função.
        }
    </script>
@endsection
