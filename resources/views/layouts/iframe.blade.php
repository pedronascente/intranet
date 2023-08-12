@include('layouts.includes.head')

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
