<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="rq min-h-screen antialiased">
        <x-raque.topbar />
        <x-raque.navbar />

        <main class="rq-section rq-section--panel" style="min-height:60vh">
            <div class="rq-container" style="max-width:520px">
                <div class="rq-panel">
                    <div style="text-align:center;margin-bottom:25px">
                        <a href="{{ route('home') }}" class="rq-navbar__brand" wire:navigate><i class="bx bxs-graduation"></i>Campusy</a>
                    </div>
                    <div class="flex flex-col gap-6">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </main>

        <x-raque.footer />

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
