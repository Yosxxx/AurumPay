@extends('layouts.app')

@section('content')
    <main class="space-y-5 p-10">

        <div class="mx-auto text-4xl font-bold">Transaction History</div>

        <x-card>
            {{-- Header --}}
            <x-card.header class="flex flex-row items-center justify-between">

                <div>
                    <x-card.title>All Transactions</x-card.title>
                    <x-card.description>
                        View and manage your transaction history.
                    </x-card.description>
                </div>

                {{-- Search bar --}}
                <div class="relative w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 10.5 18a7.5 7.5 0 0 0 6.15-3.35Z" />
                        </svg>
                    </span>

                    <x-input class="pl-10" placeholder="Search..." />
                </div>

            </x-card.header>

            {{-- TABLE --}}
            <x-card.content>

                <table class="w-full border-collapse text-left">

                    <thead class="border-b border-white/10 text-gray-300">
                        <tr class="border-b border-white/10">
                            <th class="py-3">Transaction ID</th>
                            <th class="py-3">Date</th>
                            <th class="py-3">Description</th>
                            <th class="py-3 text-right">Amount</th>
                        </tr>
                    </thead>

                    @foreach ($transactions as $tx)
                        <tr class="cursor-pointer border-b border-t border-white/10 transition hover:bg-white/5"
                            x-data="" x-on:click="$dispatch('open-transaction', {{ json_encode($tx) }})">
                            <td class="py-3">{{ $tx['id'] }}</td>
                            <td class="py-3">{{ $tx['date'] }}</td>
                            <td class="max-w-xs truncate py-3">{{ $tx['desc'] }}</td>
                            <td class="{{ $tx['amount'] < 0 ? 'text-red-400' : 'text-green-400' }} py-3 text-right">
                                {{ $tx['amount'] < 0 ? '-' : '+' }}${{ number_format(abs($tx['amount']), 2) }}
                            </td>
                        </tr>
                    @endforeach
                    {{-- Transaction Detail Dialog --}}
                    <div x-data="{show: false,item: {},}" x-on:open-transaction.window="item = $event.detail;show = true;" x-cloak>

                        {{-- Backdrop --}}
                        <div x-show="show" x-transition.opacity class="fixed inset-0 z-40 bg-black/70 backdrop-blur-sm"
                            x-on:click="show = false"></div>

                        {{-- Panel --}}
                        <div x-show="show" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
                            <div class="bg-card w-full max-w-md space-y-4 rounded-lg p-6 shadow-lg" x-on:click.stop>

                                {{-- Header --}}
                                <div class="flex items-center justify-between">
                                    <h2 class="text-lg font-semibold">Transaction Details</h2>
                                    <button x-on:click="show = false" class="text-gray-400 hover:text-gray-500">
                                        ✕
                                    </button>
                                </div>

                                <div class="space-y-2 text-sm">

                                    <div>
                                        <span class="text-gray-400">Transaction ID:</span>
                                        <div class="font-medium" x-text="item.id"></div>
                                    </div>

                                    <div>
                                        <span class="text-gray-400">Type:</span>
                                        <div class="font-medium capitalize" x-text="item.type"></div>
                                    </div>

                                    <div>
                                        <span class="text-gray-400">Date:</span>
                                        <div class="font-medium" x-text="item.date"></div>
                                    </div>

                                    <div>
                                        <span class="text-gray-400">Amount:</span>
                                        <div class="font-medium"
                                            :class="item.amount < 0 ? 'text-red-400' : 'text-green-400'"
                                            x-text="(item.amount < 0 ? '-' : '+') + '$' + Math.abs(item.amount).toFixed(2)">
                                        </div>
                                    </div>

                                    <div>
                                        <span class="text-gray-400">Description:</span>
                                        <div class="font-medium" x-text="item.desc"></div>
                                    </div>

                                    <div>
                                        <span class="text-gray-400">Notes:</span>
                                        <div class="wrap-break-word font-medium" x-text="item.notes"></div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>


                </table>




            </x-card.content>
        </x-card>
        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
    </main>
@endsection
