<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use App\Models\Client;

class ClientDetails extends Component
{
    public Client $client;

    public function mount(Client $client)
    {
        $this->client = $client->load(['projects', 'invoices', 'renewals']);
    }

    public function render()
    {
        return view('livewire.clients.client-details');
    }
}
