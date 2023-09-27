<form action="{{ route('comissao.store') }}" method="POST" name="Formulario-create">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
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
            <div class="col-md-2">
                <div class="form-group">
                    <label>ID Contrato:</label>
                    <input type="text" name="id_contrato"
                        class="form-control @error('id_contrato') is-invalid  @enderror" placeholder="ID Contrato"
                        value="{{ old('id_contrato') }}">
                    @error('id_contrato')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Qtd. veículo:</label>
                    <input type="text" name="qtd_veiculo" maxlength="3"
                        class="form-control @error('qtd_veiculo') is-invalid  @enderror" placeholder="Qtd. veúculo"
                        value="{{ old('qtd_veiculo') }}">
                    @error('qtd_veiculo')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Placa:</label>
                    <input type="text" name="placa" maxlength="190"
                        class="form-control @error('placa') is-invalid  @enderror" placeholder="Placa"
                        value="{{ old('placa') }}">
                    @error('placa')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Taxa Instalação:</label>
                    <input type="text" name="taxa_instalacao" maxlength="190"
                        class="form-control @error('taxa_instalacao') is-invalid  @enderror"
                        placeholder="Taxa Instalação" value="{{ old('taxa_instalacao') }}">
                    @error('taxa_instalacao')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Mensal:</label>
                    <input type="text" name="mensal" maxlength="190"
                        class="form-control @error('mensal') is-invalid  @enderror" placeholder="Mensal"
                        value="{{ old('mensal') }}">
                    @error('mensal')
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
                    <label>Desconto:</label>
                    <input type="text" name="desconto_comissao" maxlength="190"
                        class="form-control @error('desconto_comissao') is-invalid  @enderror"
                        placeholder="Desconto" value="{{ old('desconto_comissao') }}">
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
