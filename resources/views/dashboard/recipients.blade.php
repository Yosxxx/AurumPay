@extends('layouts.app')

@section('content')
    <main class="space-y-5 p-10">
        <div class="flex items-center justify-between">
            <div class="text-4xl font-bold">Recipients</div>
            <x-dialog-custom.dialog name="addRecipient">

                {{-- TRIGGER --}}
                <x-dialog-custom.dialog-trigger name="addRecipient">
                    <x-button class="hover:cursor-pointer">
                        <x-heroicon-s-plus class="mr-1 h-4 w-4" />
                        Add New
                    </x-button>
                </x-dialog-custom.dialog-trigger>

                {{-- CONTENT --}}
                <x-dialog-custom.dialog-content name="addRecipient">

                    <x-dialog-custom.dialog-header name="addRecipient" title="Add Recipient" />

                    <form class="space-y-4">

                        <label class="text-sm font-medium">Bank ID</label>

                        <div class="flex gap-2">
                            <x-input placeholder="Enter Bank ID..." class="flex-1" />

                            <x-button class="whitespace-nowrap">
                                Verify
                            </x-button>
                        </div>

                        <div class="flex justify-end gap-2">
                            <x-button variant="secondary">Cancel</x-button>

                            <x-button type="submit">Save</x-button>
                        </div>
                    </form>
                </x-dialog-custom.dialog-content>
            </x-dialog-custom.dialog>
        </div>


        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 10.5 18a7.5 7.5 0 0 0 6.15-3.35Z" />
                </svg>
            </span>

            <x-input class="pl-10" placeholder="Search..." />
        </div>


        <div class="grid grid-cols-4 gap-5">
            @foreach ($recipients as $r)
                @php
                    $initials = collect(explode(' ', $r['name']))
                        ->map(fn($part) => strtoupper($part[0]))
                        ->join('');
                @endphp

                <x-card class="hover:bg-card flex items-center px-4 py-6 hover:cursor-pointer">
                    <div class="text-primary bg-primary/10 rounded-full p-4 font-bold">
                        {{ $initials }}
                    </div>
                    <x-card.header>
                        <x-card.title>{{ $r['name'] }}</x-card.title>
                        <x-card.description>{{ $r['number'] }}</x-card.description>
                    </x-card.header>
                </x-card>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $recipients->links() }}
        </div>
    </main>
@endsection
