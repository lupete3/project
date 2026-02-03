<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section>
    <div class="card border-0 rounded-10 border-white bg-danger bg-opacity-10">
        <div class="card-body p-4">
            <h5 class="mb-2 text-danger">Supprimer le compte</h5>
            <p class="text-muted mb-4 fs-13">Une fois votre compte supprimé, toutes ses ressources et données seront
                définitivement supprimées.</p>

            <button class="btn btn-danger px-4" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                Supprimer le compte
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Êtes-vous sûr de vouloir supprimer votre compte
                        ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted fs-14 mb-4">Une fois votre compte supprimé, toutes ses ressources et données
                        seront définitivement supprimées. Veuillez entrer votre mot de passe pour confirmer la
                        suppression définitive.</p>

                    <form wire:submit="deleteUser">
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Mot de passe</label>
                            <input type="password" id="password" wire:model="password" class="form-control" required />
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary px-4"
                                data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-danger px-4">Supprimer le compte</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>