<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <div class="card border-0 rounded-10 border-white">
        <div class="card-body p-4">
            <h5 class="mb-2">Mettre à jour le mot de passe</h5>
            <p class="text-muted mb-4 fs-13">Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester en sécurité.</p>

            <form wire:submit="updatePassword" style="max-width: 500px;">
                <div class="mb-3">
                    <label for="current_password" class="form-label fw-semibold">Mot de passe actuel</label>
                    <input type="password" id="current_password" wire:model="current_password" class="form-control" required autocomplete="current-password" />
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Nouveau mot de passe</label>
                    <input type="password" id="password" wire:model="password" class="form-control" required autocomplete="new-password" />
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-semibold">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" wire:model="password_confirmation" class="form-control" required autocomplete="new-password" />
                </div>

                <div class="d-flex align-items-center mt-4">
                    <button type="submit" class="btn btn-primary px-4">Enregistrer</button>

                    <x-action-message class="ms-3 text-success" on="password-updated">
                        Enregistré.
                    </x-action-message>
                </div>
            </form>
        </div>
    </div>
</section>
