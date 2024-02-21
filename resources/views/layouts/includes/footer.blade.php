<footer class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <strong>Copyright &copy; {{ date('Y') }} <a href="/">Intranet</a>.</strong>
            Todos os direitos reservados.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </div>
    </div>
</footer>
@php
    $permissoesDoModuloDaRota = session()->get('permissoesDoModuloDaRota');
    var_dump($permissoesDoModuloDaRota);
@endphp
