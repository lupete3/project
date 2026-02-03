<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

@section('title', 'Profil')

<section>
    @include('partials.settings-heading')

    <x-settings.layout :subheading="'Mettez à jour votre nom et votre adresse e-mail'">
        <div class="card border-0 rounded-10 border-white mb-4">
            <div class="card-body p-4">
                <form wire:submit="updateProfileInformation" class="mb-6" style="max-width: 500px;">
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">Nom</label>
                        <input type="text" id="name" wire:model="name" class="form-control" placeholder="Jean Dupont"
                            required autofocus autocomplete="name">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <div class="input-group">
                            <input type="email" id="email" wire:model="email" class="form-control"
                                placeholder="jean@exemple.com" required autocomplete="email">
                        </div>

                        @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                            <div class="mt-3">
                                <p class="text-warning">
                                    Votre adresse e-mail n'est pas vérifiée.
                                    <a href="#" wire:click.prevent="resendVerificationNotification"
                                        class="text-info">Cliquez ici pour renvoyer l'e-mail de vérification.</a>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 text-success">
                                        Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-primary px-4">Enregistrer les changements</button>
                        <x-action-message class="ms-3 text-success" on="profile-updated">
                            Enregistré.
                        </x-action-message>
                    </div>
                </form>
            </div>
        </div>

        <livewire:settings.password />

        <div class="mt-4">
            <livewire:settings.delete-user-form />
        </div>
    </x-settings.layout>
</section>