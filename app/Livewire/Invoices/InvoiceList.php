<?php

namespace App\Livewire\Invoices;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Client;

class InvoiceList extends Component
{
    use \Livewire\WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteInvoice($id)
    {
        Invoice::findOrFail($id)->delete();
        session()->flash('message', 'Facture supprimée avec succès.');
    }

    public function markAsPaid($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update(['status' => 'paid', 'paid_at' => now()]);
        session()->flash('message', 'Facture marquée comme payée.');
    }

    public function render()
    {
        $invoices = Invoice::with('client')
            ->when($this->search, function ($query) {
                $query->where('invoice_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.invoices.invoice-list', [
            'invoices' => $invoices
        ]);
    }
}
