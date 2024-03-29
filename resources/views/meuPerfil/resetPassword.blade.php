<form action="{{ route('meuPerfil.resetarSenha', $colaborador->usuario->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nova Senha:</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="senha" value="{{ old('password') }}">
                    @error('password')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Confirma senha:</label>
                    <input type="password" name="password_confirmation"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="confirmar senha" value="{{ old('password_confirmation') }}">
                    @error('password_confirmation')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        
            <div class="col-md-6">
                <x-ui.panel-dica-boa-senha />
            </div>
        </div>
        
    </div>
    <div class="card-footer">
        <x-botao.btn-salvar />
    </div>
</form>
