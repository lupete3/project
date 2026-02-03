<?php

namespace App\Livewire\Finances;

use Livewire\Component;
use App\Models\Expense;
use App\Models\Revenue;
use App\Models\Project;

class FinancialOverview extends Component
{
    public $expenses;
    public $revenues;
    public $totalRevenue;
    public $totalExpenses;
    public $profit;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->expenses = Expense::with('project')->latest()->take(10)->get();
        $this->revenues = Revenue::with('project')->latest()->take(10)->get();

        $this->totalRevenue = Revenue::sum('amount');
        $this->totalExpenses = Expense::sum('amount');
        $this->profit = $this->totalRevenue - $this->totalExpenses;
    }

    public function render()
    {
        return view('livewire.finances.financial-overview');
    }
}
