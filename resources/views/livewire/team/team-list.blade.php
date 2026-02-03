<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Membres de l'Équipe</h3>
        <a href="{{ route('team.create') }}" class="btn btn-primary d-flex align-items-center">
            <span class="material-symbols-outlined me-1">group_add</span>
            Ajouter un Membre
        </a>
    </div>

    <!-- Filters -->
    <div class="card border-0 rounded-10 mb-4 border-white">
        <div class="card-body p-4">
            <div class="search-box position-relative" style="max-width: 400px;">
                <input type="text" wire:model.live="search" class="form-control"
                    placeholder="Rechercher par nom ou email...">
                <span
                    class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y ms-2">search</span>
            </div>
        </div>
    </div>

    <!-- Team List Table -->
    <div class="card border-0 rounded-10 border-white">
        <div class="card-body p-4">
            <div class="default-table-area table-responsive mx-minus-1">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th class="fw-medium">Membre</th>
                            <th class="fw-medium">Email</th>
                            <th class="fw-medium">Projets</th>
                            <th class="fw-medium">Rôle</th>
                            <th class="fw-medium">Statut</th>
                            <th class="fw-medium text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                            style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                        </div>
                                        <div class="fw-semibold text-body fs-14">{{ $member->name }}</div>
                                    </div>
                                </td>
                                <td class="text-body">{{ $member->email }}</td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">
                                        {{ $member->assignedProjects ? $member->assignedProjects->count() : 0 }} Projets
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="text-secondary text-capitalize fs-13">{{ $member->role ?: 'Membre' }}</span>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-success bg-opacity-10 text-success text-capitalize px-3 default-badge">Actif</span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end" style="gap: 12px;">
                                        <a href="{{ route('team.edit', $member) }}" class="bg-transparent p-0 border-0"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier">
                                            <i class="material-symbols-outlined fs-18 text-secondary">edit</i>
                                        </a>
                                        <button class="bg-transparent p-0 border-0 hover-text-danger"
                                            wire:click="deleteMember({{ $member->id }})"
                                            wire:confirm="Êtes-vous sûr de vouloir supprimer ce membre ?"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer">
                                            <i class="material-symbols-outlined fs-18 text-body">delete</i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Aucun membre d'équipe trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div
                class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap pt-15">
                <span class="fs-15">Affichage de {{ $members->firstItem() ?? 0 }} à {{ $members->lastItem() ?? 0 }} sur
                    {{ $members->total() }} entrées</span>
                <div class="custom-pagination">
                    {{ $members->links() }}
                </div>
            </div>
        </div>
    </div>
</div>