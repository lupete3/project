<?php

namespace App\Livewire\Quotes;

use App\Models\Quote;
use App\Models\Client;
use App\Models\Project;
use Livewire\Component;

class QuoteForm extends Component
{
    public $quote;
    public $isEditing = false;

    public $client_id;
    public $project_id;
    public $quote_number;
    public $issue_date;
    public $expiry_date;
    public $notes;
    public $status = 'draft';
    public $tax_percentage = 0;

    public $items = [];

    public function mount(Quote $quote = null)
    {
        if ($quote && $quote->exists) {
            $this->quote = $quote;
            $this->isEditing = true;
            $this->fill($quote->toArray());
            $this->issue_date = $quote->issue_date instanceof \Carbon\Carbon ? $quote->issue_date->format('Y-m-d') : \Carbon\Carbon::parse($quote->issue_date)->format('Y-m-d');
            $this->expiry_date = $quote->expiry_date ? ($quote->expiry_date instanceof \Carbon\Carbon ? $quote->expiry_date->format('Y-m-d') : \Carbon\Carbon::parse($quote->expiry_date)->format('Y-m-d')) : null;
            $this->items = $quote->items->toArray();
        } else {
            $this->issue_date = now()->format('Y-m-d');
            $this->expiry_date = now()->addDays(30)->format('Y-m-d');
            $this->quote_number = 'QT-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));
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
            'quote_number' => 'required|unique:quotes,quote_number,' . ($this->isEditing ? $this->quote->id : 'NULL'),
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0.1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,accepted,rejected,cancelled',
        ]);

        $subtotal = collect($this->items)->sum(fn($item) => $item['quantity'] * $item['unit_price']);
        $taxAmount = $subtotal * ($this->tax_percentage / 100);

        $data = [
            'client_id' => $this->client_id,
            'project_id' => $this->project_id,
            'quote_number' => $this->quote_number,
            'issue_date' => $this->issue_date,
            'expiry_date' => $this->expiry_date,
            'amount' => $subtotal,
            'tax' => $taxAmount,
            'status' => $this->status,
            'notes' => $this->notes,
        ];

        if ($this->isEditing) {
            $this->quote->update($data);
            $this->quote->items()->delete();
        } else {
            $this->quote = Quote::create($data);
        }

        foreach ($this->items as $item) {
            $item['amount'] = $item['quantity'] * $item['unit_price'];
            $this->quote->items()->create($item);
        }

        session()->flash('success', $this->isEditing ? 'Devis mis à jour.' : 'Devis créé.');
        return redirect()->route('quotes.index');
    }

    public function render()
    {
        return view('livewire.quotes.quote-form', [
            'clients' => Client::all(),
            'projects' => $this->client_id ? Project::where('client_id', $this->client_id)->get() : Project::all(),
        ]);
    }
}
