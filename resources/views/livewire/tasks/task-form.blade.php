<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">{{ $isEditing ? 'Modifier la Tâche' : 'Créer une Tâche' }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">Tâches</a></li>
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
                        <label class="form-label fw-semibold">Projet <span class="text-danger">*</span></label>
                        <select wire:model="project_id" class="form-select @error('project_id') is-invalid @enderror">
                            <option value="">Sélectionner un projet</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                        @error('project_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Title -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Titre de la Tâche <span class="text-danger">*</span></label>
                        <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror"
                            placeholder="Titre de la tâche">
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea wire:model="description" class="form-control" rows="3"
                            placeholder="Détails de la tâche..."></textarea>
                    </div>

                    <!-- Status -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Statut <span class="text-danger">*</span></label>
                        <select wire:model="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="todo">À Faire</option>
                            <option value="in_progress">En Cours</option>
                            <option value="review">En Révision</option>
                            <option value="completed">Terminé</option>
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

                    <!-- Assigned To -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Assigné à</label>
                        <select wire:model="assigned_to" class="form-select">
                            <option value="">Non assigné</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Due Date -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Date d'Échéance</label>
                        <input type="date" wire:model="due_date" class="form-control">
                    </div>

                    <!-- Est Hours -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Heures Estimées</label>
                        <input type="number" step="0.5" wire:model="estimated_hours" class="form-control"
                            placeholder="0.0">
                    </div>

                    <!-- Actions -->
                    <div class="col-12 text-end mt-4">
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary px-4">
                            {{ $isEditing ? 'Mettre à jour' : 'Créer la Tâche' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>