<div>
    <div class="card border-0 rounded-10 border-white mb-4">
        <div class="card-body p-4">
            <form wire:submit.prevent="save">
                <div class="row g-4">
                    <!-- Basic Info -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nom de l'Entreprise <span
                                class="text-danger">*</span></label>
                        <input type="text" wire:model="company_name"
                            class="form-control @error('company_name') is-invalid @enderror">
                        @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email de l'Entreprise</label>
                        <input type="email" wire:model="company_email"
                            class="form-control @error('company_email') is-invalid @enderror">
                        @error('company_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Téléphone</label>
                        <input type="text" wire:model="company_phone"
                            class="form-control @error('company_phone') is-invalid @enderror">
                        @error('company_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Site Web</label>
                        <input type="text" wire:model="company_website"
                            class="form-control @error('company_website') is-invalid @enderror">
                        @error('company_website') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Adresse</label>
                        <input type="text" wire:model="company_address"
                            class="form-control @error('company_address') is-invalid @enderror">
                        @error('company_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <hr>

                    <!-- Legal & Tax -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Numéro d'Identification Fiscale (NIF/SIRET/etc.)</label>
                        <input type="text" wire:model="tax_number"
                            class="form-control @error('tax_number') is-invalid @enderror">
                        @error('tax_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <hr>

                    <!-- Bank Info -->
                    <h5 class="mb-0">Informations Bancaires</h5>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nom de la Banque</label>
                        <input type="text" wire:model="bank_name"
                            class="form-control @error('bank_name') is-invalid @enderror">
                        @error('bank_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">IBAN</label>
                        <input type="text" wire:model="bank_iban"
                            class="form-control @error('bank_iban') is-invalid @enderror">
                        @error('bank_iban') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">SWIFT/BIC</label>
                        <input type="text" wire:model="bank_swift"
                            class="form-control @error('bank_swift') is-invalid @enderror">
                        @error('bank_swift') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <hr>

                    <!-- Invoice Footer -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Texte de bas de facture</label>
                        <textarea wire:model="invoice_footer_text"
                            class="form-control @error('invoice_footer_text') is-invalid @enderror" rows="3"
                            placeholder="ex: Merci de votre confiance. Conditions de paiement à 30 jours."></textarea>
                        @error('invoice_footer_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Logo -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Logo de l'Entreprise</label>
                        <input type="file" wire:model="company_logo"
                            class="form-control @error('company_logo') is-invalid @enderror">
                        @error('company_logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @if ($company_logo)
                            <div class="mt-2">
                                <img src="{{ $company_logo->temporaryUrl() }}" width="150" class="rounded border">
                            </div>
                        @elseif($company_logo_path)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $company_logo_path) }}" width="150" class="rounded border">
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-primary px-5">
                            Enregistrer les Paramètres
                        </button>
                        @if (session()->has('message'))
                            <div class="text-success mt-2">
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>