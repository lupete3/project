<?php

namespace App\Livewire\Projects;

use Livewire\Component;
use App\Models\Project;

class ProjectDetails extends Component
{
    public Project $project;

    public function mount(Project $project)
    {
        $this->project = $project->load(['client', 'tasks', 'expenses', 'revenues', 'teamMembers']);
    }

    public function render()
    {
        return view('livewire.projects.project-details');
    }
}
