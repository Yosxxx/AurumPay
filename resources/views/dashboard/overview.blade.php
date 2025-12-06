@extends('layouts.app')

@section('content')
    <main class="p-10">

        {{-- Error Handling --}}
        @if ($errors->any())
            <div class="mb-5 rounded-md bg-red-500/10 border border-red-500/20 p-4 text-red-500">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-5 rounded-md bg-green-500/10 border border-green-500/20 p-4 text-green-500">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-10">

            {{-- Balance Card --}}
            <x-card class="bg-linear-to-br from-primary/20 via-background to-background border-primary/20 space-y-5 p-10">
                <div class="text-muted-foreground text-xs font-bold">Total Balance</div>

                <div>
                    <div class="text-4xl font-bold">${{ number_format(auth()->user()->balance, 2) }}</div>
                    <div class="text-muted-foreground text-xs font-bold">Available for transfer</div>
                </div>
                
                <div class="text-right">
                    <div class="text-[10px] text-muted-foreground uppercase font-bold">Account No.</div>
                    <div class="font-mono text-lg font-medium text-primary tracking-widest">
                         {{ auth()->user()->account_number }}
                    </div>
                </div>
                
                <div class="flex gap-x-2">
                    <a href="{{ url('/dashboard/transfer') }}">
                        <x-button>
                            <x-heroicon-o-paper-airplane class="mr-2 h-5 w-5" />
                            Transfer
                        </x-button>
                    </a>

                    {{-- DEPOSIT DIALOG --}}
                    <x-dialog-custom.dialog name="deposit">
                        <x-dialog-custom.dialog-trigger name="deposit">
                            <x-button variant="outline">
                                <x-heroicon-o-arrow-down-tray class="mr-2 h-5 w-5" />
                                Deposit
                            </x-button>
                        </x-dialog-custom.dialog-trigger>

                        <x-dialog-custom.dialog-content name="deposit">
                            <x-dialog-custom.dialog-header title="Deposit Funds" name="deposit" />
                            
                            <form action="{{ route('funds.update') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="type" value="deposit">
                                
                                <div class="space-y-2 text-sm">
                                    <x-label>Deposit Amount</x-label>
                                    <x-input name="amount" type="number" step="0.01" min="1" placeholder="$0.00" required />
                                </div>

                                <div class="mt-4 flex justify-end gap-2">
                                    <x-button type="button" variant="outline" x-on:click="openDialog_deposit = false">Cancel</x-button>
                                    <x-button type="submit">Deposit</x-button>
                                </div>
                            </form>
                        </x-dialog-custom.dialog-content>
                    </x-dialog-custom.dialog>

                    {{-- WITHDRAW DIALOG --}}
                    <x-dialog-custom.dialog name="withdraw">
                        
                        <x-dialog-custom.dialog-trigger name="withdraw">
                            <x-button variant="outline">
                                <x-heroicon-o-banknotes class="mr-2 h-5 w-5" />
                                Withdraw
                            </x-button>
                        </x-dialog-custom.dialog-trigger>

                        <x-dialog-custom.dialog-content name="withdraw">
                            <x-dialog-custom.dialog-header title="Withdraw Funds" name="withdraw" />

                            <form action="{{ route('funds.update') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="type" value="withdraw">

                                <div class="space-y-2 text-sm">
                                    <x-label>Withdraw Amount</x-label>
                                    <x-input name="amount" type="number" step="0.01" min="1" placeholder="$0.00" required />
                                </div>

                                <div class="mt-4 flex justify-end gap-2">
                                    <x-button type="button" variant="outline" x-on:click="openDialog_withdraw = false">Cancel</x-button>
                                    <x-button type="submit">Withdraw</x-button>
                                </div>
                            </form>
                        </x-dialog-custom.dialog-content>
                    </x-dialog-custom.dialog>

                    <a href="{{ route('dashboard.qrscan') }}">
                        <x-button variant="outline">
                            <x-heroicon-o-qr-code class="mr-2 h-5 w-5" />
                            Scan QR
                        </x-button>
                    </a>
                </div>
            </x-card>

            {{-- Recent Activity --}}
            <x-card>
                <x-card.header>
                    <x-card.title>Recent Activity</x-card.title>
                    <x-card.description>Your last 5 transactions</x-card.description>
                </x-card.header>

                <x-card.content class="space-y-4">
                    @if($recent->isEmpty())
                        <div class="text-center text-gray-500 py-4">No transactions yet.</div>
                    @endif

                    @foreach ($recent as $item)
                        <div class="flex items-center border-b border-white/5 pb-2 last:border-0 last:pb-0">
                            {{-- Icon --}}
                            <div class="mr-4 rounded-full bg-white/5 p-2">
                                @if ($item->type === 'withdraw')
                                    <x-heroicon-o-arrow-up-right class="h-5 w-5 text-red-500" />
                                @elseif ($item->type === 'deposit')
                                    <x-heroicon-o-arrow-down-left class="h-5 w-5 text-green-500" />
                                @elseif ($item->type === 'transfer')
                                    @if ($item->amount < 0)
                                        <x-heroicon-o-paper-airplane class="h-5 w-5 text-red-500" />
                                    @else
                                        <x-heroicon-o-arrow-down-left class="h-5 w-5 text-green-500" />
                                    @endif
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="flex-1">
                                <div class="font-semibold">{{ $item->description }}</div>
                                <div class="text-muted-foreground text-xs">{{ $item->created_at->timezone('Asia/Jakarta')->format('M d, Y • h:i A') }}</div>
                            </div>

                            {{-- Amount --}}
                            <div class="{{ $item->amount < 0 ? 'text-red-500' : 'text-green-500' }} font-bold font-mono">
                                {{ ($item->amount < 0 ? '-' : '+') . '$' . number_format(abs($item->amount), 2) }}
                            </div>
                        </div>
                    @endforeach

                </x-card.content>
            </x-card>

        </div>
    </main>
@endsection