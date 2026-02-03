<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">{{ $isEditing ? 'Modifier le Revenu' : 'Enregistrer un Revenu' }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('finances.index') }}">Finances</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $isEditing ? 'Modifier' : 'Créer' }}</li>
            </ol>
        </nav>
    </div>

    <div class="card border-0 rounded-10 border-white">
        <div class="card-body p-4">
            <form wire:submit.prevent="save">
                <div class="row g-4">
                    <!-- Project -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Projet (Optionnel)</label>
                        <select wire:model="project_id" class="form-select @error('project_id') is-invalid @enderror">
                            <option value="">Sélectionner un Projet</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                        @error('project_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Invoice -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Facture Liée (Optionnelle)</label>
                        <select wire:model="invoice_id" class="form-select @error('invoice_id') is-invalid @enderror">
                            <option value="">Sélectionner une Facture</option>
                            @foreach($invoices as $invoice)
                                <option value="{{ $invoice->id }}">#{{ $invoice->invoice_number }} -
                                    {{ $invoice->client->name }}</option>
                            @endforeach
                        </select>
                        @error('invoice_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                        <input type="text" wire:model="description"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="ex: Paiement acompte projet X">
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Amount -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Montant <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" wire:model="amount"
                                class="form-control @error('amount') is-invalid @enderror">
                        </div>
                        @error('amount') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <!-- Date -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                        <input type="date" wire:model="revenue_date"
                            class="form-control @error('revenue_date') is-invalid @enderror">
                        @error('revenue_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Notes -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Notes</label>
                        <textarea wire:model="notes" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Actions -->
                    <div class="col-12 text-end mt-4">
                        <a href="{{ route('finances.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary px-5">
                            {{ $isEditing ? 'Mettre à jour' : 'Enregistrer' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>