@php
    $admin = App\Models\Admin::where('id', session('user'))->first();
    $role  = $admin->role ?? '';
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    {{-- ── Brand ── --}}
    <a href="{{ url('/') }}" class="brand-link" title="Select Cars">
        <img src="{{ asset('assets/back/img/select-cars_logo-white.png') }}"
             alt="Select Cars" class="brand-image">
    </a>

    <div class="sidebar os-host-scrollbar">

        {{-- ── User panel ── --}}
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <img src="{{ asset('assets/back/img/avatar5.png') }}"
                     class="img-circle elevation-2" alt="avatar">
            </div>
            <div class="info">
                <span class="d-block font-weight-bold text-white">{{ $admin->nom }} {{ $admin->prenom }}</span>
                <small class="text-muted">{{ ucfirst($role) }}</small><br>
                <a href="{{ route('logoutSession') }}" class="text-danger" style="font-size:12px">
                    <i class="fas fa-sign-out-alt mr-1"></i>Déconnecter
                </a>
            </div>
        </div>

        {{-- ── Nav ── --}}
        <nav class="mt-2 pb-3">
            <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent"
                data-widget="treeview" role="menu" data-accordion="false">

                {{-- ═══════════════════════════════════════
                     ADMIN
                ═══════════════════════════════════════ --}}
                @if($role === 'admin')

                    {{-- Tableau de bord --}}
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                           class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Tableau de bord</p>
                        </a>
                    </li>

                    {{-- ─ Séparateur ─ --}}
                    <li class="nav-header">CATALOGUE</li>

                    {{-- Pièces / Marques / Modèles --}}
                    @php
                        $catalogueActive = request()->is('admin/list_machine*','admin/list_marque*','admin/list_model*');
                    @endphp
                    <li class="nav-item {{ $catalogueActive ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $catalogueActive ? 'active' : '' }}">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>Produits <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.list_machine') }}"
                                   class="nav-link {{ request()->is('admin/list_machine') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Liste des pièces</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('list_marque.machine') }}"
                                   class="nav-link {{ request()->is('admin/list_marque') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Marques</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('list_model.machine') }}"
                                   class="nav-link {{ request()->is('admin/list_model') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Modèles</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Stock --}}
                    <li class="nav-item {{ request()->is('admin/list_stock*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/list_stock*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>Stock <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.list_stock.machine') }}"
                                   class="nav-link {{ request()->is('admin/list_stock/machine') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Mouvement de stock</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- ─ Séparateur ─ --}}
                    <li class="nav-header">VENTES</li>

                    {{-- Commandes machines --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.list_commandeM') }}"
                           class="nav-link {{ request()->is('admin/list_commandeM*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-invoice"></i>
                            <p>Commandes
                                @php $nbCmd = \App\Models\Commande_M::count(); @endphp
                                @if($nbCmd > 0)
                                    <span class="badge badge-warning right">{{ $nbCmd }}</span>
                                @endif
                            </p>
                        </a>
                    </li>

                    {{-- ─ Séparateur ─ --}}
                    <li class="nav-header">GESTION</li>

                    {{-- Clients --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.list_client') }}"
                           class="nav-link {{ request()->is('admin/list_client*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Clients</p>
                        </a>
                    </li>

                    {{-- Comptes --}}
                    <li class="nav-item {{ request()->is('admin/list_compte*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/list_compte*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>Comptes <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('compte') }}"
                                   class="nav-link {{ request()->is('admin/list_compte/list') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Liste des comptes</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.list_livreur') }}"
                                   class="nav-link {{ request()->is('admin/list_livreurs*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Livreurs</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Support SAV --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.list_support') }}"
                           class="nav-link {{ request()->is('admin/support*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-headset"></i>
                            <p>Support SAV
                                @php $nbTickets = \App\Models\Support::count(); @endphp
                                @if($nbTickets > 0)
                                    <span class="badge badge-danger right">{{ $nbTickets }}</span>
                                @endif
                            </p>
                        </a>
                    </li>

                    {{-- ─ Séparateur ─ --}}
                    <li class="nav-header">CONTENU</li>

                    {{-- Bannières --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.list_banners') }}"
                           class="nav-link {{ request()->is('admin/list_banners*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-images"></i>
                            <p>Bannières</p>
                        </a>
                    </li>

                    {{-- FAQ --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.list_faq') }}"
                           class="nav-link {{ request()->is('admin/list_faq*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>FAQ</p>
                        </a>
                    </li>

                    {{-- Contact --}}
                    <li class="nav-item">
                        <a href="{{ route('list_contact') }}"
                           class="nav-link {{ request()->is('admin/list_contact*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-envelope"></i>
                            <p>Messages
                                @php $nbContacts = \App\Models\Contact::count(); @endphp
                                @if($nbContacts > 0)
                                    <span class="badge badge-info right">{{ $nbContacts }}</span>
                                @endif
                            </p>
                        </a>
                    </li>

                {{-- ═══════════════════════════════════════
                     CLIENT
                ═══════════════════════════════════════ --}}
                @elseif($role === 'client')

                    <li class="nav-header">CATALOGUE</li>

                    <li class="nav-item">
                        <a href="{{ route('client.list_machine') }}"
                           class="nav-link {{ request()->is('client/list_machine*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Liste des pièces</p>
                        </a>
                    </li>

                    @if($admin->groupe != 0)
                        <li class="nav-header">COMMANDES</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.list_commandeM') }}"
                               class="nav-link {{ request()->is('admin/list_commandeM*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-invoice"></i>
                                <p>Mes commandes</p>
                            </a>
                        </li>
                    @endif

                    <li class="nav-header">SUPPORT</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.list_support.add') }}"
                           class="nav-link {{ request()->is('admin/support/add') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-headset"></i>
                            <p>Créer un ticket SAV</p>
                        </a>
                    </li>

                {{-- ═══════════════════════════════════════
                     LIVREUR
                ═══════════════════════════════════════ --}}
                @elseif($role === 'livreur')

                    <li class="nav-header">TABLEAU DE BORD</li>

                    <li class="nav-item">
                        <a href="{{ route('dashboardL') }}"
                           class="nav-link {{ request()->is('admin/dashboardL') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Tableau de bord</p>
                        </a>
                    </li>

                @endif

            </ul>
        </nav>
    </div>
</aside>
