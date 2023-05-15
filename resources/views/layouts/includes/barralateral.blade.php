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
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v1</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">Setor</li>
                <li class="nav-item">
                    <a href="/administracao" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Administração
                            <span class="badge badge-info right">2</span>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Comercial
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/alarme" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Alarme</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/rastreamento" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rastreamento</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="portaria" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Portaria</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            RH
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="sac" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>SAC</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/sesmt" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sesmt</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/usuario" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Usuário</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="/tecnica" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Técnica

                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
