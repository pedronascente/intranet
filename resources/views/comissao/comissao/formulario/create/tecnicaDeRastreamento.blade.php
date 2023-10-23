<form action="{{ route('comissao.store') }}" method="POST" name="Formulario-create">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
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
            <div class="col-md-3">
                <div class="form-group">
                    <label>Data:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control  @error('data') is-invalid  @enderror"
                            data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask=""
                            inputmode="numeric" value="{{ old('data') }}">
                        @error('data')
                            <span class=" invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Conta / Pedido:</label>
                    <input type="text" name="conta_pedido" maxlength="190"
                        class="form-control @error('conta_pedido') is-invalid  @enderror" placeholder="Conta/Periodo"
                        value="{{ old('conta_pedido') }}">
                    @error('conta_pedido')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
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
            <div class="col-md-3">
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
            <div class="col-md-3">
                <div class="form-group">
                    <label>Desconto:</label>
                    <input type="text" name="desconto" maxlength="190"
                        class="form-control @error('desconto') is-invalid  @enderror" placeholder="Desconto"
                        value="{{ old('desconto') }}">
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
