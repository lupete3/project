<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">{{ $isEditing ? 'Modifier le Client' : 'Ajouter un Nouveau Client' }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clients</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $isEditing ? 'Modifier' : 'Créer' }}</li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white p-20 rounded-10 border border-white">
        <div>
            <form wire:submit.prevent="save">
                <div class="row g-4">
                    <!-- Client Name -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nom du Client <span class="text-danger">*</span></label>
                        <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Nom du client">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Company -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nom de l'Entreprise</label>
                        <input type="text" wire:model="company"
                            class="form-control @error('company') is-invalid @enderror" placeholder="Entreprise">
                        @error('company') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Contact Person -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Personne de Contact</label>
                        <input type="text" wire:model="contact_person"
                            class="form-control @error('contact_person') is-invalid @enderror"
                            placeholder="Jean Dupont">
                        @error('contact_person') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="client@exemple.com">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Phone -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Téléphone</label>
                        <input type="text" wire:model="phone" class="form-control @error('phone') is-invalid @enderror"
                            placeholder="+33 1 23 45 67 89">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Address -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Adresse</label>
                        <textarea wire:model="address" class="form-control" rows="2"
                            placeholder="Adresse complète..."></textarea>
                    </div>

                    <!-- Notes -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Notes</label>
                        <textarea wire:model="notes" class="form-control" rows="3"
                            placeholder="Notes facultatives..."></textarea>
                    </div>

                    <!-- Actions -->
                    <div class="col-12 text-end mt-4">
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary px-4">
                            {{ $isEditing ? 'Mettre à jour' : 'Créer le Client' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>