<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image  " style="opacity: .8">
        <span class="brand-text font-weight-light">Intranet</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li @if (Request::segment(1) == 'perfil' ||
                        Request::segment(1) == 'user' ||
                        Request::segment(1) == 'empresa' ||
                        Request::segment(1) == 'cargo' ||
                        Request::segment(1) == 'colaborador' ||
                        Request::segment(1) == 'permissao' ||
                        Request::segment(1) == 'modulo') class="nav-item menu-open"  @else  class="nav-item" @endif>

                    <a href="#"
                        @if (Request::segment(1) == 'perfil' ||
                                Request::segment(1) == 'user' ||
                                Request::segment(1) == 'empresa' ||
                                Request::segment(1) == 'cargo' ||
                                Request::segment(1) == 'colaborador' ||
                                Request::segment(1) == 'permissao' ||
                                Request::segment(1) == 'modulo') class="nav-link active"  @else   class="nav-link" @endif>
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Admin <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li
                            @if (Request::segment(1) == 'modulo' || Request::segment(1) == 'permissao' || Request::segment(1) == 'perfil') class="nav-item  menu-open"  @else   class="nav-item" @endif>
                            <a href="#"
                                @if (Request::segment(1) == 'modulo' || Request::segment(1) == 'permissao' || Request::segment(1) == 'perfil') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="nav-icon far fa-user"></i>
                                <p>
                                    Grupo
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/modulo"
                                        @if (Request::segment(1) == 'modulo') class="nav-link active"  @else   class="nav-link" @endif>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> Modulo</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/permissao"
                                        @if (Request::segment(1) == 'permissao') class="nav-link active"  @else   class="nav-link" @endif>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Permissão</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/perfil"
                                        @if (Request::segment(1) == 'perfil') class="nav-link active"  @else   class="nav-link" @endif>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Perfil</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li
                            @if (Request::segment(1) == 'empresa' || Request::segment(1) == 'cargo' || Request::segment(1) == 'colaborador') class="nav-item  menu-open"  @else   class="nav-item" @endif>
                            <a href="#"
                                @if (Request::segment(1) == 'empresa' || Request::segment(1) == 'cargo' || Request::segment(1) == 'colaborador') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="nav-icon far fa-user"></i>
                                <p>
                                    Colaborador
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/empresa"
                                        @if (Request::segment(1) == 'empresa') class="nav-link active"  @else   class="nav-link" @endif>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Empresa</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/cargo"
                                        @if (Request::segment(1) == 'cargo') class="nav-link active"  @else   class="nav-link" @endif>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cargo</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/colaborador"
                                        @if (Request::segment(1) == 'colaborador') class="nav-link active"  @else   class="nav-link" @endif>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Colaborador</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            @if (Request::segment(1) == 'user' || Request::segment(1) == 'cartao') class="nav-item  menu-open"  @else   class="nav-item" @endif>
                            <a href="#"
                                @if (Request::segment(1) == 'user' || Request::segment(1) == 'cartao') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="nav-icon far fa-user"></i>
                                <p>
                                    Usuário
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/user"
                                        @if (Request::segment(1) == 'user') class="nav-link active"  @else   class="nav-link" @endif>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>usuário</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/cartao"
                                        @if (Request::segment(1) == 'cartao') class="nav-link active"  @else   class="nav-link" @endif>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cartão de Acesso (Token)</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
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
                                <p>Stor XYZ-01</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/setor02"
                                @if (Request::segment(1) == 'setor02') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stor XYZ-02</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/setor03"
                                @if (Request::segment(1) == 'setor03') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stor XYZ-03</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/setor04"
                                @if (Request::segment(1) == 'setor04') class="nav-link active"  @else   class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stor XYZ-04</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
