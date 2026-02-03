<div class="sidebar-area" id="sidebar-area">
    <div class="logo position-relative d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="d-block text-decoration-none position-relative">
            <img src="{{ asset('assets/images/logo-icon.png') }}" alt="logo-icon">
            <span class="logo-text text-secondary fw-semibold">StarCode</span>
        </a>
        <button
            class="sidebar-burger-menu-close bg-transparent py-3 border-0 opacity-0 z-n1 position-absolute top-50 end-0 translate-middle-y"
            id="sidebar-burger-menu-close">
            <span class="border-1 d-block for-dark-burger"
                style="border-bottom: 1px solid #475569; height: 1px; width: 25px; transform: rotate(45deg);">
            </span>
            <span class="border-1 d-block for-dark-burger"
                style="border-bottom: 1px solid #475569; height: 1px; width: 25px; transform: rotate(-45deg);">
            </span>
        </button>
        <button class="sidebar-burger-menu bg-transparent p-0 border-0" id="sidebar-burger-menu">
            <span class="border-1 d-block for-dark-burger"
                style="border-bottom: 1px solid #475569; height: 1px; width: 25px;">
            </span>
            <span class="border-1 d-block for-dark-burger"
                style="border-bottom: 1px solid #475569; height: 1px; width: 25px; margin: 6px 0;">
            </span>
            <span class="border-1 d-block for-dark-burger"
                style="border-bottom: 1px solid #475569; height: 1px; width: 25px;">
            </span>
        </button>
    </div>

    <aside class="layout-menu menu-vertical menu active" data-simplebar id="layout-menu">
        <ul class="menu-inner">
            <li class="menu-title small text-uppercase">
                <span class="menu-title-text">PRINCIPAL</span>
            </li>
            <li class="menu-item {{ request()->routeIs('dashboard') ? 'open' : '' }}">
                <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <span class="material-symbols-outlined menu-icon">dashboard</span>
                    <span class="title">Tableau de bord</span>
                </a>
            </li>

            <li class="menu-title small text-uppercase">
                <span class="menu-title-text">GESTION</span>
            </li>
            <li class="menu-item">
                <a class="menu-link {{ request()->routeIs('projects.*') ? 'active' : '' }}"
                    href="{{ route('projects.index') }}">
                    <span class="material-symbols-outlined menu-icon">assignment</span>
                    <span class="title">Projets</span>
                </a>
            </li>
            <li class="menu-item">
                <a class="menu-link {{ request()->routeIs('clients.*') ? 'active' : '' }}"
                    href="{{ route('clients.index') }}">
                    <span class="material-symbols-outlined menu-icon">handshake</span>
                    <span class="title">Clients</span>
                </a>
            </li>
            <li class="menu-item">
                <a class="menu-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}"
                    href="{{ route('tasks.index') }}">
                    <span class="material-symbols-outlined menu-icon">ballot</span>
                    <span class="title">Tâches</span>
                </a>
            </li>
            <li class="menu-item">
                <a class="menu-link {{ request()->routeIs('team.*') ? 'active' : '' }}"
                    href="{{ route('team.index') }}">
                    <span class="material-symbols-outlined menu-icon">group</span>
                    <span class="title">Équipe</span>
                </a>
            </li>

            <li class="menu-title small text-uppercase">
                <span class="menu-title-text">FINANCES</span>
            </li>
            <li class="menu-item">
                <a class="menu-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}"
                    href="{{ route('invoices.index') }}">
                    <span class="material-symbols-outlined menu-icon">receipt_long</span>
                    <span class="title">Factures</span>
                </a>
            </li>
            <li class="menu-item">
                <a class="menu-link {{ request()->routeIs('finances.*') ? 'active' : '' }}"
                    href="{{ route('finances.index') }}">
                    <span class="material-symbols-outlined menu-icon">payments</span>
                    <span class="title">Dépenses & Revenus</span>
                </a>
            </li>
            <li class="menu-item">
                <a class="menu-link {{ request()->routeIs('renewals.*') ? 'active' : '' }}"
                    href="{{ route('renewals.index') }}">
                    <span class="material-symbols-outlined menu-icon">sync</span>
                    <span class="title">Renouvellements</span>
                </a>
            </li>

            <li class="menu-title small text-uppercase">
                <span class="menu-title-text">ANALYSES</span>
            </li>
            <li class="menu-item">
                <a class="menu-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
                    href="{{ route('reports.index') }}">
                    <span class="material-symbols-outlined menu-icon">monitoring</span>
                    <span class="title">Rapports</span>
                </a>
            </li>
            <li class="menu-item {{ request()->is('settings/company') ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('settings.company') }}">
                    <span class="material-symbols-outlined menu-icon">settings</span>
                    <span class="title">Paramètres Entreprise</span>
                </a>
            </li>
        </ul>
    </aside>
</div>