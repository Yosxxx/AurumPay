@extends('layouts.app')

@section('content')
    <main class="space-y-5 p-4 md:p-10">

        <div class="mx-auto text-2xl md:text-4xl font-bold">Transaction History</div>

        <x-card>
            {{-- Header & Search --}}
            <x-card.header class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <x-card.title>All Transactions</x-card.title>
                    <x-card.description>
                        View and manage your transaction history.
                    </x-card.description>
                </div>

                <div class="relative w-full md:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 10.5 18a7.5 7.5 0 0 0 6.15-3.35Z" />
                        </svg>
                    </span>
                    <x-input class="pl-10 w-full" placeholder="Search..." />
                </div>
            </x-card.header>

            <x-card.content class="p-0">
                
                {{-- MOBILE VIEW (Vertical List) --}}
                <div class="md:hidden">
                    @foreach ($transactions as $tx)
                        <div class="flex items-center justify-between border-b border-white/10 p-4 active:bg-white/5"
                             x-data="" x-on:click="$dispatch('open-transaction', {{ json_encode($tx) }})">
                            
                            {{-- Left Side: Icon + Details --}}
                            <div class="flex items-center gap-3">
                                {{-- Icon --}}
                                <div class="rounded-full bg-white/5 p-2 text-white">
                                    @if ($tx->amount < 0)
                                        <x-heroicon-o-arrow-up-right class="h-5 w-5 text-red-500" />
                                    @else
                                        <x-heroicon-o-arrow-down-left class="h-5 w-5 text-green-500" />
                                    @endif
                                </div>

                                {{-- Text Info --}}
                                <div>
                                    <div class="font-bold text-sm text-white">{{ Str::limit($tx->description, 20) }}</div>
                                    {{-- Removed Transaction ID from here --}}
                                    <div class="text-xs text-gray-400">
                                        {{ $tx->created_at->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>

                            {{-- Right Side: Amount --}}
                            <div class="text-right">
                                <div class="font-bold font-mono text-sm {{ $tx->amount < 0 ? 'text-red-400' : 'text-green-400' }}">
                                    {{ $tx->amount < 0 ? '-' : '+' }}${{ number_format(abs($tx->amount), 2) }}
                                </div>
                                <div class="text-[10px] uppercase text-gray-500">{{ $tx->type }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- DESKTOP VIEW (Classic Table) --}}
                <div class="hidden md:block">
                    <table class="w-full border-collapse text-left">
                        <thead class="border-b border-white/10 text-gray-300">
                            <tr class="border-b border-white/10">
                                {{-- Removed Transaction ID Header --}}
                                <th class="py-3 px-4">Date</th>
                                <th class="py-3 px-4">Description</th>
                                <th class="py-3 px-4 text-right">Amount</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($transactions as $tx)
                                <tr class="group cursor-pointer border-b border-t border-white/10 transition hover:bg-white/5"
                                    x-data="" x-on:click="$dispatch('open-transaction', {{ json_encode($tx) }})">

                                    {{-- Removed Transaction ID Column --}}

                                    <td class="text-muted-foreground py-3 px-4 group-hover:text-white">
                                        {{ $tx->created_at->format('M d, Y') }}
                                    </td>

                                    <td class="text-muted-foreground max-w-xs truncate py-3 px-4 group-hover:text-white">
                                        {{ $tx->description }}
                                    </td>

                                    <td class="{{ $tx->amount < 0 ? 'text-red-400' : 'text-green-400' }} py-3 px-4 text-right group-hover:text-white">
                                        {{ $tx->amount < 0 ? '-' : '+' }}${{ number_format(abs($tx->amount), 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Transaction Detail Modal --}}
                <div x-data="{ show: false, item: {}, }" x-on:open-transaction.window="item = $event.detail;show = true;" x-cloak>
                    <div x-show="show" x-transition.opacity class="fixed inset-0 z-40 bg-black/70 backdrop-blur-sm"
                        x-on:click="show = false"></div>

                    <div x-show="show" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
                        <div class="bg-card w-full max-w-md space-y-4 rounded-lg p-6 shadow-lg" x-on:click.stop>

                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold">Transaction Details</h2>
                                <button x-on:click="show = false" class="text-gray-400 hover:text-gray-500">✕</button>
                            </div>

                            <div class="space-y-3 text-sm">
                                {{-- Removed Transaction ID Row from here too --}}

                                <div class="flex justify-between border-b border-white/10 pb-2">
                                    <span class="text-gray-400">Date</span>
                                    <div class="font-medium" x-text="new Date(item.created_at).toLocaleDateString()"></div>
                                </div>

                                <div class="flex justify-between border-b border-white/10 pb-2">
                                    <span class="text-gray-400">Type</span>
                                    <div class="font-medium capitalize" x-text="item.type"></div>
                                </div>

                                <div class="flex justify-between border-b border-white/10 pb-2">
                                    <span class="text-gray-400">Amount</span>
                                    <div class="font-mono font-bold"
                                        :class="item.amount < 0 ? 'text-red-400' : 'text-green-400'"
                                        x-text="(item.amount < 0 ? '-' : '+') + '$' + Math.abs(item.amount).toFixed(2)">
                                    </div>
                                </div>

                                <div>
                                    <span class="text-gray-400 block mb-1">Description</span>
                                    <div class="font-medium bg-white/5 p-2 rounded" x-text="item.description"></div>
                                </div>

                                <div>
                                    <span class="text-gray-400 block mb-1">Notes</span>
                                    <div class="font-medium text-gray-300" x-text="item.notes || '-'"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </x-card.content>
        </x-card>
        
        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
    </main>
@endsection