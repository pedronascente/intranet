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
                <li class="nav-item  menu-open">
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
                        @foreach (session()->get('perfil')['modulos'] as $item)
                            <li class="nav-item">
                                <a href="{{ $item['rota'] }}"
                                    @if (Request::segment(2) == $item['nome']) class="nav-link active"  @else   class="nav-link" @endif>
                                    <i class="far fa-circle nav-icon"></i>
                                    <p> {{ $item['nome'] }}</p>
                                </a>
                            </li>
                        @endforeach




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
