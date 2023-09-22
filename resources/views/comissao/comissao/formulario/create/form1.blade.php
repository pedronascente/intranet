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
            <div class="col-md-4">
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
            <div class="col-md-8">
                <div class="form-group">
                    <label>Serviço:</label>
                    <input type="text" name="servico" maxlength="190"
                        class="form-control @error('servico') is-invalid  @enderror" placeholder="Serviço"
                        value="{{ old('servico') }}">
                    @error('servico')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
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
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Meio:</label>
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
                    <label>Ins. / Vendas:</label>
                    <input type="text" name="ins_venda" maxlength="190"
                        class="form-control @error('ins_venda') is-invalid  @enderror" placeholder="Ins. / Vendas"
                        value="{{ old('ins_venda') }}">
                    @error('ins_venda')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
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
                    <label>Desconto da Comissão:</label>
                    <input type="text" name="desconto" maxlength="190"
                        class="form-control @error('desconto') is-invalid  @enderror" placeholder="Desconto da Comissão"
                        value="{{ old('desconto') }}">
                    @error('desconto')
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
