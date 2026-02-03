<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
            return;
        }

        Auth::user()->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

@section('title', 'Vérification de l'Email')

<div>
    <x-auth-header :title="'Vérifiez votre Email 📧'" :description="'Veuillez vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer par e-mail.'" />

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success mb-4 fs-14">
            Un nouveau lien de vérification a été envoyé à l'adresse e-mail que vous avez fournie lors de l'inscription.
        </div>
    @endif

    <div class="text-center mb-6">
        <button wire:click="sendVerification" class="btn btn-primary d-grid w-100 mb-3 py-2">
            Renvoyer l'e-mail de vérification
        </button>

        <button wire:click="logout" class="btn btn-link text-muted fs-14">
            Déconnexion
        </button>
    </div>
</div>