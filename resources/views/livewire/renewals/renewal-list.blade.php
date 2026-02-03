<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Renouvellements de Services</h3>
        <a href="{{ route('renewals.create') }}" class="btn btn-primary d-flex align-items-center">
            <span class="material-symbols-outlined me-1">add</span>
            Ajouter un Renouvellement
        </a>
    </div>

    <!-- Filters -->
    <div class="card border-0 rounded-10 mb-4 border-white">
        <div class="card-body p-4">
            <div class="search-box position-relative" style="max-width: 400px;">
                <input type="text" wire:model.live="search" class="form-control"
                    placeholder="Rechercher par service ou client...">
                <span
                    class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y ms-2">search</span>
            </div>
        </div>
    </div>

    <!-- Renewal List Table -->
    <div class="card border-0 rounded-10 border-white">
        <div class="card-body p-4">
            <div class="default-table-area table-responsive mx-minus-1">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th class="fw-medium">Service</th>
                            <th class="fw-medium">Client</th>
                            <th class="fw-medium">Type</th>
                            <th class="fw-medium">Renouvellement</th>
                            <th class="fw-medium">Coût</th>
                            <th class="fw-medium">Prix</th>
                            <th class="fw-medium">Marge</th>
                            <th class="fw-medium">Statut</th>
                            <th class="fw-medium text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($renewals as $renewal)
                            <tr>
                                <td>
                                    <div class="fw-semibold text-body fs-14">{{ $renewal->service_name }}</div>
                                </td>
                                <td class="text-body">{{ $renewal->client->name }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $renewal->type === 'hosting' ? 'info' : 'warning' }} bg-opacity-10 text-{{ $renewal->type === 'hosting' ? 'info' : 'warning' }} text-capitalize default-badge">
                                        {{ $renewal->type === 'hosting' ? 'Hébergement' : ($renewal->type === 'domain' ? 'Domaine' : $renewal->type) }}
                                    </span>
                                </td>
                                <td>
                                    <div
                                        class="@if($renewal->renewal_date->isPast()) text-danger @elseif($renewal->renewal_date->diffInDays(now()) < 30) text-warning @else text-body @endif fw-bold">
                                        {{ $renewal->renewal_date->translatedFormat('d M, Y') }}
                                    </div>
                                    <small class="text-muted">{{ $renewal->renewal_date->diffForHumans() }}</small>
                                </td>
                                <td class="text-secondary">$ {{ number_format($renewal->cost, 2) }}</td>
                                <td class="text-body">$ {{ number_format($renewal->price, 2) }}</td>
                                <td class="text-success fw-bold">$ {{ number_format($renewal->margin, 2) }}</td>
                                <td>
                                    @php
                                        $statusMap = [
                                            'active' => ['label' => 'Actif', 'class' => 'success'],
                                            'expired' => ['label' => 'Expiré', 'class' => 'danger'],
                                            'pending' => ['label' => 'En attente', 'class' => 'warning'],
                                        ];
                                        $status = $statusMap[$renewal->status] ?? ['label' => $renewal->status, 'class' => 'secondary'];
                                    @endphp
                                    <span
                                        class="badge bg-{{ $status['class'] }} bg-opacity-10 text-{{ $status['class'] }} text-capitalize px-3 default-badge">
                                        {{ $status['label'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end" style="gap: 12px;">
                                        <a href="{{ route('renewals.edit', $renewal) }}" class="bg-transparent p-0 border-0"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier">
                                            <i class="material-symbols-outlined fs-18 text-secondary">edit</i>
                                        </a>
                                        <button class="bg-transparent p-0 border-0 hover-text-danger"
                                            wire:click="deleteRenewal({{ $renewal->id }})"
                                            wire:confirm="Êtes-vous sûr de vouloir supprimer ce renouvellement ?"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer">
                                            <i class="material-symbols-outlined fs-18 text-body">delete</i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">Aucun renouvellement trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div
                class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap pt-15">
                <span class="fs-15">Affichage de {{ $renewals->firstItem() ?? 0 }} à {{ $renewals->lastItem() ?? 0 }}
                    sur {{ $renewals->total() }} entrées</span>
                <div class="custom-pagination">
                    {{ $renewals->links() }}
                </div>
            </div>
        </div>
    </div>
</div>