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
                <a href="{{ route('user.meuPerfil') }}" class="d-block">
                    @if (Auth::check())
                        {{ Auth::user()->name }}
                    @endif
                </a>
            </div>
        </div>
       
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @if (session()->get('usuarioAutenticado'))
                    @foreach (session()->get('usuarioAutenticado')->perfil->modulos as $modulo)
                        @if ($modulo->tipo_menu=="menu-lateral")
                            @if ($modulo->slug =='administrar-comissao' || $modulo->slug == 'lancar-comissao' )
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-edit"></i>
                                        <p>
                                            Comisão <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview" style="display: none;">
                                        @foreach (session()->get('usuarioAutenticado')->perfil->modulos as $menu)
                                            @if ($menu->slug =='administrar-comissao' || $menu->slug == 'lancar-comissao' )
                                                <li class="nav-item">
                                                    <a href="{{ $menu->rota }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>
                                                            {{ $menu->nome }}  
                                                        </p>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                                @break;
                            @else
                                <li class="nav-item">
                                        <a href="{{ $modulo->rota }}" class="nav-link">
                                            <i class="nav-icon fas fa-edit"></i>
                                            <p>
                                                {{ $item->nome }}  
                                            </p>
                                        </a>
                                    </li>
                            @endif    
                        @endif
                    @endforeach
                @endif
            </ul>
        </nav>
    </div>
</aside>