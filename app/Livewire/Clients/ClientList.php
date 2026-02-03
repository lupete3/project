<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Client;

class ClientList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteClient($id)
    {
        Client::findOrFail($id)->delete();
        session()->flash('message', 'Client deleted successfully.');
    }

    public function render()
    {
        $clients = Client::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('company', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        })
            ->withCount('projects')
            ->latest()
            ->paginate(10);

        return view('livewire.clients.client-list', [
            'clients' => $clients
        ]);
    }
}
