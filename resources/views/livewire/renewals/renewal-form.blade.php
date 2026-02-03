<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">{{ $isEditing ? 'Modifier le Renouvellement' : 'Enregistrer un Renouvellement de Service' }}
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('renewals.index') }}">Renouvellements</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $isEditing ? 'Modifier' : 'Créer' }}</li>
            </ol>
        </nav>
    </div>

    <div class="card border-0 rounded-10 border-white">
        <div class="card-body p-4">
            <form wire:submit.prevent="save">
                <div class="row g-4">
                    <!-- Client -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Client <span class="text-danger">*</span></label>
                        <select wire:model="client_id" class="form-select @error('client_id') is-invalid @enderror">
                            <option value="">Sélectionner un Client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                        @error('client_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

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

                    <!-- Service Name -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nom du Service <span class="text-danger">*</span></label>
                        <input type="text" wire:model="service_name"
                            class="form-control @error('service_name') is-invalid @enderror"
                            placeholder="ex: Hébergement example.com">
                        @error('service_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Type -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Type de Service <span class="text-danger">*</span></label>
                        <select wire:model="type" class="form-select @error('type') is-invalid @enderror">
                            <option value="hosting">Hébergement</option>
                            <option value="domain">Nom de Domaine</option>
                            <option value="other">Autre Service</option>
                        </select>
                    </div>

                    <!-- Dates -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Date de Début <span class="text-danger">*</span></label>
                        <input type="date" wire:model="start_date"
                            class="form-control @error('start_date') is-invalid @enderror">
                        @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Date de Renouvellement <span
                                class="text-danger">*</span></label>
                        <input type="date" wire:model="renewal_date"
                            class="form-control @error('renewal_date') is-invalid @enderror">
                        @error('renewal_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Statut <span class="text-danger">*</span></label>
                        <select wire:model="status" class="form-select">
                            <option value="active">Actif</option>
                            <option value="cancelled">Annulé</option>
                        </select>
                    </div>

                    <!-- Prices -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prix de Revient <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.01" wire:model.live="cost"
                                class="form-control @error('cost') is-invalid @enderror">
                            <span class="input-group-text">$</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prix de Vente <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.01" wire:model.live="price"
                                class="form-control @error('price') is-invalid @enderror">
                            <span class="input-group-text">$</span>
                        </div>
                    </div>

                    <!-- Margin Preview -->
                    <div class="col-12">
                        <div
                            class="bg-body-bg p-3 rounded d-flex justify-content-between align-items-center border border-white">
                            <span class="fw-semibold">Marge Estimée :</span>
                            <h5 class="mb-0 text-success">$ {{ number_format((float) $price - (float) $cost, 2) }}</h5>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Notes</label>
                        <textarea wire:model="notes" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Actions -->
                    <div class="col-12 text-end mt-4">
                        <a href="{{ route('renewals.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary px-5">
                            {{ $isEditing ? 'Mettre à jour' : 'Enregistrer' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>