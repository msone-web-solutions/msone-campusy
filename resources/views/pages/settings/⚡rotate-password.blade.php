<?php

use App\Concerns\PasswordValidationRules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts::auth')] #[Title('Neues Passwort festlegen')] class extends Component
{
    use PasswordValidationRules;

    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function mount(): void
    {
        if (! Auth::user()->must_change_password) {
            $this->redirect(Auth::user()->isParent() ? route('parent.dashboard') : route('dashboard'), navigate: true);
        }
    }

    /**
     * Replace the start password and clear the rotation flag.
     */
    public function rotate(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => $this->currentPasswordRules(),
                'password' => [...$this->passwordRules(), 'different:current_password'],
            ], [
                'password.different' => 'Das neue Passwort muss sich vom Startpasswort unterscheiden.',
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        $user = Auth::user();
        $user->update([
            'password' => $validated['password'],
            'must_change_password' => false,
        ]);

        $this->redirect($user->isParent() ? route('parent.dashboard') : route('dashboard'), navigate: true);
    }
};
?>

<div class="flex flex-col gap-6">
    <div style="text-align:center">
        <h1 style="font-size:28px;font-weight:100;line-height:1.2;margin-bottom:6px"><strong style="font-weight:700">Neues Passwort</strong> festlegen.</h1>
        <p>Dein Zugang wurde mit einem Startpasswort angelegt. Bitte lege jetzt ein eigenes Passwort fest, bevor es weitergeht.</p>
    </div>

    <form method="POST" wire:submit="rotate" class="flex flex-col gap-6">
        <flux:input wire:model="current_password" label="Startpasswort" type="password" required autocomplete="current-password" viewable />
        <flux:input wire:model="password" label="Neues Passwort" type="password" required autocomplete="new-password" viewable />
        <flux:input wire:model="password_confirmation" label="Neues Passwort wiederholen" type="password" required autocomplete="new-password" viewable />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">Passwort speichern</flux:button>
        </div>
    </form>

    <form method="POST" action="{{ route('logout') }}" style="text-align:center">
        @csrf
        <button type="submit" class="rq-btn rq-btn--ghost">Abmelden</button>
    </form>
</div>
