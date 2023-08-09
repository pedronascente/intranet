@include('layouts.includes.head')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    @if (Request::segment(2))
                        {{ Str::title(Request::segment(2)) }}
                    @endif
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        @if (Request::segment(1) == 'settings')
                            Configurações
                        @endif
                    </li>
                    @if (Request::segment(2))
                        <li class="breadcrumb-item active">{{ Request::segment(2) }}</li>
                    @endif
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

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


    @include('layouts.includes.footer')


</section>


<!-- ./wrapper -->
@include('layouts.includes.scripts')


</body>

</html>
