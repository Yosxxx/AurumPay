@extends('layouts.app')

@section('content')
    {{-- RESPONSIVE FIX: p-4 on mobile, p-10 on desktop. Added flex/items-center to center the card. --}}
    <main class="space-y-5 p-4 md:p-10 mx-auto w-full flex flex-col items-center">
        
        {{-- RESPONSIVE FIX: text-2xl on mobile, text-4xl on desktop --}}
        <div class="text-2xl md:text-4xl font-bold">Transfer Money</div>
        
        {{-- 
            RESPONSIVE FIX: 
            w-full: Takes up 100% of the screen on phones
            max-w-2xl: Stops getting wider than 2xl on computers
            (Replaces min-w-2xl which caused the issue)
        --}}
        <x-card class="w-full max-w-2xl">
            <x-card.header>
                <x-card.title>Transaction Details</x-card.title>
                <x-card.description>Enter the recipient's details securely.</x-card.description>
            </x-card.header>

            <x-card.content>
                {{-- Success Message --}}
                @if (session('success'))
                    <div class="bg-transparent border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Error Message --}}
                @if ($errors->any())
                    <div class="bg-transparent border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('transfer.post') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div>
                        <x-label>Recipient Bank ID / Account Number</x-label>
                        <x-input 
                            name="account_number" 
                            placeholder="Enter ID" 
                            value="{{ old('account_number', request('account_number')) }}"
                            class="w-full"
                        />
                    </div>

                    <div>
                        <x-label>Amount (USD)</x-label>
                        <x-input 
                            name="amount" 
                            type="number" 
                            step="0.01" 
                            placeholder="$ 0.00" 
                            value="{{ old('amount') }}"
                            class="w-full"
                        />
                    </div>

                    <div>
                        <x-label>Note (Optional)</x-label>
                        <x-input 
                            name="notes" 
                            placeholder="For Dinner, Rent, etc." 
                            value="{{ old('notes') }}"
                            class="w-full"
                        />
                    </div>

                    <x-button type="submit" class="w-full">Send Money</x-button>
                </form>
            </x-card.content>
        </x-card>
    </main>
@endsection