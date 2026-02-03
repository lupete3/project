<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Tableau des Tâches</h3>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary d-flex align-items-center">
            <span class="material-symbols-outlined me-1">add</span>
            Ajouter une Tâche
        </a>
    </div>

    <!-- Filters -->
    <div class="card border-0 rounded-10 mb-4 border-white">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-lg-4">
                    <div class="search-box position-relative">
                        <input type="text" wire:model.live="search" class="form-control"
                            placeholder="Rechercher des tâches...">
                        <span
                            class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y ms-2">search</span>
                    </div>
                </div>
                <div class="col-lg-3">
                    <select wire:model.live="projectId" class="form-select">
                        <option value="">Tous les Projets</option>
                        @foreach(App\Models\Project::all() as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="row g-4 overflow-auto flex-nowrap pb-4">
        @php
            $statuses = [
                'todo' => 'À Faire',
                'in_progress' => 'En Cours',
                'review' => 'En Révision',
                'completed' => 'Terminé'
            ];
            $colors = ['todo' => 'secondary', 'in_progress' => 'primary', 'review' => 'warning', 'completed' => 'success'];
        @endphp

        @foreach($statuses as $key => $label)
            <div class="col-xxl-3 col-lg-4 col-md-6" style="min-width: 300px;">
                <div class="kanban-column bg-body-bg rounded-10 p-3 border border-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 d-flex align-items-center">
                            <span class="badge bg-{{ $colors[$key] }} me-2">&nbsp;</span>
                            {{ $label }}
                        </h5>
                        <span
                            class="badge bg-{{ $colors[$key] }} bg-opacity-10 text-{{ $colors[$key] }} rounded-pill">{{ $tasks->where('status', $key)->count() }}</span>
                    </div>

                    <div class="task-list" style="min-height: 200px;">
                        @foreach($tasks->where('status', $key) as $task)
                            <div class="task-card card border-0 rounded-10 border-white shadow-none mb-3">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        @php
                                            $priorityMap = [
                                                'low' => ['label' => 'Faible', 'class' => 'info'],
                                                'medium' => ['label' => 'Moyenne', 'class' => 'warning'],
                                                'high' => ['label' => 'Haute', 'class' => 'danger'],
                                            ];
                                            $priority = $priorityMap[$task->priority] ?? ['label' => $task->priority, 'class' => 'secondary'];
                                        @endphp
                                        <span
                                            class="badge bg-{{ $priority['class'] }} bg-opacity-10 text-{{ $priority['class'] }} fs-10 text-uppercase default-badge">
                                            {{ $priority['label'] }}
                                        </span>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary border-0 p-0 bg-transparent" type="button"
                                                data-bs-toggle="dropdown">
                                                <span class="material-symbols-outlined fs-16 text-muted">more_horiz</span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item fs-12 d-flex align-items-center"
                                                        href="{{ route('tasks.edit', $task) }}"><i
                                                            class="material-symbols-outlined fs-14 me-1">edit</i> Modifier</a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><button class="dropdown-item fs-12 text-danger d-flex align-items-center"
                                                        wire:click="deleteTask({{ $task->id }})"
                                                        wire:confirm="Supprimer cette tâche ?"><i
                                                            class="material-symbols-outlined fs-14 me-1">delete</i>
                                                        Supprimer</button></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <h6 class="mb-1 fw-semibold fs-14">{{ $task->title }}</h6>
                                    <p class="text-muted fs-12 mb-3">{{ Str::limit($task->description, 60) }}</p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-primary fs-11 fw-semibold">{{ $task->project->name }}</span>
                                        <div class="d-flex align-items-center text-muted fs-11">
                                            <span class="material-symbols-outlined fs-14 me-1">calendar_today</span>
                                            {{ $task->due_date ? $task->due_date->translatedFormat('d M') : 'Sans date' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>