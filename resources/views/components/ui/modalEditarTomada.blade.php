<div class="modal fade" id="editarTomadaModal" tabindex="-1" role="dialog" aria-labelledby="editarTomalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarTomalLabel">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <form id="editarTomadaForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tomada:</label>
                                <input type="text" id="tomada_tomada" name="tomada" maxlength="190" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label>Api:</label>
                                <input type="text" id="tomada_api" name="api" maxlength="190" class="form-control" value="">
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