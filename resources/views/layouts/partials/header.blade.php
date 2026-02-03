<header class="header-area bg-white mb-4 rounded-10 border border-white" id="header-area">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="left-header-content">
                <ul
                    class="d-flex align-items-center ps-0 mb-0 list-unstyled justify-content-center justify-content-md-start">
                    <li class="d-xl-none">
                        <button class="header-burger-menu bg-transparent p-0 border-0 position-relative top-3"
                            id="header-burger-menu">
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
                    </li>
                    <li class="ms-3">
                        <form class="src-form position-relative">
                            <input type="text" class="form-control" placeholder="Rechercher ici ..">
                            <span
                                class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y ms-2">search</span>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="right-header-content mt-3 mt-md-0">
                <ul class="d-flex align-items-center justify-content-end ps-0 mb-0 list-unstyled">
                    <li class="header-right-item">
                        <div class="dropdown notifications">
                            <button class="btn btn-secondary border-0 p-0 position-relative bg-transparent"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">notifications</span>
                                <span
                                    class="badge bg-danger position-absolute top-0 start-100 translate-middle p-1 border border-light rounded-circle"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end p-0">
                                <div class="d-flex justify-content-between align-items-center border-bottom p-3">
                                    <h6 class="mb-0">Notifications</h6>
                                    <a href="#" class="text-decoration-none">Tout effacer</a>
                                </div>
                                <div class="max-h-300" data-simplebar>
                                    <div class="p-3">
                                        <p class="mb-0">Pas de nouvelles notifications</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="header-right-item ms-3">
                        <div class="dropdown profile">
                            <button class="btn btn-secondary border-0 p-0 position-relative bg-transparent"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('assets/images/user1.jpg') }}" class="rounded-circle" width="35"
                                    height="35" alt="user">
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('settings.profile') }}">Profil</a>
                                <a class="dropdown-item" href="{{ route('settings.profile') }}">Paramètres</a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Déconnexion</button>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>