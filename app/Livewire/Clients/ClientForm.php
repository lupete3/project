<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use App\Models\Client;

class ClientForm extends Component
{
    public $client;
    public $isEditing = false;

    public $name;
    public $contact_person;
    public $email;
    public $phone;
    public $address;
    public $company;
    public $notes;

    public function mount(Client $client = null)
    {
        if ($client && $client->exists) {
            $this->client = $client;
            $this->isEditing = true;
            $this->fill($client->toArray());
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'company' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->isEditing) {
            $this->client->update($validatedData);
            session()->flash('message', 'Client updated successfully.');
        } else {
            Client::create($validatedData);
            session()->flash('message', 'Client created successfully.');
        }

        return redirect()->route('clients.index');
    }

    public function render()
    {
        return view('livewire.clients.client-form');
    }
}
