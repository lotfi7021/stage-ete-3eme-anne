<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('assets/back/img/select-cars_logo-white.png') }}" alt="{{ $titleSeo }}" style="width:150px;height:auto;">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">

      @php
        $admin = Auth::guard('admin')->user();
        $nbTickets = Cache::remember('back.tickets.count', 300, fn () => \App\Models\Support::count());
      @endphp

      {{-- ===================== ADMIN NAV ===================== --}}
      @can('role', 'admin')

        {{-- Lien vers le site --}}
        <li class="nav-item">
          <a href="{{ url('/') }}" target="_blank" class="nav-link" title="Vers le site web">
            <i class="fas fa-globe"></i>
          </a>
        </li>

        {{-- Notifications Contact --}}
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comment"></i>
            <span class="badge badge-danger navbar-badge">{{ \App\Models\Contact::count() }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">{{ \App\Models\Contact::count() }} Contact(s)</span>
            <div class="dropdown-divider"></div>
            <a href="{{ route('list_contact') }}" class="dropdown-item dropdown-footer">Voir les contacts</a>
          </div>
        </li>

        {{-- Notifications Tickets --}}
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">{{ $nbTickets }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">{{ $nbTickets }} Ticket(s)</span>
            <div class="dropdown-divider"></div>
            <a href="{{ route('admin.list_support') }}" class="dropdown-item dropdown-footer">Voir les tickets</a>
          </div>
        </li>

        {{-- Vider le cache --}}
        <li class="nav-item">
          <form action="{{ route('cache.clear') }}" method="post" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-warning btn-sm mt-1 mr-2">
              <i class="fas fa-broom"></i> Vider le cache
            </button>
          </form>
        </li>

        {{-- Plein écran --}}
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>

      {{-- ===================== CLIENT NAV ===================== --}}
      @elsecan('role', 'client')

        <li class="nav-item">
          <a href="{{ url('/') }}" target="_blank" class="nav-link" title="Vers le site web">
            <i class="fas fa-globe"></i>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.list_support.add') }}" class="btn btn-danger btn-sm mt-1 mr-2" title="Service après vente">
            SAV
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>

      {{-- ===================== LIVREUR NAV ===================== --}}
      @else

        <li class="nav-item">
          <form action="{{ route('cache.clear') }}" method="post" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-warning btn-sm mt-1 mr-2">
              <i class="fas fa-broom"></i> Vider le cache
            </button>
          </form>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>

      @endcan

      {{-- Bascule de thème clair / sombre (visible pour les 3 rôles) --}}
      <li class="nav-item">
        <a href="#" class="nav-link rm-theme-toggle" role="button" aria-label="Basculer le thème clair / sombre" title="Thème clair / sombre">
          <i class="fas fa-moon"></i>
        </a>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->
