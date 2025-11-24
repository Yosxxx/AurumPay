@extends('layouts.app')

@section('content')
    <main class="space-y-10 p-10">
        {{-- Balance --}}
        <x-card class="bg-linear-to-br from-primary/20 via-background to-background border-primary/20 space-y-5 p-10">
            <div class="text-muted-foreground text-xs font-bold">Total Balance</div>

            <div>
                <div class="text-4xl font-bold">$124,500.00</div>
                <div class="text-muted-foreground text-xs font-bold">Available for transfer</div>
            </div>

            <div class="flex gap-x-2">
                <x-button>
                    <x-heroicon-o-paper-airplane class="mr-2 h-5 w-5" />
                    Transfer
                </x-button>

                <x-button variant="outline">
                    <x-heroicon-o-qr-code class="mr-2 h-5 w-5" />
                    Scan QR
                </x-button>

            </div>
        </x-card>

        {{-- Recent Activity --}}
        @php
            $activities = [
                [
                    'type' => 'out',
                    'title' => 'Apple Store',
                    'time' => 'Today, 10:42 AM',
                    'amount' => '-$1,299.00',
                ],
                [
                    'type' => 'in',
                    'title' => 'Salary Deposit',
                    'time' => 'Today, 6:00 AM',
                    'amount' => '+$3,500.00',
                ],
                [
                    'type' => 'out',
                    'title' => 'Grab Ride',
                    'time' => 'Yesterday, 8:14 PM',
                    'amount' => '-$12.50',
                ],
                [
                    'type' => 'out',
                    'title' => 'Starbucks',
                    'time' => 'Yesterday, 4:23 PM',
                    'amount' => '-$4.90',
                ],
                [
                    'type' => 'in',
                    'title' => 'Refund – Spotify',
                    'time' => 'Nov 15, 2:10 PM',
                    'amount' => '+$9.99',
                ],
            ];
        @endphp

        <x-card>
            <x-card.header>
                <x-card.title>Recent Activity</x-card.title>
                <x-card.description>Your last 5 transactions</x-card.description>
            </x-card.header>

            <x-card.content class="space-y-4">
                @foreach ($activities as $item)
                    <div class="flex items-center">

                        {{-- Icon --}}
                        <div class="mr-4">
                            @if ($item['type'] === 'out')
                                <x-heroicon-o-arrow-up-right class="h-5 w-5 text-red-500" />
                            @else
                                <x-heroicon-o-arrow-down-left class="h-5 w-5 text-green-500" />
                            @endif
                        </div>

                        {{-- Activity --}}
                        <div class="flex-1">
                            <div class="font-semibold">{{ $item['title'] }}</div>
                            <div class="text-muted-foreground text-xs">{{ $item['time'] }}</div>
                        </div>

                        {{-- Amount --}}
                        <div class="{{ $item['type'] === 'out' ? 'text-red-500' : 'text-green-500' }} font-semibold">
                            {{ $item['amount'] }}
                        </div>
                    </div>
                @endforeach
            </x-card.content>
        </x-card>
    </main>
@endsection
