<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Factures</h3>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary d-flex align-items-center">
            <span class="material-symbols-outlined me-1">add</span>
            Créer une Facture
        </a>
    </div>

    <!-- Filters -->
    <div class="card border-0 rounded-10 mb-4 border-white">
        <div class="card-body p-4">
            <div class="search-box position-relative" style="max-width: 400px;">
                <input type="text" wire:model.live="search" class="form-control"
                    placeholder="Rechercher par n° de facture ou client...">
                <span
                    class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y ms-2">search</span>
            </div>
        </div>
    </div>

    <!-- Invoice List Table -->
    <div class="card border-0 rounded-10 border-white">
        <div class="card-body p-4">
            <div class="default-table-area table-responsive mx-minus-1">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th class="fw-medium">N° de Facture</th>
                            <th class="fw-medium">Client</th>
                            <th class="fw-medium">Statut</th>
                            <th class="fw-medium text-nowrap">Émission</th>
                            <th class="fw-medium text-nowrap">Échéance</th>
                            <th class="fw-medium">Montant</th>
                            <th class="fw-medium text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr>
                                <td class="fw-bold text-body fs-14">{{ $invoice->invoice_number }}</td>
                                <td class="text-body">{{ $invoice->client->name }}</td>
                                <td>
                                    @php
                                        $statusMap = [
                                            'paid' => ['label' => 'Payée', 'class' => 'success'],
                                            'unpaid' => ['label' => 'Impayée', 'class' => 'danger'],
                                            'partial' => ['label' => 'Partielle', 'class' => 'warning'],
                                            'sent' => ['label' => 'Envoyée', 'class' => 'info'],
                                            'draft' => ['label' => 'Brouillon', 'class' => 'secondary'],
                                            'overdue' => ['label' => 'En retard', 'class' => 'danger'],
                                        ];
                                        $status = $statusMap[$invoice->status] ?? ['label' => $invoice->status, 'class' => 'secondary'];
                                    @endphp
                                    <span
                                        class="badge bg-{{ $status['class'] }} bg-opacity-10 text-{{ $status['class'] }} text-capitalize px-3 default-badge">
                                        {{ $status['label'] }}
                                    </span>
                                </td>
                                <td class="text-secondary text-nowrap">
                                    {{ $invoice->issue_date->translatedFormat('d M, Y') }}
                                </td>
                                <td class="text-secondary text-nowrap">{{ $invoice->due_date->translatedFormat('d M, Y') }}
                                </td>
                                <td class="fw-bold text-body">$ {{ number_format($invoice->amount, 2) }}</td>
                                <td>
                                    <div class="d-flex justify-content-end" style="gap: 12px;">
                                        <a href="{{ route('invoices.show', $invoice) }}" class="bg-transparent p-0 border-0"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Voir">
                                            <i class="material-symbols-outlined fs-18 text-primary">visibility</i>
                                        </a>
                                        <a href="{{ route('invoices.edit', $invoice) }}" class="bg-transparent p-0 border-0"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier">
                                            <i class="material-symbols-outlined fs-18 text-info">edit</i>
                                        </a>
                                        <a href="{{ route('invoices.download', $invoice) }}"
                                            class="bg-transparent p-0 border-0" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Télécharger PDF">
                                            <i class="material-symbols-outlined fs-18 text-secondary">download</i>
                                        </a>
                                        @if($invoice->status !== 'paid')
                                            <button class="bg-transparent p-0 border-0 text-success"
                                                wire:click="markAsPaid({{ $invoice->id }})" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Marquer comme Payée">
                                                <i class="material-symbols-outlined fs-18">check_circle</i>
                                            </button>
                                        @endif
                                        <button class="bg-transparent p-0 border-0 text-danger"
                                            wire:click="deleteInvoice({{ $invoice->id }})"
                                            wire:confirm="Êtes-vous sûr de vouloir supprimer cette facture ?"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer">
                                            <i class="material-symbols-outlined fs-18">delete</i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Aucune facture trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div
                class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap pt-15">
                <span class="fs-15">Affichage de {{ $invoices->firstItem() ?? 0 }} à {{ $invoices->lastItem() ?? 0 }}
                    sur {{ $invoices->total() }} entrées</span>
                <div class="custom-pagination">
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </div>
</div>