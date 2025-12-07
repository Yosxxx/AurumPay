@extends('layouts.app')

@section('content')
    {{-- RESPONSIVE FIX: p-4 on mobile, p-10 on desktop. Added w-full and centering. --}}
    <main class="space-y-5 p-4 md:p-10 mx-auto w-full flex flex-col items-center">

        @php
            $user = auth()->user();
            $nameParts = explode(' ', $user->name, 2);
            $firstName = $nameParts[0];
            $lastName = $nameParts[1] ?? '';
            $initials = strtoupper(substr($firstName, 0, 1) . ($lastName ? substr($lastName, 0, 1) : ''));
        @endphp

        {{-- RESPONSIVE FIX: Smaller text on mobile --}}
        <div class="text-2xl md:text-4xl font-bold mx-auto">Account Settings</div>

        @if (session('success'))
            {{-- Added w-full max-w-2xl so the alert matches the card width --}}
            <div class="w-full max-w-2xl bg-green-500/10 text-green-500 border-green-500/20 border p-4 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        {{-- 
            RESPONSIVE FIX: 
            w-full: Takes up 100% of the screen on phones
            max-w-2xl: Stops getting wider than 2xl on computers
            (Replaces min-w-2xl)
        --}}
        <x-card class="w-full max-w-2xl">

            <x-card.header class="space-y-2">

                <x-card.title>Profile Information</x-card.title>
                <x-card.description>Update your personal account details.</x-card.description>

                {{-- Avatar initials --}}
                <div class="mx-auto w-fit rounded-full bg-primary/10 p-4 text-center">
                    <span class="text-primary text-2xl font-bold">{{ $initials }}</span>
                </div>

            </x-card.header>

            <x-card.content>
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Name Fields --}}
                    {{-- RESPONSIVE FIX: Stack vertically on mobile (flex-col), side-by-side on desktop (md:flex-row) --}}
                    <div class="flex flex-col md:flex-row gap-5">
                        <div class="flex-1">
                            <x-label>First Name</x-label>
                            <x-input name="first_name" value="{{ $firstName }}" required class="w-full" />
                        </div>

                        <div class="flex-1">
                            <x-label>Last Name</x-label>
                            <x-input name="last_name" value="{{ $lastName }}" required class="w-full" />
                        </div>
                    </div>
                    
                    {{-- Account number (uneditable) --}}
                    <div>
                        <x-label>Account Number</x-label>
                        <x-input 
                            value="{{ $user->account_number }}" 
                            readonly 
                            class="bg-white/10 text-gray-400 cursor-not-allowed border-dashed w-full" 
                        />
                        <p class="text-[10px] text-gray-500 mt-1">Unique identifier for receiving funds.</p>
                    </div>

                    {{-- Email --}}
                    <div>
                        <x-label>Email</x-label>
                        <x-input name="email" type="email" value="{{ $user->email }}" required class="w-full" />
                    </div>

                    {{-- New Password --}}
                    <div>
                        <x-label>New Password (Leave blank to keep current)</x-label>
                        <x-input name="password" type="password" placeholder="Enter a new password" class="w-full" />
                    </div>

                    <x-button type="submit" class="w-full">Save Changes</x-button>
                </form>
            </x-card.content>

        </x-card>
    </main>
@endsection