<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', 'Un lien de réinitialisation sera envoyé si le compte existe.');
    }
}; ?>

@section('title', 'Mot de passe oublié')

<div>
    <x-auth-header :title="'Mot de passe oublié ?'" :description="'Entrez votre e-mail et nous vous enverrons les instructions pour réinitialiser votre mot de passe'" />

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-info mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="sendPasswordResetLink" class="mb-6">
        <div class="mb-4">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input wire:model="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                required autofocus autocomplete="email" placeholder="Entrez votre e-mail">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary d-grid w-100 mb-4 py-2">
            Envoyer le lien de réinitialisation
        </button>
    </form>

    <div class="text-center">
        <a href="{{ route('login') }}" class="d-flex justify-content-center fw-semibold" wire:navigate>
            <i class="bx bx-chevron-left scaleX-n1-rtl me-1"></i>
            Retour à la connexion
        </a>
    </div>
</div>