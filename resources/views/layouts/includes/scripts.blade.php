<!-- jQuery -->
<script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- daterangepicker -->
<script src="{{ asset('/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<!-- bs-custom-file-input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- mask -->
<script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/dist/js/adminlte.js') }}"></script>

<script>
    // Funções relacionadas ao modal de exclusão
$(document).ready(function() {
    bsCustomFileInput.init();
    $('[data-mask]').inputmask();
    
    $('#deleteModal').on('shown.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var rota = button.data('route');
        // Atualiza o atributo action do formulário com o valor da URL
        $('#deleteForm').attr('action', rota);
    });
});

// Funções relacionadas ao modal de edição de tomada
function fazerConsulta(rota) {
    $.ajax({
        url: rota,
        method: 'GET',
        success: function(response) {
            preencherModal(response);
        },
        error: function(xhr, status, error) {
            // Manipule o erro aqui, se necessário
            console.error(error);
        }
    });
}

function preencherModal(data) {
    $('#tomada_tomada').val(data.tomada);
    $('#tomada_api').val(data.api);
    $('#editarTomadaForm').attr('action', data.rota);
    $('#editarTomadaModal').modal('show');
}

$(document).ready(function() {
    $('.editarTomadaLink').click(function() {
        var rota = $(this).data('route');
        fazerConsulta(rota);
    });
});
 
@stack('scripts')
</script>