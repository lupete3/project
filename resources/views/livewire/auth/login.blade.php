<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
};
?>
@section('title', 'Connexion')

<div>
    <x-auth-header :title="'Bienvenue sur :app !'" :description="'Entrez votre e-mail et votre mot de passe pour vous connecter'" />

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-info mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="login" class="mb-6">
        <div class="mb-4">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input wire:model="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                required autofocus autocomplete="email" placeholder="Entrez votre e-mail">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <div class="d-flex justify-content-between mb-1">
                <label for="password" class="form-label fw-semibold mb-0">Mot de passe</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" wire:navigate class="fs-13">
                        <span>Mot de passe oublié ?</span>
                    </a>
                @endif
            </div>
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

        <div class="mb-4">
            <div class="form-check">
                <input wire:model="remember" type="checkbox" class="form-check-input" id="remember">
                <label class="form-check-label fs-14" for="remember">
                    Se souvenir de moi
                </label>
            </div>
        </div>

        <div class="mb-4">
            <button type="submit" class="btn btn-primary d-grid w-100 py-2">Se connecter</button>
        </div>
    </form>

    @if (Route::has('register'))
        <p class="text-center mb-0">
            <span class="text-muted">Nouveau sur notre plateforme ?</span>
            <a href="{{ route('register') }}" wire:navigate class="fw-semibold">
                <span>Créer un compte</span>
            </a>
        </p>
    @endif
</div>