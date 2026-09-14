<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="rq min-h-screen">
        <x-raque.topbar />
        <x-raque.navbar />

        <main>
            {{ $slot }}
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
