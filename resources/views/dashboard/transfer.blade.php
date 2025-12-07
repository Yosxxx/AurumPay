@extends('layouts.app')

@section('content')
    <main class="space-y-5 p-10 mx-auto">
        <div class="text-4xl font-bold mx-auto">Transfer Money</div>
        
        <x-card class="min-w-2xl">
            <x-card.header>
                <x-card.title>Transaction Details</x-card.title>
                <x-card.description>Enter the recipient's details securely.</x-card.description>
            </x-card.header>

            <x-card.content>
                @if (session('success'))
                    <div class="bg-transparent border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

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
                        ></x-input>
                    </div>

                    <div>
                        <x-label>Amount (USD)</x-label>
                        <x-input 
                            name="amount" 
                            type="number" 
                            step="0.01" 
                            placeholder="$ 0.00" 
                            value="{{ old('amount') }}"
                        ></x-input>
                    </div>

                    <div>
                        <x-label>Note (Optional)</x-label>
                        <x-input 
                            name="notes" 
                            placeholder="For Dinner, Rent, etc." 
                            value="{{ old('notes') }}"
                        ></x-input>
                    </div>

                    <x-button type="submit" class="w-full">Send Money</x-button>
                </form>
            </x-card.content>
        </x-card>
    </main>
@endsection