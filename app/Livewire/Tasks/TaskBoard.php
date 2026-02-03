<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
use App\Models\Task;
use App\Models\Project;

class TaskBoard extends Component
{
    public $projectId;
    public $search = '';

    public function mount($projectId = null)
    {
        $this->projectId = $projectId;
    }

    public function updateTaskStatus($taskId, $newStatus)
    {
        $task = Task::findOrFail($taskId);
        $task->update(['status' => $newStatus]);
        session()->flash('message', 'Task status updated.');
    }

    public function render()
    {
        $query = Task::with(['project', 'assignee'])
            ->when($this->projectId, fn($q) => $q->where('project_id', $this->projectId))
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'));

        return view('livewire.tasks.task-board', [
            'tasks' => $query->get()
        ]);
    }
}
