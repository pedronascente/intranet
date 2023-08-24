<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $titulo }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @if (Request::segment(1) == 'dashboard')
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ route('configuracoes') }}">Configurações</a></li>
                    @endif
                    <li class="breadcrumb-item active">{{ $titulo }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>
