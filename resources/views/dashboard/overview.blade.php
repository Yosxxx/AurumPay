@extends('layouts.app')

@section('content')
    <main class="p-10">

        {{-- STATE FOR DIALOG --}}
        <div x-data="{ mode: 'deposit', amount: '' }" class="space-y-10">

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

                    {{-- DEPOSIT DIALOG --}}
                    <x-dialog-custom.dialog name="deposit">

                        <x-dialog-custom.dialog-trigger name="deposit">

                            <x-button x-on:click="mode = 'deposit'; amount = ''">
                                <x-heroicon-o-arrow-down-left class="h-5 w-5 text-black" />
                                Deposit
                            </x-button>

                        </x-dialog-custom.dialog-trigger>

                        <x-dialog-custom.dialog-content name="deposit">
                            <x-dialog-custom.dialog-header title="Deposit Funds" name="deposit" />

                            <div class="space-y-4 text-sm">
                                <x-label>Deposit Amount</x-label>
                                <x-input x-model="amount" placeholder="$0.00" />
                            </div>

                            <div class="mt-4 flex justify-end gap-2">
                                <x-button variant="outline" x-on:click="openDialog_deposit = false">Cancel</x-button>
                                <x-button x-on:click="alert('Deposited ' + amount); openDialog_deposit = false;">
                                    Deposit
                                </x-button>
                            </div>
                        </x-dialog-custom.dialog-content>

                    </x-dialog-custom.dialog>

                    {{-- WITHDRAW DIALOG --}}
                    <x-dialog-custom.dialog name="withdraw">
                        <x-dialog-custom.dialog-trigger name="withdraw">
                            <x-button variant="outline" x-on:click="mode = 'withdraw'; amount = ''">
                                <x-heroicon-o-arrow-up-right class="h-5 w-5 text-white" />
                                Withdraw
                            </x-button>
                        </x-dialog-custom.dialog-trigger>

                        <x-dialog-custom.dialog-content name="withdraw">

                            <x-dialog-custom.dialog-header title="Withdraw Funds" name="withdraw" />

                            <div class="space-y-4 text-sm">
                                <x-label>Withdraw Amount</x-label>
                                <x-input x-model="amount" placeholder="$0.00" />
                            </div>

                            <div class="mt-4 flex justify-end gap-2">
                                <x-button variant="outline" x-on:click="openDialog_withdraw = false">Cancel</x-button>

                                <x-button x-on:click="alert('Withdrew ' + amount);openDialog_withdraw = false;">
                                    Withdraw
                                </x-button>
                            </div>
                        </x-dialog-custom.dialog-content>
                    </x-dialog-custom.dialog>

                    <x-button variant="outline">
                        <x-heroicon-o-qr-code class="mr-2 h-5 w-5" />
                        Scan QR
                    </x-button>
                </div>
            </x-card>

            {{-- Recent Activity --}}
            <x-card>
                <x-card.header>
                    <x-card.title>Recent Activity</x-card.title>
                    <x-card.description>Your last 5 transactions</x-card.description>
                </x-card.header>

                <x-card.content class="space-y-4">

                    @foreach ($recent as $item)
                        <div class="flex items-center">

                            {{-- Icon --}}
                            <div class="mr-4">
                                @if ($item['type'] === 'withdraw')
                                    <x-heroicon-o-arrow-up-right class="h-5 w-5 text-red-500" />
                                @elseif ($item['type'] === 'deposit')
                                    <x-heroicon-o-arrow-down-left class="h-5 w-5 text-green-500" />
                                @elseif ($item['type'] === 'transfer')
                                    @if ($item['amount'] < 0)
                                        <x-heroicon-o-arrow-up-right class="h-5 w-5 text-red-500" />
                                    @else
                                        <x-heroicon-o-arrow-down-left class="h-5 w-5 text-green-500" />
                                    @endif
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="flex-1">
                                <div class="font-semibold">{{ $item['desc'] }}</div>
                                <div class="text-muted-foreground text-xs">{{ $item['date'] }}</div>
                            </div>

                            {{-- Amount --}}
                            <div class="{{ $item['amount'] < 0 ? 'text-red-500' : 'text-green-500' }} font-semibold">
                                {{ ($item['amount'] < 0 ? '-' : '+') . '$' . number_format(abs($item['amount']), 2) }}
                            </div>

                        </div>
                    @endforeach

                </x-card.content>
            </x-card>

        </div>
    </main>
@endsection
