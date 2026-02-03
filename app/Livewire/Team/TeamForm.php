<?php

namespace App\Livewire\Team;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class TeamForm extends Component
{
    public $user;
    public $isEditing = false;

    public $name;
    public $email;
    public $password;
    public $role = 'member';

    public function mount(User $user = null)
    {
        if ($user && $user->exists) {
            $this->user = $user;
            $this->isEditing = true;
            $this->fill($user->toArray());
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($this->isEditing ? $this->user->id : 'NULL'),
            'password' => $this->isEditing ? 'nullable' : ['required', Password::defaults()],
            'role' => 'required|in:admin,developer,designer,member',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->password) {
            $validatedData['password'] = Hash::make($this->password);
        } else {
            unset($validatedData['password']);
        }

        if ($this->isEditing) {
            $this->user->update($validatedData);
            session()->flash('message', 'Team member updated.');
        } else {
            User::create($validatedData);
            session()->flash('message', 'Team member added.');
        }

        return redirect()->route('team.index');
    }

    public function render()
    {
        return view('livewire.team.team-form');
    }
}
