<?php

namespace App\Livewire\Quotes;

use App\Models\Quote;
use Livewire\Component;

class QuoteDetails extends Component
{
    public Quote $quote;

    public function mount(Quote $quote)
    {
        $this->quote = $quote->load(['client', 'project', 'items']);
    }

    public function updateStatus($status)
    {
        $this->quote->update(['status' => $status]);
        session()->flash('success', 'Statut du devis mis à jour.');
    }

    public function render()
    {
        return view('livewire.quotes.quote-details');
    }
}
