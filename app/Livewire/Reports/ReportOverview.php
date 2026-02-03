<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Revenue;
use App\Models\Expense;
use App\Models\Project;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ReportOverview extends Component
{
    public $projectProfitability;
    public $monthlyRevenue;
    public $clientRevenue;

    public function mount()
    {
        $this->loadReports();
    }

    public function loadReports()
    {
        // 1. Project Profitability
        $this->projectProfitability = Project::all()
            ->map(fn($p) => [
                'name' => $p->name,
                'revenue' => $p->revenues()->sum('amount'),
                'expenses' => $p->expenses()->sum('amount'),
                'profit' => $p->profit,
            ])
            ->sortByDesc('profit')
            ->take(5);

        // 2. Client Revenue Breakdown
        $this->clientRevenue = Client::get()->map(fn($c) => [
            'name' => $c->name,
            'revenue' => $c->total_revenue,
        ])->sortByDesc('revenue')->take(5);

        // 3. Monthly Revenue (Current Year)
        $this->monthlyRevenue = Revenue::select(
            DB::raw('MONTH(revenue_date) as month'),
            DB::raw('SUM(amount) as total')
        )
            ->whereYear('revenue_date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    public function render()
    {
        return view('livewire.reports.report-overview');
    }
}
