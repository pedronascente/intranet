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
                    <input type="text" class="form-control" value=""  id="posicaoDoToken-hidden" disabled="true">
                    <input type="hidden" name="posicaoDoToken"    id="posicaoDoToken-value" value="">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-address-card"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="token" class="form-control" placeholder="Token" value="7CBEE1F0">
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
        var timer = duration;
        var minutes, seconds;
        updatePosicaoToken();
        var intervalId = setInterval(function() {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ':' + seconds;
            console.log(seconds);

            if (--timer < 0) {
                timer = duration;
                // Chama a função para fazer a requisição AJAX quando o contador zerar
                updatePosicaoToken();
            }
        }, 1000);

        // Função para parar o intervalo quando necessário (ex: ao sair da página)
        window.onbeforeunload = function() {
            clearInterval(intervalId);
        };
    }

    function updatePosicaoToken() {
        $.ajax({
            url: '/token/get-posicao-token',
            method: 'GET',
            success: function(response) {
                // Atualiza os campos de entrada com os IDs 'posicaoDoToken-hidden' e 'posicaoDoToken-value'
                $("#posicaoDoToken-hidden").val("Posição: "+ response.posicao);
                $("#posicaoDoToken-value").val(response.posicao);
            },
            error: function(error) {
                console.error('Erro na requisição AJAX:', error);
            }
        });
    }

    window.onload = function() {
        var duration = 30 * 1; // Converte para segundos
        let display = document.querySelector('#timer'); // Elemento para exibir o timer
        startTimer(duration, display); // Inicia a função
    }

</script>


@endsection
