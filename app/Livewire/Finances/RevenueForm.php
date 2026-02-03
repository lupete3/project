<?php

namespace App\Livewire\Finances;

use Livewire\Component;
use App\Models\Revenue;
use App\Models\Project;
use App\Models\Invoice;

class RevenueForm extends Component
{
    public $revenue;
    public $isEditing = false;

    public $project_id;
    public $invoice_id;
    public $description;
    public $amount;
    public $revenue_date;
    public $notes;

    public function mount(Revenue $revenue = null)
    {
        if ($revenue && $revenue->exists) {
            $this->revenue = $revenue;
            $this->isEditing = true;
            $this->fill($revenue->toArray());
            $this->revenue_date = $revenue->revenue_date instanceof \Carbon\Carbon ? $revenue->revenue_date->format('Y-m-d') : $revenue->revenue_date;
        } else {
            $this->revenue_date = now()->format('Y-m-d');
        }
    }

    protected function rules()
    {
        return [
            'project_id' => 'nullable|exists:projects,id',
            'invoice_id' => 'nullable|exists:invoices,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'revenue_date' => 'required|date',
            'notes' => 'nullable|string',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->isEditing) {
            $this->revenue->update($validatedData);
            session()->flash('message', 'Revenu mis à jour avec succès.');
        } else {
            Revenue::create($validatedData);
            session()->flash('message', 'Revenu enregistré avec succès.');
        }

        return redirect()->route('finances.index');
    }

    public function render()
    {
        return view('livewire.finances.revenue-form', [
            'projects' => Project::all(),
            'invoices' => Invoice::all(),
        ]);
    }
}
