<?php

namespace App\Livewire\Invoices;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\Project;
use App\Models\InvoiceItem;

class InvoiceForm extends Component
{
    public $invoice;
    public $isEditing = false;

    public $client_id;
    public $project_id;
    public $invoice_number;
    public $issue_date;
    public $due_date;
    public $notes;
    public $tax_percentage = 0;

    public $items = [];

    public function mount(Invoice $invoice = null)
    {
        $this->issue_date = now()->format('Y-m-d');
        $this->due_date = now()->addDays(14)->format('Y-m-d');
        $this->invoice_number = 'INV-' . date('Ymd') . '-' . rand(100, 999);

        if ($invoice && $invoice->exists) {
            $this->invoice = $invoice;
            $this->isEditing = true;
            $this->fill($invoice->toArray());
            $this->issue_date = $invoice->issue_date instanceof \Carbon\Carbon ? $invoice->issue_date->format('Y-m-d') : $invoice->issue_date;
            $this->due_date = $invoice->due_date instanceof \Carbon\Carbon ? $invoice->due_date->format('Y-m-d') : $invoice->due_date;
            $this->items = $invoice->items->toArray();
        } else {
            $this->items[] = ['description' => '', 'quantity' => 1, 'unit_price' => 0];
        }
    }

    public function addItem()
    {
        $this->items[] = ['description' => '', 'quantity' => 1, 'unit_price' => 0];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function save()
    {
        $this->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_number' => 'required|unique:invoices,invoice_number,' . ($this->isEditing ? $this->invoice->id : 'NULL'),
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0.1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $totalAmount = collect($this->items)->sum(fn($item) => $item['quantity'] * $item['unit_price']);

        if ($this->isEditing) {
            $this->invoice->update([
                'client_id' => $this->client_id,
                'project_id' => $this->project_id,
                'invoice_number' => $this->invoice_number,
                'issue_date' => $this->issue_date,
                'due_date' => $this->due_date,
                'amount' => $totalAmount,
                'tax_percentage' => $this->tax_percentage,
                'notes' => $this->notes,
            ]);
            $this->invoice->items()->delete();
        } else {
            $this->invoice = Invoice::create([
                'client_id' => $this->client_id,
                'project_id' => $this->project_id,
                'invoice_number' => $this->invoice_number,
                'issue_date' => $this->issue_date,
                'due_date' => $this->due_date,
                'amount' => $totalAmount,
                'tax_percentage' => $this->tax_percentage,
                'status' => 'draft',
                'notes' => $this->notes,
            ]);
        }

        foreach ($this->items as $item) {
            $item['amount'] = $item['quantity'] * $item['unit_price'];
            $this->invoice->items()->create($item);
        }

        return redirect()->route('invoices.index');
    }

    public function render()
    {
        return view('livewire.invoices.invoice-form', [
            'clients' => Client::all(),
            'projects' => Project::all()
        ]);
    }
}
