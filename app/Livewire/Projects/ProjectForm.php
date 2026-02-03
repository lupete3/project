<?php

namespace App\Livewire\Projects;

use Livewire\Component;
use App\Models\Project;
use App\Models\Client;

class ProjectForm extends Component
{
    public $project;
    public $isEditing = false;

    public $client_id;
    public $name;
    public $description;
    public $status = 'prospect';
    public $budget;
    public $start_date;
    public $end_date;
    public $priority = 'medium';
    public $notes;

    public function mount(Project $project = null)
    {
        if ($project && $project->exists) {
            $this->project = $project;
            $this->isEditing = true;
            $this->fill($project->toArray());
            $this->start_date = optional($project->start_date)->format('Y-m-d');
            $this->end_date = optional($project->end_date)->format('Y-m-d');
        }
    }

    protected function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:prospect,in_progress,completed,cancelled',
            'budget' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'priority' => 'required|in:low,medium,high',
            'notes' => 'nullable|string',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->isEditing) {
            $this->project->update($validatedData);
            session()->flash('message', 'Project updated successfully.');
        } else {
            Project::create($validatedData);
            session()->flash('message', 'Project created successfully.');
        }

        return redirect()->route('projects.index');
    }

    public function render()
    {
        return view('livewire.projects.project-form', [
            'clients' => Client::all()
        ]);
    }
}
