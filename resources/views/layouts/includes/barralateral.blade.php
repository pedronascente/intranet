<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <img src="{{ asset('/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image  " style="opacity: .8">
        <span class="brand-text font-weight-light">Intranet</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
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
                <a href="{{ route('profile') }}" class="d-block">
                    @if (Auth::check())
                        {{ Auth::user()->name }}
                    @endif
                </a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!--li class="nav-item  menu-open">
                    <a href="javascript:void(0)"
                        @if (Request::segment(2) == 'modulo' ||
                                Request::segment(2) == 'permissao' ||
                                Request::segment(2) == 'perfil' ||
                                Request::segment(2) == 'base' ||
                                Request::segment(2) == 'empresa' ||
                                Request::segment(2) == 'cargo' ||
                                Request::segment(2) == 'colaborador' ||
                                Request::segment(2) == 'user' ||
                                Request::segment(2) == 'cartao') class="nav-link active"  @else   class="nav-link" @endif>
                        <i class="nav-icon fa fa-cog" aria-hidden="true"></i>
                        <p>
                            Configurações <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (session()->get('perfil'))
@foreach (session()->get('perfil')['modulos'] as $item)
<li class="nav-item">
                                    <a href="{{ $item['rota'] }}"
                                        @if (Request::segment(2) == $item['slug']) class="nav-link active"  @else   class="nav-link" @endif>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> {{ $item['nome'] }}</p>
                                    </a>
                                </li>
@endforeach
@endif
                    </ul>
                </li-->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Comisão
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('planilha-colaborador.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Adicionar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('planilha-administrativo.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Conferir</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('planilha-administrativo.arquivo') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Arquivo</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
