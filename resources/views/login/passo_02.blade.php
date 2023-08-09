@extends('layouts.login')
@section('content')
    <div class="login-logo">
        <img src="{{ asset('/dist/img/intraNet.png') }}" class=" mr-3 " style="width:200px" alt="intraNet.png">
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ $mensagem }}, para continuar insira seu Token
            <div id="timer" class="text-center"></div>
            <div id="result" class="text-center"></div>
            </p>
            <form action="{{ route('token.store') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" id="posicaoDoToken" class="form-control" value="Posição : " disabled="true">
                    <input type="hidden" id="posicaoDoTokenHidden" name="posicaoDoToken" value="">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-address-card"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="token" class="form-control" placeholder="Token">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                    </div>
                </div>
            </form>
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
                $("#posicaoDoToken").val('Posição:' + data);
                $("#posicaoDoTokenHidden").val(data);
            });
        }

        window.onload = function() {
            var duration = 60 * 1; //Conversão para segundos
            let display = document.querySelector('#timer'); //Elemeto para exibir o timer
            startTimer(duration, display) //Inicia a função.
        }
    </script>
@endsection
