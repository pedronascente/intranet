<form action="{{ route('comissao.store') }}" method="POST" name="Formulario-create">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
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
            <div class="col-md-2">
                <div class="form-group">
                    <label>Data:</label>
                    <input type="text" name="data" class="form-control @error('data') is-invalid  @enderror"
                        placeholder="Data" value="{{ old('data') }}">
                    @error('data')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Conta:</label>
                    <input type="text" name="conta" maxlength="190"
                        class="form-control @error('conta') is-invalid  @enderror" placeholder="Conta"
                        value="{{ old('conta') }}">
                    @error('conta')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>N° OS:</label>
                    <input type="text" name="numero_os" maxlength="190"
                        class="form-control @error('numero_os') is-invalid  @enderror" placeholder="Numero da OS"
                        value="{{ old('numero_os') }}">
                    @error('numero_os')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Serviço:</label>
                    <select name="servico_alarme" class="form-control  @error('servico_alarme') is-invalid  @enderror"
                        required="">
                        <option value="">Selecione</option>
                        @isset($servico_alarme)
                            @foreach ($servico_alarme as $servico)
                                <option value="{{ $servico->id }}">{{ $servico->nome }}</option>
                            @endforeach
                        @endisset
                    </select>
                    @error('servico_alarme')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
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
                    <label>Desconto:</label>
                    <input type="text" name="desconto_comissao" maxlength="190"
                        class="form-control @error('desconto_comissao') is-invalid  @enderror" placeholder="Desconto"
                        value="{{ old('desconto_comissao') }}">
                    @error('desconto_comissao')
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
