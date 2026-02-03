<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\CompanySetting;
use Livewire\WithFileUploads;

class CompanySettingsForm extends Component
{
    use WithFileUploads;

    public $company_name;
    public $company_address;
    public $company_phone;
    public $company_email;
    public $company_website;
    public $company_logo;
    public $company_logo_path;
    public $tax_number;
    public $bank_name;
    public $bank_iban;
    public $bank_swift;
    public $invoice_footer_text;

    public function mount()
    {
        $settings = CompanySetting::first();

        if ($settings) {
            $this->fill($settings->toArray());
        }
    }

    protected function rules()
    {
        return [
            'company_name' => 'required|string|max:255',
            'company_address' => 'nullable|string|max:255',
            'company_phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:255',
            'company_website' => 'nullable|url|max:255',
            'company_logo' => 'nullable|image|max:1024', // 1MB Max
            'tax_number' => 'nullable|string|max:100',
            'bank_name' => 'nullable|string|max:255',
            'bank_iban' => 'nullable|string|max:50',
            'bank_swift' => 'nullable|string|max:20',
            'invoice_footer_text' => 'nullable|string|max:500',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->company_logo) {
            $validatedData['company_logo_path'] = $this->company_logo->store('logos', 'public');
        }

        unset($validatedData['company_logo']);

        $settings = CompanySetting::first();

        if ($settings) {
            $settings->update($validatedData);
        } else {
            CompanySetting::create($validatedData);
        }

        session()->flash('message', 'Paramètres de l\'entreprise mis à jour avec succès.');
        $this->dispatch('company-settings-updated');
    }

    public function render()
    {
        return view('livewire.settings.company-settings-form');
    }
}
