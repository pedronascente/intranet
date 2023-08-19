@include('layouts.includes.head')
@include('layouts.includes.navbar')

<body>
    <x-ui.titulo :titulo="Request::segment(2)" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> {{ session('status') }}</h5>
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-ban"></i>{{ session('error') }}</h5>
                        </div>
                    @elseif (session('warning'))
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> {{ session('warning') }}</h5>
                        </div>
                    @endif
                </div>
            </div>
            @yield('content')

        </div>
    </section>

    @include('layouts.includes.footer')
    @include('layouts.includes.scripts')
    <script>
        $(function() {
            $('#deleteModal').on('shown.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var recipientId = button.data('id');
                var modal = $(this);
                modal.find('#id').val(recipientId);
            });
        });
    </script>
</body>

</html>













===================

@include('layouts.includes.head')

<body class="hold-transition sidebar-mini " data-panel-auto-height-mode="height">
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.includes.navbar')

        @include('layouts.includes.barralateral')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="800">
            <!-- Main Sidebar Container -->

            <div class="nav navbar navbar-expand navbar-white navbar-light border-bottom p-0">
                <div class="nav-item dropdown">
                    <a class="nav-link bg-danger dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                        aria-haspopup="true" aria-expanded="false">Fechar</a>
                    <div class="dropdown-menu mt-0">
                        <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all">
                            Todos</a>
                        <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all-other">
                            Todos os outros</a>
                    </div>
                </div>
                <a class="nav-link bg-light" href="#" data-widget="iframe-scrollleft"><i
                        class="fas fa-angle-double-left"></i></a>
                <ul class="navbar-nav overflow-hidden" role="tablist"></ul>
                <a class="nav-link bg-light" href="#" data-widget="iframe-scrollright"><i
                        class="fas fa-angle-double-right"></i></a>
                <a class="nav-link bg-light" href="#" data-widget="iframe-fullscreen"><i
                        class="fas fa-expand"></i></a>
            </div>
            <div class="tab-content">
                <div class="tab-empty">
                    <h2 class="display-4">
                        Nenhuma aba selecionada!</h2>
                </div>
                <div class="tab-loading">
                    <div>
                        <h2 class="display-4">carregando <i class="fa fa-sync fa-spin"></i></h2>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- ./wrapper -->
    @include('layouts.includes.scripts')

</body>

</html>
