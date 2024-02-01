  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
      </ul>
      <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                  <i class="nav-icon fa fa-cog" aria-hidden="true"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="left: inherit; right: 0px;">
                  <a href="{{ route('configuracoes.index') }}" class="dropdown-item dropdown-footer">Configurações</a>
                  <div class="dropdown-divider">
                  </div>
                  <a href="{{ route('user.meuPerfil') }}" class="dropdown-item dropdown-footer">Meu Perfil</a>
                  <div class="dropdown-divider">
                  </div>
                  <a href="{{ route('login.sair') }}" class="dropdown-item dropdown-footer">Sair</a>
               </div>
          </li>
      </ul>
  </nav>
