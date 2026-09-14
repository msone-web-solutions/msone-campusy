<?php

use App\Enums\UserRole;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Title('Familie')] class extends Component
{
    #[Validate('required|email')]
    public string $parentEmail = '';

    public function link(): void
    {
        $this->validate();

        $parent = User::query()->where('email', $this->parentEmail)->where('role', UserRole::Parent)->first();

        if ($parent === null || $parent->id === auth()->id()) {
            $this->addError('parentEmail', 'Unter dieser E-Mail gibt es kein Eltern-Konto. Dein Elternteil muss sich zuerst als „Elternteil“ registrieren.');

            return;
        }

        auth()->user()->update(['parent_id' => $parent->id]);
        $this->parentEmail = '';
        $this->dispatch('family-updated');
    }

    public function unlink(): void
    {
        auth()->user()->update(['parent_id' => null]);
    }
};
?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-pages::settings.layout heading="Familie" subheading="Verknüpfe dein Konto mit einem Elternteil, damit er oder sie deinen Fortschritt sehen kann.">
        @php $user = auth()->user()->fresh(['parent', 'children']); @endphp

        @if ($user->isParent())
            <flux:text>Du bist als Elternteil angemeldet. Schüler verknüpfen sich in ihren Einstellungen mit deiner E-Mail-Adresse <strong>{{ $user->email }}</strong>.</flux:text>
            <div class="mt-4">
                <flux:heading size="sm">Verknüpfte Kinder</flux:heading>
                @forelse ($user->children as $child)
                    <flux:text>· {{ $child->name }} ({{ $child->email }})</flux:text>
                @empty
                    <flux:text>Noch keine.</flux:text>
                @endforelse
            </div>
            <div class="mt-4"><flux:button :href="route('parent.dashboard')" wire:navigate variant="primary">Zur Elternübersicht</flux:button></div>
        @else
            @if ($user->parent)
                <flux:text>Verknüpft mit <strong>{{ $user->parent->name }}</strong> ({{ $user->parent->email }}).</flux:text>
                <div class="mt-4"><flux:button wire:click="unlink" variant="danger">Verknüpfung lösen</flux:button></div>
            @else
                <form wire:submit="link" class="mt-2 space-y-4">
                    <flux:input wire:model="parentEmail" label="E-Mail-Adresse des Elternteils" type="email" placeholder="mama@example.com" />
                    <flux:button type="submit" variant="primary">Verknüpfen</flux:button>
                </form>
            @endif
        @endif
    </x-pages::settings.layout>
</section>
