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

    <form action="{{ route('recipients.store') }}" method="POST" class="space-y-4">
        @csrf 
        
        <div id="verify-message" class="hidden p-3 rounded text-sm font-bold"></div>

        <div>
            <label class="text-sm font-medium">Account Number</label>
            <div class="flex gap-2">
                <x-input 
                    id="account_input"
                    name="account_number" 
                    placeholder="e.g. 123456789" 
                    class="flex-1" 
                    required 
                />
                
                <x-button type="button" class="whitespace-nowrap" onclick="verifyAccount()">
                    Verify
                </x-button>
            </div>
        </div>

        <div>
            <label class="text-sm font-medium">Nickname</label>
            <x-input 
                id="name_input"
                name="name" 
                placeholder="e.g. Mom, Best Friend" 
                required 
            />
        </div>

        <div class="flex justify-end gap-2 mt-4">
            <x-button type="button" variant="secondary" x-on:click="open = false">Cancel</x-button>
            <x-button type="submit">Save</x-button>
        </div>
    </form>
</x-dialog-custom.dialog-content>
            </x-dialog-custom.dialog>
        </div>

        <form action="{{ route('recipients.index') }}" method="GET" class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 10.5 18a7.5 7.5 0 0 0 6.15-3.35Z" />
                </svg>
            </span>
            <x-input class="pl-10" name="search" value="{{ request('search') }}" placeholder="Search by name or account..." />
        </form>

        <div class="grid grid-cols-4 gap-5">
            @forelse ($recipients as $r)
                @php
                    $initials = collect(explode(' ', $r->recipient_name))
                        ->map(fn($part) => strtoupper($part[0]))
                        ->take(2)
                        ->join('');
                @endphp

                <a href="{{ url('/dashboard/transfer') }}?account_number={{ $r->recipient_account_number }}" class="block">
                    <x-card class="hover:bg-card flex items-center px-4 py-6 hover:cursor-pointer transition-colors">
                        <div class="text-primary bg-primary/10 rounded-full p-4 font-bold mr-4 h-12 w-12 flex items-center justify-center">
                            {{ $initials }}
                        </div>
                        <div>
                            <div class="font-bold text-lg leading-none">{{ $r->recipient_name }}</div>
                            <div class="text-gray-500 text-sm mt-1">{{ $r->recipient_account_number }}</div>
                        </div>
                    </x-card>
                </a>
            @empty
                <div class="col-span-4 text-center py-10 text-gray-500">
                    No recipients found. Click "Add New" to save someone.
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $recipients->links() }}
        </div>
    </main>

    @if($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const buttons = document.querySelectorAll('button');
                buttons.forEach(btn => {
                    if(btn.innerText.includes('Add New')) {
                        btn.click();
                    }
                });
            });
        </script>
    @endif



    <script>
        async function verifyAccount() {
            const accountInput = document.getElementById('account_input');
            const nameInput = document.getElementById('name_input');
            const messageBox = document.getElementById('verify-message');
            const csrfToken = document.querySelector('input[name="_token"]').value;

            messageBox.classList.add('hidden');
            messageBox.className = "hidden p-3 rounded text-sm font-bold mb-2"; 

            if(!accountInput.value) {
                alert("Please enter an account number first.");
                return;
            }

            try {

                const response = await fetch("{{ route('recipients.verify') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({ account_number: accountInput.value })
                });

                const data = await response.json();

                messageBox.classList.remove('hidden');

                if (data.status === 'success') {
                    messageBox.classList.add('bg-green-100', 'text-green-700', 'border', 'border-green-400');
                    messageBox.innerText = "✓ Verified: " + data.name;
                    
                    if(nameInput.value === '') {
                        nameInput.value = data.name; 
                    }
                } else {
                    messageBox.classList.add('bg-red-100', 'text-red-700', 'border', 'border-red-400');
                    messageBox.innerText = "⚠ " + data.message;
                }

            } catch (error) {
                console.error('Error:', error);
                alert("System error. Please try again.");
            }
        }
    </script>
    

@endsection