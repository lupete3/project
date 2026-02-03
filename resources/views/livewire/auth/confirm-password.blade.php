<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (
            !Auth::guard('web')->validate([
                'email' => Auth::user()->email,
                'password' => $this->password,
            ])
        ) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

@section('title', 'Confirmation du Mot de passe')

<div>
    <x-auth-header :title="'Vérification de Sécurité 🔐'" :description="'Ceci est une zone sécurisée. Veuillez confirmer votre mot de passe avant de continuer.'" />

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-info mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="confirmPassword" class="mb-6">
        <div class="mb-4">
            <label class="form-label fw-semibold" for="password">Mot de passe</label>
            <div class="input-group">
                <input wire:model="password" type="password"
                    class="form-control @error('password') is-invalid @enderror" id="password" required
                    autocomplete="current-password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary d-grid w-100 mb-4 py-2">
            Confirmer le mot de passe
        </button>
    </form>

    <div class="text-center">
        <a href="{{ route('dashboard') }}" class="d-flex justify-content-center fw-semibold" wire:navigate>
            <i class="bx bx-chevron-left scaleX-n1-rtl me-1"></i>
            Retour au tableau de bord
        </a>
    </div>
</div>