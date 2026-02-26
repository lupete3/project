<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">{{ $isEditing ? 'Modifier le Devis' : 'Créer un Devis' }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('quotes.index') }}">Devis</a></li>
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
                        <select wire:model.live="client_id"
                            class="form-select @error('client_id') is-invalid @enderror">
                            <option value="">Sélectionner un Client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                        @error('client_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                        <label class="form-label fw-semibold">N° de Devis <span class="text-danger">*</span></label>
                        <input type="text" wire:model="quote_number"
                            class="form-control @error('quote_number') is-invalid @enderror">
                        @error('quote_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Dates & Status -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Date d'Émission <span class="text-danger">*</span></label>
                        <input type="date" wire:model="issue_date"
                            class="form-control @error('issue_date') is-invalid @enderror">
                        @error('issue_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Date d'Expiration</label>
                        <input type="date" wire:model="expiry_date"
                            class="form-control @error('expiry_date') is-invalid @enderror">
                        @error('expiry_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Statut <span class="text-danger">*</span></label>
                        <select wire:model="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="draft">Brouillon</option>
                            <option value="sent">Envoyé</option>
                            <option value="accepted">Accepté</option>
                            <option value="rejected">Rejeté</option>
                            <option value="cancelled">Annulé</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Taxe (%)</label>
                        <input type="number" wire:model.live="tax_percentage" class="form-control" placeholder="0">
                    </div>

                    <!-- Items Table -->
                    <div class="col-12">
                        <h5 class="mb-3">Articles du Devis</h5>
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
                                                    class="form-control form-control-sm @error('items.' . $index . '.description') is-invalid @enderror"
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
                                                {{ number_format($item['quantity'] * $item['unit_price'], 2) }} $
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
                        <div class="bg-light p-4 rounded-10 border">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary">Sous-total :</span>
                                <span
                                    class="fw-semibold text-body">{{ number_format(collect($items)->sum(fn($i) => $i['quantity'] * $i['unit_price']), 2) }}
                                    $</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                <span class="text-secondary">Taxe ({{ $tax_percentage }}%) :</span>
                                <span
                                    class="fw-semibold text-body">{{ number_format(collect($items)->sum(fn($i) => $i['quantity'] * $i['unit_price']) * ($tax_percentage / 100), 2) }}
                                    $</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Montant Total :</h5>
                                <h4 class="mb-0 text-primary">
                                    {{ number_format(collect($items)->sum(fn($i) => $i['quantity'] * $i['unit_price']) * (1 + $tax_percentage / 100), 2) }}
                                    $
                                </h4>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Notes / Informations complémentaires</label>
                        <textarea wire:model="notes" class="form-control" rows="3"
                            placeholder="Détails supplémentaires sur le coût ou les délais..."></textarea>
                    </div>

                    <!-- Actions -->
                    <div class="col-12 text-end mt-4">
                        <a href="{{ route('quotes.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary px-5">
                            {{ $isEditing ? 'Mettre à jour' : 'Enregistrer le Devis' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>