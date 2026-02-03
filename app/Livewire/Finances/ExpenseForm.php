<?php

namespace App\Livewire\Finances;

use Livewire\Component;
use App\Models\Expense;
use App\Models\Project;
use Livewire\WithFileUploads;

class ExpenseForm extends Component
{
    use WithFileUploads;

    public $expense;
    public $isEditing = false;

    public $project_id;
    public $category;
    public $description;
    public $amount;
    public $expense_date;
    public $receipt;
    public $receipt_path;
    public $notes;

    public function mount(Expense $expense = null)
    {
        if ($expense && $expense->exists) {
            $this->expense = $expense;
            $this->isEditing = true;
            $this->fill($expense->toArray());
            $this->expense_date = $expense->expense_date instanceof \Carbon\Carbon ? $expense->expense_date->format('Y-m-d') : $expense->expense_date;
        } else {
            $this->expense_date = now()->format('Y-m-d');
        }
    }

    protected function rules()
    {
        return [
            'project_id' => 'nullable|exists:projects,id',
            'category' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'receipt' => 'nullable|image|max:2048', // 2MB Max
            'notes' => 'nullable|string',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->receipt) {
            $validatedData['receipt_path'] = $this->receipt->store('receipts', 'public');
        }

        unset($validatedData['receipt']);

        if ($this->isEditing) {
            $this->expense->update($validatedData);
            session()->flash('message', 'Dépense mise à jour avec succès.');
        } else {
            Expense::create($validatedData);
            session()->flash('message', 'Dépense enregistrée avec succès.');
        }

        return redirect()->route('finances.index');
    }

    public function render()
    {
        return view('livewire.finances.expense-form', [
            'projects' => Project::all(),
            'categories' => [
                'Abonnement',
                'Hébergement',
                'Matériel',
                'Logiciel',
                'Marketing',
                'Autre'
            ]
        ]);
    }
}
