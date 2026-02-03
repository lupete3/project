<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Projets</h3>
        <a href="{{ route('projects.create') }}" class="btn btn-primary d-flex align-items-center">
            <span class="material-symbols-outlined me-1">add</span>
            Ajouter un Projet
        </a>
    </div>

    <!-- Filters -->
    <div class="card bg-white p-20 rounded-10 border border-white mb-4">
        <div>
            <div class="row g-3">
                <div class="col-lg-4">
                    <div class="search-box position-relative">
                        <input type="text" wire:model.live="search" class="form-control"
                            placeholder="Rechercher des projets ou des clients...">
                        <span
                            class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y ms-2">search</span>
                    </div>
                </div>
                <div class="col-lg-3">
                    <select wire:model.live="status" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="prospect">Prospect</option>
                        <option value="in_progress">En cours</option>
                        <option value="completed">Terminé</option>
                        <option value="cancelled">Annulé</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <select wire:model.live="priority" class="form-select">
                        <option value="">Toutes les priorités</option>
                        <option value="low">Faible</option>
                        <option value="medium">Moyenne</option>
                        <option value="high">Haute</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Project List Table -->
    <div class="card bg-white p-20 rounded-10 border border-white">
        <div>
            <div class="default-table-area table-responsive mx-minus-1">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th class="fw-medium">Projet</th>
                            <th class="fw-medium">Client</th>
                            <th class="fw-medium">Statut</th>
                            <th class="fw-medium">Priorité</th>
                            <th class="fw-medium">Budget</th>
                            <th class="fw-medium">Progression</th>
                            <th class="fw-medium text-nowrap">Échéance</th>
                            <th class="fw-medium text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                            style="width: 40px; height: 40px;">
                                            <span class="material-symbols-outlined">folder</span>
                                        </div>
                                        <h6 class="mb-0 fs-14">{{ $project->name }}</h6>
                                    </div>
                                </td>
                                <td class="text-secondary">{{ $project->client->name }}</td>
                                <td>
                                    @php
                                        $statusMap = [
                                            'prospect' => ['label' => 'Prospect', 'class' => 'info'],
                                            'in_progress' => ['label' => 'En Cours', 'class' => 'warning'],
                                            'completed' => ['label' => 'Terminé', 'class' => 'success'],
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
                                    @php
                                        $priorityMap = [
                                            'low' => ['label' => 'Faible', 'class' => 'info'],
                                            'medium' => ['label' => 'Moyenne', 'class' => 'warning'],
                                            'high' => ['label' => 'Haute', 'class' => 'danger'],
                                        ];
                                        $priority = $priorityMap[$project->priority] ?? ['label' => $project->priority, 'class' => 'secondary'];
                                    @endphp
                                    <span
                                        class="badge bg-{{ $priority['class'] }} bg-opacity-10 text-{{ $priority['class'] }} d-inline-block default-badge">
                                        {{ $priority['label'] }}
                                    </span>
                                </td>
                                <td class="text-body fw-medium">$ {{ number_format($project->budget, 2) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 5px; width: 80px;">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ $project->progress }}%"
                                                aria-valuenow="{{ $project->progress }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                        <span class="fs-12 text-muted">{{ $project->progress }}%</span>
                                    </div>
                                </td>
                                <td class="text-body text-nowrap">
                                    {{ $project->end_date ? $project->end_date->translatedFormat('d M, Y') : 'N/A' }}
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end" style="gap: 12px;">
                                        <a href="{{ route('projects.show', $project->id) }}"
                                            class="bg-transparent p-0 border-0" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Voir">
                                            <i class="material-symbols-outlined fs-18 text-primary">visibility</i>
                                        </a>
                                        <a href="{{ route('projects.edit', $project->id) }}"
                                            class="bg-transparent p-0 border-0" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Modifier">
                                            <i class="material-symbols-outlined fs-18 text-secondary">edit</i>
                                        </a>
                                        <button class="bg-transparent p-0 border-0 hover-text-danger"
                                            wire:click="deleteProject({{ $project->id }})"
                                            wire:confirm="Êtes-vous sûr de vouloir supprimer ce projet ?"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer">
                                            <i class="material-symbols-outlined fs-18 text-body">delete</i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Aucun projet trouvé correspondant à vos
                                    critères.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div
                class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap pt-15">
                <span class="fs-15">Affichage de {{ $projects->firstItem() ?? 0 }} à {{ $projects->lastItem() ?? 0 }}
                    sur {{ $projects->total() }} entrées</span>
                <div class="custom-pagination">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>
</div>