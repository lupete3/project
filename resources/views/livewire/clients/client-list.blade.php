<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Clients</h3>
        <a href="{{ route('clients.create') }}" class="btn btn-primary d-flex align-items-center">
            <span class="material-symbols-outlined me-1">add</span>
            Ajouter un Client
        </a>
    </div>

    <!-- Filters -->
    <div class="card bg-white p-20 rounded-10 border border-white mb-4">
        <div>
            <div class="search-box position-relative" style="max-width: 400px;">
                <input type="text" wire:model.live="search" class="form-control"
                    placeholder="Rechercher par nom, entreprise ou email...">
                <span
                    class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y ms-2">search</span>
            </div>
        </div>
    </div>

    <!-- Client List Table -->
    <div class="card bg-white p-20 rounded-10 border border-white">
        <div>
            <div class="default-table-area table-responsive mx-minus-1">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th class="fw-medium">Nom du Client</th>
                            <th class="fw-medium">Entreprise</th>
                            <th class="fw-medium">Email</th>
                            <th class="fw-medium">Téléphone</th>
                            <th class="fw-medium text-center">Projets</th>
                            <th class="fw-medium">Revenu Total</th>
                            <th class="fw-medium text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                            style="width: 40px; height: 40px;">
                                            <span class="material-symbols-outlined">person</span>
                                        </div>
                                        <h6 class="mb-0 fs-14">{{ $client->name }}</h6>
                                    </div>
                                </td>
                                <td class="text-secondary">{{ $client->company ?: 'N/A' }}</td>
                                <td class="text-body">{{ $client->email }}</td>
                                <td class="text-body">{{ $client->phone }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">{{ $client->projects_count }}</span>
                                </td>
                                <td class="fw-medium text-body">{{ number_format($client->total_revenue, 2) }} €</td>
                                <td>
                                    <div class="d-flex justify-content-end" style="gap: 12px;">
                                        <a href="{{ route('clients.show', $client) }}" class="bg-transparent p-0 border-0"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Voir Détails">
                                            <i class="material-symbols-outlined fs-18 text-primary">visibility</i>
                                        </a>
                                        <a href="{{ route('clients.edit', $client) }}" class="bg-transparent p-0 border-0"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier">
                                            <i class="material-symbols-outlined fs-18 text-secondary">edit</i>
                                        </a>
                                        <button class="bg-transparent p-0 border-0 hover-text-danger"
                                            wire:click="deleteClient({{ $client->id }})"
                                            wire:confirm="Êtes-vous sûr ? Cela supprimera tout l'historique des projets pour ce client."
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer text-danger">
                                            <i class="material-symbols-outlined fs-18 text-body">delete</i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Aucun client trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div
                class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap pt-15">
                <span class="fs-15">Affichage de {{ $clients->firstItem() ?? 0 }} à {{ $clients->lastItem() ?? 0 }} sur
                    {{ $clients->total() }} entrées</span>
                <div class="custom-pagination">
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>
</div>