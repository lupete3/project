<?php

namespace App\Livewire\Invoices;

use Livewire\Component;
use App\Models\Invoice;

class InvoiceDetails extends Component
{
    public Invoice $invoice;

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice->load(['client', 'project', 'items']);
    }

    public function render()
    {
        return view('livewire.invoices.invoice-details');
    }
}
