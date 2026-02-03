<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">{{ $isEditing ? 'Modifier le Membre' : 'Ajouter un Membre de l\'Équipe' }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('team.index') }}">Équipe</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $isEditing ? 'Modifier' : 'Ajouter' }}</li>
            </ol>
        </nav>
    </div>

    <div class="card border-0 rounded-10 border-white">
        <div class="card-body p-4">
            <form wire:submit.prevent="save">
                <div class="row g-4">
                    <!-- Name -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nom complet <span class="text-danger">*</span></label>
                        <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Jean Dupont">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Adresse Email <span class="text-danger">*</span></label>
                        <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="jean@exemple.com">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Password -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Mot de passe @if(!$isEditing) <span
                        class="text-danger">*</span> @endif</label>
                        <input type="password" wire:model="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="{{ $isEditing ? 'Laisser vide pour conserver l\'actuel' : 'Entrer le mot de passe' }}">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Role -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Rôle <span class="text-danger">*</span></label>
                        <select wire:model="role" class="form-select @error('role') is-invalid @enderror">
                            <option value="member">Membre</option>
                            <option value="developer">Développeur</option>
                            <option value="designer">Designer</option>
                            <option value="admin">Admin</option>
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Actions -->
                    <div class="col-12 text-end mt-4">
                        <a href="{{ route('team.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary px-5">
                            {{ $isEditing ? 'Mettre à jour' : 'Ajouter le Membre' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>