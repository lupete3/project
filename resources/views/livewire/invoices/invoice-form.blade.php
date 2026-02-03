<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">{{ $isEditing ? 'Modifier la Facture' : 'Créer une Facture' }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Factures</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $isEditing ? 'Modifier' : 'Créer' }}</li>
            </ol>
        </nav>
    </div>

    <div class="card border-0 rounded-10 border-white">
        <div class="card-body p-4">
            <form wire:submit.prevent="save">
                <div class="row g-4">
                    <!-- Client & Project -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Client <span class="text-danger">*</span></label>
                        <select wire:model="client_id" class="form-select @error('client_id') is-invalid @enderror">
                            <option value="">Sélectionner un Client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Projet (Optionnel)</label>
                        <select wire:model="project_id" class="form-select">
                            <option value="">Général / Aucun projet</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">N° de Facture <span class="text-danger">*</span></label>
                        <input type="text" wire:model="invoice_number"
                            class="form-control @error('invoice_number') is-invalid @enderror">
                    </div>

                    <!-- Dates -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Date d'Émission <span class="text-danger">*</span></label>
                        <input type="date" wire:model="issue_date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Date d'Échéance <span class="text-danger">*</span></label>
                        <input type="date" wire:model="due_date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Taxe (%)</label>
                        <input type="number" wire:model="tax_percentage" class="form-control" placeholder="0">
                    </div>

                    <!-- Items Table -->
                    <div class="col-12">
                        <h5 class="mb-3">Articles de la Facture</h5>
                        <div class="default-table-area table-responsive mx-minus-1">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th class="fw-medium">Description</th>
                                        <th class="fw-medium" style="width: 120px;">Qté</th>
                                        <th class="fw-medium" style="width: 150px;">Prix Unitaire</th>
                                        <th class="fw-medium text-end" style="width: 150px;">Total</th>
                                        <th style="width: 50px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $index => $item)
                                        <tr>
                                            <td>
                                                <input type="text" wire:model="items.{{ $index }}.description"
                                                    class="form-control form-control-sm"
                                                    placeholder="Description de l'article">
                                            </td>
                                            <td>
                                                <input type="number" step="0.1"
                                                    wire:model.live="items.{{ $index }}.quantity"
                                                    class="form-control form-control-sm text-center">
                                            </td>
                                            <td>
                                                <input type="number" step="0.01"
                                                    wire:model.live="items.{{ $index }}.unit_price"
                                                    class="form-control form-control-sm text-end">
                                            </td>
                                            <td class="text-end fw-semibold text-body">
                                                {{ number_format($item['quantity'] * $item['unit_price'], 2) }} €
                                            </td>
                                            <td>
                                                <button type="button" wire:click="removeItem({{ $index }})"
                                                    class="btn btn-outline-danger btn-sm border-0">
                                                    <span class="material-symbols-outlined fs-18">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <button type="button" wire:click="addItem"
                                                class="btn btn-outline-primary btn-sm d-flex align-items-center">
                                                <span class="material-symbols-outlined fs-18 me-1">add</span> Ajouter
                                                une Ligne
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="col-md-6 offset-md-6">
                        <div class="bg-body-bg p-4 rounded-10 border border-white">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary">Sous-total :</span>
                                <span
                                    class="fw-semibold text-body">{{ number_format(collect($items)->sum(fn($i) => $i['quantity'] * $i['unit_price']), 2) }}
                                    €</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                <span class="text-secondary">Taxe ({{ $tax_percentage }}%) :</span>
                                <span
                                    class="fw-semibold text-body">{{ number_format(collect($items)->sum(fn($i) => $i['quantity'] * $i['unit_price']) * ($tax_percentage / 100), 2) }}
                                    €</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Montant Total :</h5>
                                <h4 class="mb-0 text-primary">
                                    {{ number_format(collect($items)->sum(fn($i) => $i['quantity'] * $i['unit_price']) * (1 + $tax_percentage / 100), 2) }}
                                    €
                                </h4>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Notes / Instructions de Paiement</label>
                        <textarea wire:model="notes" class="form-control" rows="3"
                            placeholder="Merci pour votre confiance !"></textarea>
                    </div>

                    <!-- Actions -->
                    <div class="col-12 text-end mt-4">
                        <a href="{{ route('invoices.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary px-5">
                            {{ $isEditing ? 'Mettre à jour' : 'Générer la Facture' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>