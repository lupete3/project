<?php

namespace App\Livewire\Renewals;

use Livewire\Component;
use App\Models\Renewal;
use App\Models\Client;

class RenewalForm extends Component
{
    public $renewal;
    public $isEditing = false;

    public $client_id;
    public $project_id;
    public $service_name;
    public $type = 'hosting';
    public $start_date;
    public $renewal_date;
    public $cost;
    public $price;
    public $status = 'active';
    public $notes;

    public function mount(Renewal $renewal = null)
    {
        if ($renewal && $renewal->exists) {
            $this->renewal = $renewal;
            $this->isEditing = true;
            $this->fill($renewal->toArray());
            $this->start_date = $renewal->start_date instanceof \Carbon\Carbon ? $renewal->start_date->format('Y-m-d') : $renewal->start_date;
            $this->renewal_date = $renewal->renewal_date instanceof \Carbon\Carbon ? $renewal->renewal_date->format('Y-m-d') : $renewal->renewal_date;
        } else {
            $this->start_date = now()->format('Y-m-d');
        }
    }

    protected function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'project_id' => 'nullable|exists:projects,id',
            'service_name' => 'required|string|max:255',
            'type' => 'required|in:hosting,domain,other',
            'start_date' => 'required|date',
            'renewal_date' => 'required|date',
            'cost' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,cancelled',
            'notes' => 'nullable|string',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        // Calculate margin
        $validatedData['margin'] = (float) $this->price - (float) $this->cost;

        if ($this->isEditing) {
            $this->renewal->update($validatedData);
            session()->flash('message', 'Renewal updated successfully.');
        } else {
            Renewal::create($validatedData);
            session()->flash('message', 'Renewal created successfully.');
        }

        return redirect()->route('renewals.index');
    }

    public function render()
    {
        return view('livewire.renewals.renewal-form', [
            'clients' => Client::all(),
            'projects' => \App\Models\Project::all()
        ]);
    }
}
