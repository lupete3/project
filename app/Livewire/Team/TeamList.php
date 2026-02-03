<?php

namespace App\Livewire\Team;

use Livewire\Component;
use App\Models\User;
use App\Models\Project;

class TeamList extends Component
{
    public $search = '';

    public function deleteMember($id)
    {
        $user = User::findOrFail($id);
        // In a real app, we might just revoke access or soft delete
        $user->delete();
        session()->flash('message', 'Team member removed.');
    }

    public function render()
    {
        $members = User::where('id', '!=', auth()->id()) // Don't list self if you want
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.team.team-list', [
            'members' => $members
        ]);
    }
}
