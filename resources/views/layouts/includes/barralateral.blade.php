<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/dashboard" class="brand-link">
        <img src="{{ asset('/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image  " style="opacity: .8">
        <span class="brand-text font-weight-light">Intranet</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (Auth::check() && Auth::user()->colaborador)
                    <img src="{{ asset('/img/colaborador/' . Auth::user()->colaborador->foto . '') }}"
                        class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{ asset('/img/colaborador/dummy-round.png') }}" class="img-circle elevation-2"
                        alt="User Image">
                @endif
            </div>
            <div class="info">
                <a href="{{ route('meuPerfil.index') }}" class="d-block">
                    @if (Auth::check())
                        {{ Auth::user()->colaborador->nome }}
                    @endif
                </a> 
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @php
                    $modulosDoUsuarioAutenticadoId = session()->get('modulosDoUsuarioAutenticadoId');
                    $categoriasDoUsuarioAutenticadoNome = session()->get('categoriasDoUsuarioAutenticadoNome') ? session()->get('categoriasDoUsuarioAutenticadoNome') : [];
                @endphp
                @if ($MenuBarraLateral)
                    @foreach ($MenuBarraLateral as $categoria)
                        @if(in_array($categoria->nome,$categoriasDoUsuarioAutenticadoNome))
                            <li class="nav-item   @if($categoria->ativo) menu-is-opening menu-open @endif">
                                <a href="#" class="nav-link  {{ $categoria->ativo }} ">
                                    <i class="nav-icon fas fa-edit"></i>
                                    <p>{{ $categoria->nome }}<i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview" 
                                    @if($categoria->ativo) 
                                        style="display: block;" 
                                    @endif 
                                    >
                                    @foreach ( $categoria->modulos as $modulo)
                                        @if (in_array($modulo->id, $modulosDoUsuarioAutenticadoId))
                                            <li class="nav-item">
                                                <a href="{{ $modulo->rota }}" class="nav-link  {{ $modulo->ativo }}" >
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>
                                                        {{ $modulo->nome  }} 
                                                    </p>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                @endif   
            </ul>
        </nav>
    </div>
</aside>