<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">{{ $client->name }}</h3>
            @if($client->company)
                <p class="text-muted mb-0"><span class="fw-semibold">{{ $client->company }}</span></p>
            @endif
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('clients.edit', $client) }}" class="btn btn-outline-primary d-flex align-items-center">
                <span class="material-symbols-outlined fs-18 me-1">edit</span> Modifier
            </a>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary d-flex align-items-center">
                <span class="material-symbols-outlined fs-18 me-1">arrow_back</span> Retour
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Client Info -->
        <div class="col-lg-4">
            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                <div>
                    <h5 class="mb-4">Informations de Contact</h5>
                    <div class="d-flex align-items-center mb-3">
                        <span class="material-symbols-outlined text-primary me-2">person</span>
                        <div>
                            <span class="d-block text-muted fs-12">Personne de Contact</span>
                            <span class="fw-semibold text-body">{{ $client->contact_person ?: $client->name }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <span class="material-symbols-outlined text-primary me-2">mail</span>
                        <div>
                            <span class="d-block text-muted fs-12">Adresse Email</span>
                            <span class="fw-semibold text-body">{{ $client->email ?: 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <span class="material-symbols-outlined text-primary me-2">call</span>
                        <div>
                            <span class="d-block text-muted fs-12">Téléphone</span>
                            <span class="fw-semibold text-body">{{ $client->phone ?: 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-0">
                        <span class="material-symbols-outlined text-primary me-2">location_on</span>
                        <div>
                            <span class="d-block text-muted fs-12">Adresse</span>
                            <span class="fw-semibold text-body">{{ $client->address ?: 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financials Summary -->
            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                <div>
                    <h5 class="mb-3">Valeur du Client</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total des Projets :</span>
                        <span class="fw-bold text-body">{{ $client->projects->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <span>Projets Actifs :</span>
                        <span
                            class="text-primary fw-bold">{{ $client->projects->where('status', 'in_progress')->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Revenu Total (à vie) :</span>
                        <h5 class="mb-0 text-success">$ {{ number_format($client->total_revenue, 2) }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Tabs -->
        <div class="col-lg-8">
            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                <div class="card-header bg-transparent border-0 p-0 pb-4">
                    <ul class="nav nav-tabs card-header-tabs" id="clientTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-semibold" id="projects-tab" data-bs-toggle="tab"
                                data-bs-target="#projects" type="button" role="tab">Projets</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold" id="invoices-tab" data-bs-toggle="tab"
                                data-bs-target="#invoices" type="button" role="tab">Factures</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold" id="renewals-tab" data-bs-toggle="tab"
                                data-bs-target="#renewals" type="button" role="tab">Renouvellements</button>
                        </li>
                    </ul>
                </div>
                <div class="pt-4">
                    <div class="tab-content" id="clientTabContent">
                        <!-- Projects Panel -->
                        <div class="tab-pane fade show active" id="projects" role="tabpanel">
                            <div class="default-table-area table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th class="fw-medium">Projet</th>
                                            <th class="fw-medium">Statut</th>
                                            <th class="fw-medium">Budget</th>
                                            <th class="fw-medium text-nowrap">Date de Fin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($client->projects as $project)
                                            <tr>
                                                <td class="text-body fw-medium">{{ $project->name }}</td>
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
                                                        class="badge bg-{{ $status['class'] }} bg-opacity-10 text-{{ $status['class'] }} default-badge">
                                                        {{ $status['label'] }}
                                                    </span>
                                                </td>
                                                <td class="text-body">$ {{ number_format($project->budget, 2) }}</td>
                                                <td class="text-body text-nowrap">
                                                    {{ $project->end_date ? $project->end_date->translatedFormat('d M, Y') : 'N/A' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4 text-muted">Aucun projet trouvé pour
                                                    ce client.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Invoices Panel -->
                        <div class="tab-pane fade" id="invoices" role="tabpanel">
                            <div class="default-table-area table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th class="fw-medium">N° de Facture</th>
                                            <th class="fw-medium">Statut</th>
                                            <th class="fw-medium">Montant</th>
                                            <th class="fw-medium text-nowrap">Échéance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($client->invoices as $invoice)
                                            <tr>
                                                <td class="text-body fw-medium">{{ $invoice->invoice_number }}</td>
                                                <td>
                                                    @php
                                                        $invStatusMap = [
                                                            'paid' => ['label' => 'Payée', 'class' => 'success'],
                                                            'unpaid' => ['label' => 'Impayée', 'class' => 'danger'],
                                                            'partial' => ['label' => 'Partielle', 'class' => 'warning'],
                                                            'sent' => ['label' => 'Envoyée', 'class' => 'info'],
                                                            'draft' => ['label' => 'Brouillon', 'class' => 'secondary'],
                                                        ];
                                                        $iStatus = $invStatusMap[$invoice->status] ?? ['label' => $invoice->status, 'class' => 'secondary'];
                                                    @endphp
                                                    <span
                                                        class="badge bg-{{ $iStatus['class'] }} bg-opacity-10 text-{{ $iStatus['class'] }} default-badge">
                                                        {{ $iStatus['label'] }}
                                                    </span>
                                                </td>
                                                <td class="text-body">$ {{ number_format($invoice->amount, 2) }}</td>
                                                <td class="text-body text-nowrap">
                                                    {{ $invoice->due_date->translatedFormat('d M, Y') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4 text-muted">Aucune facture trouvée.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Renewals Panel -->
                        <div class="tab-pane fade" id="renewals" role="tabpanel">
                            <div class="default-table-area table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th class="fw-medium">Service</th>
                                            <th class="fw-medium">Statut</th>
                                            <th class="fw-medium">Prix</th>
                                            <th class="fw-medium text-nowrap">Renouvellement</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($client->renewals as $renewal)
                                            <tr>
                                                <td class="text-body fw-medium">
                                                    {{ $renewal->service_name }}
                                                    <span
                                                        class="fs-12 text-muted">({{ $renewal->type === 'hosting' ? 'Hébergement' : ($renewal->type === 'domain' ? 'Domaine' : $renewal->type) }})</span>
                                                </td>
                                                <td>
                                                    @php
                                                        $renStatusMap = [
                                                            'active' => ['label' => 'Actif', 'class' => 'success'],
                                                            'expired' => ['label' => 'Expiré', 'class' => 'danger'],
                                                            'pending' => ['label' => 'En Attente', 'class' => 'warning'],
                                                        ];
                                                        $rStatus = $renStatusMap[$renewal->status] ?? ['label' => $renewal->status, 'class' => 'secondary'];
                                                    @endphp
                                                    <span
                                                        class="badge bg-{{ $rStatus['class'] }} bg-opacity-10 text-{{ $rStatus['class'] }} default-badge">
                                                        {{ $rStatus['label'] }}
                                                    </span>
                                                </td>
                                                <td class="text-body">$ {{ number_format($renewal->price, 2) }}</td>
                                                <td class="text-body text-nowrap">
                                                    {{ $renewal->renewal_date->translatedFormat('d M, Y') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4 text-muted">Aucun renouvellement de
                                                    service trouvé.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>