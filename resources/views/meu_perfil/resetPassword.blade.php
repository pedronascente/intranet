<form action="{{ route('user.resetarSenha', $colaborador->user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Senha:</label>
                    <input type="text" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="senha" value="{{ old('password') }}">
                    @error('password')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Confirma senha:</label>
                    <input type="text" name="password_confirmation"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="confirmar senha" value="{{ old('password_confirmation') }}">
                    @error('password_confirmation')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <x-ui.panel-dica-boa-senha />
    </div>
    <div class="card-footer">
        <x-botao.btn-salvar />
    </div>
</form>
