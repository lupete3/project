<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">{{ $project->name }}</h3>
            <p class="text-muted mb-0">Client : <span
                    class="fw-semibold text-primary">{{ $project->client->name }}</span></p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('projects.edit', $project) }}" class="btn btn-outline-primary d-flex align-items-center">
                <span class="material-symbols-outlined fs-18 me-1">edit</span> Modifier
            </a>
            <a href="{{ route('projects.index') }}" class="btn btn-secondary d-flex align-items-center">
                <span class="material-symbols-outlined fs-18 me-1">arrow_back</span> Retour
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Stats -->
        <div class="col-lg-3">
            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                <div>
                    <div class="mb-4">
                        <span class="d-block text-muted mb-1">Statut</span>
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
                            class="badge bg-{{ $status['class'] }} bg-opacity-10 text-{{ $status['class'] }} px-3 py-2 default-badge">
                            {{ $status['label'] }}
                        </span>
                    </div>
                    <div class="mb-4">
                        <span class="d-block text-muted mb-1">Priorité</span>
                        @php
                            $priorityMap = [
                                'low' => ['label' => 'Faible', 'class' => 'info'],
                                'medium' => ['label' => 'Moyenne', 'class' => 'warning'],
                                'high' => ['label' => 'Haute', 'class' => 'danger'],
                            ];
                            $priority = $priorityMap[$project->priority] ?? ['label' => $project->priority, 'class' => 'secondary'];
                        @endphp
                        <span
                            class="badge bg-{{ $priority['class'] }} bg-opacity-10 text-{{ $priority['class'] }} px-3 py-2 default-badge">
                            {{ $priority['label'] }}
                        </span>
                    </div>
                    <div class="mb-4">
                        <span class="d-block text-muted mb-1">Budget</span>
                        <h4 class="mb-0 text-primary">$ {{ number_format($project->budget, 2) }}</h4>
                    </div>
                    <div class="mb-0">
                        <span class="d-block text-muted mb-1">Échéance</span>
                        <h6 class="mb-0">
                            {{ $project->end_date ? $project->end_date->translatedFormat('d M, Y') : 'N/A' }}
                        </h6>
                    </div>
                </div>
            </div>

            <!-- Financials Summary -->
            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                <div>
                    <h5 class="mb-3">Rentabilité</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Revenu :</span>
                        <span class="text-success fw-bold">$
                            {{ number_format($project->revenues->sum('amount'), 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <span>Dépenses :</span>
                        <span class="text-danger fw-bold">$
                            {{ number_format($project->expenses->sum('amount'), 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Bénéfice Net :</span>
                        <h5 class="mb-0 text-{{ $project->profit >= 0 ? 'success' : 'danger' }}">
                            $ {{ number_format($project->profit, 2) }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Tabs -->
        <div class="col-lg-9">
            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                <div class="card-header bg-transparent border-0 p-0 pb-4">
                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-semibold" id="overview-tab" data-bs-toggle="tab"
                                data-bs-target="#overview" type="button" role="tab">Aperçu</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold" id="tasks-tab" data-bs-toggle="tab"
                                data-bs-target="#tasks" type="button" role="tab">Tâches
                                ({{ $project->tasks->count() }})</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold" id="team-tab" data-bs-toggle="tab"
                                data-bs-target="#team" type="button" role="tab">Équipe</button>
                        </li>
                    </ul>
                </div>
                <div class="pt-4">
                    <div class="tab-content" id="myTabContent">
                        <!-- Overview Panel -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <h5 class="mb-3">Description</h5>
                            <p class="text-muted mb-4">{{ $project->description ?: 'Aucune description fournie.' }}</p>

                            <h5 class="mb-3">Progression ({{ $project->progress }}%)</h5>
                            <div class="progress mb-4" style="height: 10px;">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{ $project->progress }}%" aria-valuenow="{{ $project->progress }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            @if($project->notes)
                                <h5 class="mb-3">Notes Internes</h5>
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0 text-muted fst-italic">{{ $project->notes }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Tasks Panel -->
                        <div class="tab-pane fade" id="tasks" role="tabpanel">
                            <div class="default-table-area table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th class="fw-medium">Tâche</th>
                                            <th class="fw-medium">Statut</th>
                                            <th class="fw-medium">Priorité</th>
                                            <th class="fw-medium">Date d'échéance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($project->tasks as $task)
                                            <tr>
                                                <td>{{ $task->title }}</td>
                                                <td>
                                                    @php
                                                        $taskStatusMap = [
                                                            'todo' => ['label' => 'À Faire', 'class' => 'info'],
                                                            'in_progress' => ['label' => 'En Cours', 'class' => 'warning'],
                                                            'completed' => ['label' => 'Terminé', 'class' => 'success'],
                                                        ];
                                                        $tStatus = $taskStatusMap[$task->status] ?? ['label' => $task->status, 'class' => 'secondary'];
                                                    @endphp
                                                    <span
                                                        class="badge bg-{{ $tStatus['class'] }} bg-opacity-10 text-{{ $tStatus['class'] }} default-badge">
                                                        {{ $tStatus['label'] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @php
                                                        $tPriority = $priorityMap[$task->priority] ?? ['label' => $task->priority, 'class' => 'secondary'];
                                                    @endphp
                                                    <span
                                                        class="badge bg-{{ $tPriority['class'] }} bg-opacity-10 text-{{ $tPriority['class'] }} default-badge">
                                                        {{ $tPriority['label'] }}
                                                    </span>
                                                </td>
                                                <td>{{ $task->due_date ? $task->due_date->translatedFormat('d M, Y') : 'N/A' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4 text-muted">Aucune tâche trouvée
                                                    pour ce projet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Team Panel -->
                        <div class="tab-pane fade" id="team" role="tabpanel">
                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                @forelse($project->teamMembers as $member)
                                    <div class="col">
                                        <div class="d-flex align-items-center p-3 border rounded">
                                            <img src="{{ asset('assets/images/user1.jpg') }}" class="rounded-circle me-3"
                                                width="50" height="50">
                                            <div>
                                                <h6 class="mb-0">{{ $member->name }}</h6>
                                                <span class="text-muted fs-12">{{ $member->pivot->role ?: 'Membre' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-center py-4 text-muted">Aucun membre d'équipe assigné pour le
                                        moment.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>