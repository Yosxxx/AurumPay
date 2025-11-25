@extends('layouts.app')

@section('content')
    <main class="space-y-5 p-10 mx-auto">
        <div class="text-4xl font-bold mx-auto">Transfer Money</div>
        <x-card class="min-w-2xl">
            <x-card.header>
                <x-card.title>Transaction Details</x-card.title>
                <x-card.description>Enter the recipient's details securely.</x-card.descrption>
            </x-card.header>

            <x-card.content>
                <form action="" class="space-y-5">
                    <div>
                        <x-label>Recipient Bank ID / Account Number</x-label>
                        <x-input  placeholder="Enter ID"></x-input>
                    </div>
                    <div>
                        <x-label>Amount (USD)</x-label>
                        <x-input placeholder="$ 0.00"></x-input>
                    </div>
                    <div>
                        <x-label>Note (Optional)</x-label>
                        <x-input placeholder="For Dinner, Rent, etc."></x-input>
                    </div>
                    <x-button class="w-full">Send Money</x-button>
                </form>
            </x-card.content>
        </x-card>
    </main>
@endsection
