@include('layouts.includes.head')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <!--div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60"
                width="60">
        </div-->

        <!-- Navbar -->
        @include('layouts.includes.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.includes.barralateral')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">
                                        @if (Request::segment(1) == 'modulo' || Request::segment(1) == 'permissao' || Request::segment(1) == 'perfil')
                                            Configurações
                                        @endif
                                    </a>
                                </li>
                                @if (Request::segment(1))
                                    <li class="breadcrumb-item active">{{ Request::segment(1) }}</li>
                                @endif
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Alerta!</h5>
                                    {{ session('status') }}
                                </div>
                            @elseif (session('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                    {{ session('error') }}
                                </div>
                            @elseif (session('warning'))
                                <div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h5>
                                    {{ session('warning') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('layouts.includes.footer')
    </div>
    @include('layouts.includes.scripts')

</body>

</html>
