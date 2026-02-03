<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">{{ $isEditing ? 'Modifier le Projet' : 'Ajouter un Nouveau Projet' }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projets</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $isEditing ? 'Modifier' : 'Créer' }}</li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white p-20 rounded-10 border border-white">
        <div>
            <form wire:submit.prevent="save">
                <div class="row g-4">
                    <!-- Client -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Client <span class="text-danger">*</span></label>
                        <select wire:model="client_id" class="form-select @error('client_id') is-invalid @enderror">
                            <option value="">Sélectionner un client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                        @error('client_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Project Name -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nom du Projet <span class="text-danger">*</span></label>
                        <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Nom du projet">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea wire:model="description" class="form-control" rows="3"
                            placeholder="Description du projet..."></textarea>
                    </div>

                    <!-- Status -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Statut <span class="text-danger">*</span></label>
                        <select wire:model="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="prospect">Prospect</option>
                            <option value="in_progress">En cours</option>
                            <option value="completed">Terminé</option>
                            <option value="cancelled">Annulé</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Priority -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Priorité <span class="text-danger">*</span></label>
                        <select wire:model="priority" class="form-select @error('priority') is-invalid @enderror">
                            <option value="low">Faible</option>
                            <option value="medium">Moyenne</option>
                            <option value="high">Haute</option>
                        </select>
                        @error('priority') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Budget -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Budget (€)</label>
                        <input type="number" step="0.01" wire:model="budget"
                            class="form-control @error('budget') is-invalid @enderror" placeholder="0.00">
                        @error('budget') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Start Date -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Date de Début</label>
                        <input type="date" wire:model="start_date"
                            class="form-control @error('start_date') is-invalid @enderror">
                        @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- End Date -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Date de Fin Estimée</label>
                        <input type="date" wire:model="end_date"
                            class="form-control @error('end_date') is-invalid @enderror">
                        @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Notes -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Notes Internes</label>
                        <textarea wire:model="notes" class="form-control" rows="3"
                            placeholder="Notes facultatives..."></textarea>
                    </div>

                    <!-- Actions -->
                    <div class="col-12 text-end mt-4">
                        <a href="{{ route('projects.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary px-4">
                            {{ $isEditing ? 'Mettre à jour' : 'Créer le Projet' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>