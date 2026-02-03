<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;

class TaskForm extends Component
{
    public $task;
    public $isEditing = false;

    public $project_id;
    public $title;
    public $description;
    public $status = 'todo';
    public $priority = 'medium';
    public $assigned_to;
    public $due_date;
    public $estimated_hours;

    public function mount(Task $task = null)
    {
        if ($task && $task->exists) {
            $this->task = $task;
            $this->isEditing = true;
            $this->fill($task->toArray());
            $this->due_date = $task->due_date?->format('Y-m-d');
        } elseif (request()->has('project_id')) {
            $this->project_id = request()->get('project_id');
        }
    }

    protected function rules()
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,review,completed',
            'priority' => 'required|in:low,medium,high',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'estimated_hours' => 'nullable|numeric|min:0',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->isEditing) {
            $this->task->update($validatedData);
            session()->flash('message', 'Task updated successfully.');
        } else {
            Task::create($validatedData);
            session()->flash('message', 'Task created successfully.');
        }

        return redirect()->route('tasks.index');
    }

    public function render()
    {
        return view('livewire.tasks.task-form', [
            'projects' => Project::all(),
            'users' => User::all()
        ]);
    }
}
