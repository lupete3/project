<?php

namespace App\Livewire\Quotes;

use App\Models\Quote;
use Livewire\Component;
use Livewire\WithPagination;

class QuoteList extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    protected $updatesQueryString = ['search', 'status'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteQuote($id)
    {
        $quote = Quote::find($id);
        if ($quote) {
            $quote->delete();
            session()->flash('success', 'Devis supprimé avec succès.');
        }
    }

    public function render()
    {
        $quotes = Quote::with(['client', 'project'])
            ->when($this->search, function ($query) {
                $query->where('quote_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.quotes.quote-list', [
            'quotes' => $quotes,
        ]);
    }
}
