<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Devis</h3>
        <a href="{{ route('quotes.create') }}" class="btn btn-primary d-flex align-items-center">
            <span class="material-symbols-outlined me-1">add</span>
            Créer un Devis
        </a>
    </div>

    <!-- Filters -->
    <div class="card border-0 rounded-10 mb-4 border-white">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap gap-3">
                <div class="search-box position-relative" style="max-width: 400px; flex: 1;">
                    <input type="text" wire:model.live="search" class="form-control"
                        placeholder="Rechercher par n° de devis ou client...">
                    <span
                        class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y ms-2">search</span>
                </div>
                <div style="width: 200px;">
                    <select wire:model.live="status" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="draft">Brouillon</option>
                        <option value="sent">Envoyé</option>
                        <option value="accepted">Accepté</option>
                        <option value="rejected">Rejeté</option>
                        <option value="cancelled">Annulé</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Quote List Table -->
    <div class="card border-0 rounded-10 border-white">
        <div class="card-body p-4">
            <div class="default-table-area table-responsive mx-minus-1">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th class="fw-medium">N° de Devis</th>
                            <th class="fw-medium">Client</th>
                            <th class="fw-medium">Statut</th>
                            <th class="fw-medium text-nowrap">Émission</th>
                            <th class="fw-medium text-nowrap">Expiration</th>
                            <th class="fw-medium">Montant</th>
                            <th class="fw-medium text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quotes as $quote)
                            <tr>
                                <td class="fw-bold text-body fs-14">{{ $quote->quote_number }}</td>
                                <td class="text-body">{{ $quote->client->name }}</td>
                                <td>
                                    @php
                                        $statusMap = [
                                            'accepted' => ['label' => 'Accepté', 'class' => 'success'],
                                            'rejected' => ['label' => 'Rejeté', 'class' => 'danger'],
                                            'sent' => ['label' => 'Envoyé', 'class' => 'info'],
                                            'draft' => ['label' => 'Brouillon', 'class' => 'secondary'],
                                            'cancelled' => ['label' => 'Annulé', 'class' => 'warning'],
                                        ];
                                        $status = $statusMap[$quote->status] ?? ['label' => $quote->status, 'class' => 'secondary'];
                                    @endphp
                                    <span
                                        class="badge bg-{{ $status['class'] }} bg-opacity-10 text-{{ $status['class'] }} text-capitalize px-3 default-badge">
                                        {{ $status['label'] }}
                                    </span>
                                </td>
                                <td class="text-secondary text-nowrap">
                                    {{ $quote->issue_date->translatedFormat('d M, Y') }}
                                </td>
                                <td class="text-secondary text-nowrap">
                                    {{ $quote->expiry_date ? $quote->expiry_date->translatedFormat('d M, Y') : '-' }}
                                </td>
                                <td class="fw-bold text-body">$ {{ number_format($quote->amount, 2) }}</td>
                                <td>
                                    <div class="d-flex justify-content-end" style="gap: 12px;">
                                        <a href="{{ route('quotes.show', $quote) }}" class="bg-transparent p-0 border-0"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Voir">
                                            <i class="material-symbols-outlined fs-18 text-primary">visibility</i>
                                        </a>
                                        <a href="{{ route('quotes.edit', $quote) }}" class="bg-transparent p-0 border-0"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier">
                                            <i class="material-symbols-outlined fs-18 text-info">edit</i>
                                        </a>
                                        <a href="{{ route('quotes.download', $quote) }}" class="bg-transparent p-0 border-0"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Télécharger PDF">
                                            <i class="material-symbols-outlined fs-18 text-secondary">download</i>
                                        </a>
                                        <button class="bg-transparent p-0 border-0 text-danger"
                                            wire:click="deleteQuote({{ $quote->id }})"
                                            wire:confirm="Êtes-vous sûr de vouloir supprimer ce devis ?"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer">
                                            <i class="material-symbols-outlined fs-18">delete</i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Aucun devis trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div
                class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap pt-15">
                <span class="fs-15">Affichage de {{ $quotes->firstItem() ?? 0 }} à {{ $quotes->lastItem() ?? 0 }}
                    sur {{ $quotes->total() }} entrées</span>
                <div class="custom-pagination">
                    {{ $quotes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>