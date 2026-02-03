<?php

namespace App\Livewire\Renewals;

use Livewire\Component;
use App\Models\Renewal;
use App\Models\Client;

class RenewalList extends Component
{
    public $search = '';

    public function deleteRenewal($id)
    {
        Renewal::findOrFail($id)->delete();
        session()->flash('message', 'Renewal record deleted.');
    }

    public function render()
    {
        $renewals = Renewal::with('client')
            ->when($this->search, function ($query) {
                $query->where('service_name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('renewal_date')
            ->paginate(10);

        return view('livewire.renewals.renewal-list', [
            'renewals' => $renewals
        ]);
    }
}
