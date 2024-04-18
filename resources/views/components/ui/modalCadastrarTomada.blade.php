<div class="modal fade" id="cadastrarTomadaModal" tabindex="-1" role="dialog" aria-labelledby="cadastrarTomalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cadastrarlTomalLabel">Cadastrar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <form  action="{{ route('tomada.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tomada:</label>
                                <input type="text"  name="tomada" maxlength="190" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Api:</label>
                                <input type="text"  name="api" maxlength="190" class="form-control" required>

                                <input type="hidden"  name="regua_id" maxlength="10" class="form-control" value="{{ $regua }}">
                            </div>
                        </div>
                        <div class="card-footer">
                            <x-botao.btn-salvar />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>