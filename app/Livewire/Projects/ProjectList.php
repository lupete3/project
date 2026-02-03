<?php

namespace App\Livewire\Projects;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Project;

class ProjectList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $status = '';
    public $priority = '';

    protected $queryString = ['search', 'status', 'priority'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteProject($id)
    {
        Project::findOrFail($id)->delete();
        session()->flash('message', 'Project deleted successfully.');
    }

    public function render()
    {
        $projects = Project::with('client')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->priority, fn($q) => $q->where('priority', $this->priority))
            ->latest()
            ->paginate(10);

        return view('livewire.projects.project-list', [
            'projects' => $projects
        ]);
    }
}
