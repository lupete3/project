<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Project;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Renewal;
use App\Models\Expense;
use App\Models\Revenue;

class MainDashboard extends Component
{
    public $stats = [];
    public $recentProjects = [];
    public $upcomingRenewals = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadRecentData();
    }

    public function loadStats()
    {
        $this->stats = [
            'total_projects' => Project::count(),
            'active_projects' => Project::where('status', 'in_progress')->count(),
            'total_revenue' => Revenue::sum('amount'),
            'total_expenses' => Expense::sum('amount'),
            'profit' => Revenue::sum('amount') - Expense::sum('amount'),
            'pending_invoices' => Invoice::where('status', 'sent')->count(),
            'overdue_invoices' => Invoice::where('status', 'overdue')->count(),
        ];
    }

    public function loadRecentData()
    {
        $this->recentProjects = Project::with('client')->latest()->take(5)->get();
        $this->upcomingRenewals = Renewal::with('client')
            ->where('renewal_date', '>=', now())
            ->where('renewal_date', '<=', now()->addDays(30))
            ->orderBy('renewal_date')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.main-dashboard');
    }
}
