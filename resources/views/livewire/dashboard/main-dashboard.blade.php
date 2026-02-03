<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Tableau de bord</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tableau de bord</li>
            </ol>
        </nav>
    </div>

    <!-- Stats Overview -->
    <div class="card bg-white p-20 pb-0 rounded-10 border border-white mb-4">
        <h3 class="mb-20">Aperçu des Projets</h3>
        <div class="row" style="--bs-gutter-x: 20px;">
            <div class="col-xxl-3 col-md-6">
                <div class="card bg-body-bg p-20 rounded-10 border border-white mb-20">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h3 class="mb-10 fw-medium fs-16 text-muted">Total des Projets</h3>
                            <h2 class="fs-26 fw-medium mb-0 lh-1">{{ $stats['total_projects'] }}</h2>
                        </div>
                        <div class="flex-shrink-0 ms-sm-3">
                            <div class="bg-primary text-center rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <span class="material-symbols-outlined text-white">assignment</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="card bg-body-bg p-20 rounded-10 border border-white mb-20">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h3 class="mb-10 fw-medium fs-16 text-muted">Projets Actifs</h3>
                            <h2 class="fs-26 fw-medium mb-0 lh-1">{{ $stats['active_projects'] }}</h2>
                        </div>
                        <div class="flex-shrink-0 ms-sm-3">
                            <div class="bg-warning text-center rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <span class="material-symbols-outlined text-white">pending_actions</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="card bg-body-bg p-20 rounded-10 border border-white mb-20">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h3 class="mb-10 fw-medium fs-16 text-muted">Revenu Total</h3>
                            <h2 class="fs-26 fw-medium mb-0 lh-1">$ {{ number_format($stats['total_revenue'], 2) }}</h2>
                        </div>
                        <div class="flex-shrink-0 ms-sm-3">
                            <div class="bg-success text-center rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <span class="material-symbols-outlined text-white">payments</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="card bg-body-bg p-20 rounded-10 border border-white mb-20">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h3 class="mb-10 fw-medium fs-16 text-muted">Factures en Attente</h3>
                            <h2 class="fs-26 fw-medium mb-0 lh-1">{{ $stats['pending_invoices'] }}</h2>
                        </div>
                        <div class="flex-shrink-0 ms-sm-3">
                            <div class="bg-info text-center rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <span class="material-symbols-outlined text-white">receipt_long</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Projects -->
        <div class="col-lg-8">
            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Projets Récents</h4>
                        <a href="{{ route('projects.index') }}" class="text-decoration-none border-bottom">Voir Tout</a>
                    </div>
                    <div class="default-table-area table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th class="fw-medium">Nom du Projet</th>
                                    <th class="fw-medium">Client</th>
                                    <th class="fw-medium">Statut</th>
                                    <th class="fw-medium">Progression</th>
                                    <th class="fw-medium">Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentProjects as $project)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px;">
                                                        <span class="material-symbols-outlined">folder</span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">{{ $project->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-secondary">{{ $project->client->name }}</td>
                                        <td>
                                            @php
                                                $statusMap = [
                                                    'in_progress' => ['label' => 'En Cours', 'class' => 'warning'],
                                                    'completed' => ['label' => 'Terminé', 'class' => 'success'],
                                                    'pending' => ['label' => 'En Attente', 'class' => 'info'],
                                                    'cancelled' => ['label' => 'Annulé', 'class' => 'danger'],
                                                ];
                                                $status = $statusMap[$project->status] ?? ['label' => $project->status, 'class' => 'secondary'];
                                            @endphp
                                            <span
                                                class="badge bg-{{ $status['class'] }} bg-opacity-10 text-{{ $status['class'] }} d-inline-block default-badge">
                                                {{ $status['label'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 5px; width: 100px;">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                    style="width: {{ $project->progress }}%"
                                                    aria-valuenow="{{ $project->progress }}" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                            <span class="fs-12 text-muted">{{ $project->progress }}%</span>
                                        </td>
                                        <td class="text-body fw-medium">$ {{ number_format($project->budget, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Aucun projet trouvé</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Renewals -->
        <div class="col-lg-4">
            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Renouvellements à venir</h4>
                        <span class="badge bg-danger rounded-pill">{{ count($upcomingRenewals) }}</span>
                    </div>
                    <ul class="list-unstyled mb-0">
                        @forelse($upcomingRenewals as $renewal)
                            <li
                                class="d-flex align-items-center border-bottom py-3 {{ $loop->last ? 'border-bottom-0 pb-0' : '' }}">
                                <div class="flex-shrink-0">
                                    <div class="bg-{{ $renewal->type === 'hosting' ? 'info' : 'warning' }} bg-opacity-10 text-{{ $renewal->type === 'hosting' ? 'info' : 'warning' }} rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px;">
                                        <span
                                            class="material-symbols-outlined">{{ $renewal->type === 'hosting' ? 'dns' : 'language' }}</span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0 fs-14">{{ $renewal->service_name }}</h6>
                                    <span class="text-muted fs-12">{{ $renewal->client->name }} -
                                        {{ $renewal->renewal_date->translatedFormat('d M, Y') }}</span>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <h6 class="mb-0 text-danger fw-medium">$ {{ number_format($renewal->price, 2) }}</h6>
                                    <span class="fs-12 text-muted">Dans {{ now()->diffInDays($renewal->renewal_date) }}
                                        jours</span>
                                </div>
                            </li>
                        @empty
                            <li class="text-center py-4 text-muted">Aucun renouvellement à venir</li>
                        @endforelse
                    </ul>
                    <div class="text-center mt-4">
                        <a href="{{ route('renewals.index') }}" class="btn btn-outline-primary btn-sm w-100">Voir Tous
                            les Renouvellements</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>