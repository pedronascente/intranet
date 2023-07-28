<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
        <img src="{{ asset('/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image  " style="opacity: .8">
        <span class="brand-text font-weight-light">Intranet</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('/img/colaborador/dummy-round.png') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
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
                <li @if (Request::segment(2) == 'modulo' ||
                        Request::segment(2) == 'permissao' ||
                        Request::segment(2) == 'perfil' ||
                        Request::segment(2) == 'empresa' ||
                        Request::segment(2) == 'cargo' ||
                        Request::segment(2) == 'colaborador' ||
                        Request::segment(2) == 'user' ||
                        Request::segment(2) == 'cartao') class="nav-item  menu-open"  @else   class="nav-item" @endif>
                    <a href="#"
                        @if (Request::segment(2) == 'modulo' ||
                                Request::segment(2) == 'permissao' ||
                                Request::segment(2) == 'perfil' ||
                                Request::segment(2) == 'empresa' ||
                                Request::segment(2) == 'cargo' ||
                                Request::segment(2) == 'colaborador' ||
                                Request::segment(2) == 'user' ||
                                Request::segment(2) == 'cartao') class="nav-link active"  @else   class="nav-link" @endif>
                        <i class="nav-icon fa fa-cog" aria-hidden="true"></i>
                        <p>
                            Configurações<i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/settings/modulo"
                                @if (Request::segment(2) == 'modulo') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p> Modulo</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/settings/permissao"
                                @if (Request::segment(2) == 'permissao') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Permissão</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/settings/perfil"
                                @if (Request::segment(2) == 'perfil') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Perfil</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/settings/empresa"
                                @if (Request::segment(2) == 'empresa') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Empresa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/settings/cargo"
                                @if (Request::segment(2) == 'cargo') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cargo</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/settings/colaborador"
                                @if (Request::segment(2) == 'colaborador') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Colaborador</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/settings/user"
                                @if (Request::segment(2) == 'user') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Usuário</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/settings/cartao"
                                @if (Request::segment(2) == 'cartao') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cartão Token</p>
                            </a>
                        </li>
                    </ul>
                </li>
                </li>
                <li @if (Request::segment(1) == 'setor01' ||
                        Request::segment(1) == 'setor02' ||
                        Request::segment(1) == 'setor03' ||
                        Request::segment(1) == 'setor04') class="nav-item  menu-open"  @else   class="nav-item" @endif>
                    <a href="#"
                        @if (Request::segment(1) == 'setor01' ||
                                Request::segment(1) == 'setor02' ||
                                Request::segment(1) == 'setor03' ||
                                Request::segment(1) == 'setor04') class="nav-link active"  @else   class="nav-link" @endif>
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Menu
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/setor01"
                                @if (Request::segment(1) == 'setor01') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>RH</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/setor02"
                                @if (Request::segment(1) == 'setor02') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rastreameto</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/setor03"
                                @if (Request::segment(1) == 'setor03') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Portario</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/setor04"
                                @if (Request::segment(1) == 'setor04') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Alarme</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
