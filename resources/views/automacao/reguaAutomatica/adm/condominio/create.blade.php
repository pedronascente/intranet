@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('base.index') }}">base</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">    
        <div class="card">
            <form action="{{ route('condominoController.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <h3>Contato</h3>
                    <div class="form-group">
                        <label>Condomínio:</label>
                        <input type="text" name="condominio" maxlength="190"
                            class="form-control @error('condominio') is-invalid  @enderror" placeholder="Condomínio"
                            value="{{ old('condominio') }}">
                        @error('condominio')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <h3>Régua</h3>
                    <div class="form-group">
                        <label>IP:</label>
                        <input type="ip" name="ip" maxlength="30"
                            class="form-control @error('ip') is-invalid  @enderror" placeholder="IP"
                            value="{{ old('ip') }}">
                        @error('ip')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Usuário:</label>
                        <input type="text" name="usuario" maxlength="190"
                            class="form-control @error('usuario') is-invalid  @enderror" placeholder="Usuário"
                            value="{{ old('usuario') }}">
                        @error('usuario')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Senha:</label>
                        <input type="text" name="senha" maxlength="190"
                            class="form-control @error('senha') is-invalid  @enderror" placeholder="Senha"
                            value="{{ old('senha') }}">
                        @error('senha')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <h3>Tomadas</h3>    
                    <div class="form-group">
                        <label>Quantidade de Tomada:</label>
                        <select name="quantidadeTomada" class="custom-select  @error('quantidadeTomada') is-invalid  @enderror" id="quantidadeTomada" >
                            <option value="">...</option>
                            <option value="3">3</option>
                            <option value="5">5</option>
                            <option value="8">8</option>
                            <option value="10">10</option>
                        </select>
                        @error('quantidadeTomada')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div id="campoInputTomada"></div>
                </div>
                <div class="card-footer">
                    <x-botao.btn-salvar />
                    <x-botao.btn-voltar :rota="route('condominoController.index')" />
                </div>
            </form>
        </div>
    </div>
<script>
    document.getElementById('quantidadeTomada').addEventListener('change', function() {
        var quantity = parseInt(this.value);
        var campoInputTomada = document.getElementById('campoInputTomada');
        campoInputTomada.innerHTML = '';
        
        for (var i = 1; i <= quantity; i++) {
            var divRow = document.createElement('div');
            divRow.className = 'row';
            var divCol1 = document.createElement('div');
            divCol1.className = 'col-md-4';
            var label1 = document.createElement('label');
            label1.textContent = 'Tomada' + i + ':';
            var input1 = document.createElement('input');
            input1.type = 'text';
            input1.name = 'tomada[]';
            input1.maxLength = '190';
            input1.className = 'form-control';
            input1.placeholder = 'Tomada';
            input1.required = 'true';
            
            divCol1.appendChild(label1);
            divCol1.appendChild(input1);

            var divCol2 = document.createElement('div');
            divCol2.className = 'col-md-8';
            var label2 = document.createElement('label');
            label2.textContent = 'Api:';
            var input2 = document.createElement('input');
            input2.type = 'text';
            input2.name = 'api[]';
            input2.maxLength = '190';
            input2.className = 'form-control';
            input2.placeholder = 'https://';
            input2.required = 'true';
            divCol2.appendChild(label2);
            divCol2.appendChild(input2);
            divRow.appendChild(divCol1);
            divRow.appendChild(divCol2);
            campoInputTomada.appendChild(divRow);
        }
    });
</script>

@endsection