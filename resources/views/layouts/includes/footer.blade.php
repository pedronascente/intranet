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
/*
Debug :

    $perfilDoUsuarioAutenticado = session()->get('perfilDoUsuarioAutenticado');
    $categoriasDoUsuarioAutenticadoNome = session()->get('categoriasDoUsuarioAutenticadoNome');
    $permissoesDoModuloDaRota = session()->get('permissoesDoModuloDaRota');
    $modulosDoUsuarioAutenticadoSlug = session()->get('modulosDoUsuarioAutenticadoSlug');
    $MenuBarraLateral = session()->get('MenuBarraLateral');

    var_dump([
        'perfilDoUsuarioAutenticado'=> $perfilDoUsuarioAutenticado->perfil->id,
        'categoriasDoUsuarioAutenticadoNome'=> $categoriasDoUsuarioAutenticadoNome,
        'modulosDoUsuarioAutenticadoSlug'=> $modulosDoUsuarioAutenticadoSlug,
        'permissoesDoModuloDaRota'=> $permissoesDoModuloDaRota,
    ]);
*/    

@endphp