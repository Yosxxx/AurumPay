@php
    $menu = [
        ['label' => 'Overview', 'icon' => 'home', 'href' => '/dashboard'],
        ['label' => 'Transfer', 'icon' => 'paper-airplane', 'href' => '/dashboard/transfer'],
        ['label' => 'Recipients', 'icon' => 'users', 'href' => '/recipients'],
        ['label' => 'QR Scan', 'icon' => 'qr-code', 'href' => '/qrscan'],
        ['label' => 'Activity', 'icon' => 'receipt-percent', 'href' => '/activity'],
        ['label' => 'Notifications', 'icon' => 'bell', 'href' => '/notifications'],
        ['label' => 'Profile', 'icon' => 'user', 'href' => '/profile'],
    ];
@endphp

<x-card class="fixed left-0 min-h-screen w-64 rounded-none border-l-0 border-t-0 border-b-0 flex flex-col">

    {{-- Header --}}
    <x-card.header class="flex h-16 flex-row items-center border-b-[0.5px]">
        <x-aurum-logo class="h-6 w-6 text-primary mr-5"/>
        <x-card.title>AurumPay</x-card.title>
    </x-card.header>

    {{-- Menu --}}
    <div class="flex-1 px-2 py-4 flex flex-col">
        @foreach ($menu as $item)
            @php
                $isActive = request()->is(ltrim($item['href'], '/'));
                $activeClass = $isActive
                    ? 'bg-primary/10 text-primary'
                    : 'text-muted-foreground hover:text-primary';
            @endphp

            <x-link
                href="{{ $item['href'] }}"
                class="rounded-md {{ $activeClass }} flex items-center gap-3 px-4 py-2 no-underline transition-colors"
            >
                <x-dynamic-component :component="'heroicon-o-' . $item['icon']" class="h-5 w-5"/>
                <span class="text-sm font-medium">{{ $item['label'] }}</span>
            </x-link>
        @endforeach
    </div>

    {{-- Footer (BOTTOM) --}}
    <x-card.footer class="mt-auto px-4 py-4 border-t-[0.5px]">
        
        <x-link href="#" class="text-muted-foreground no-underline transition hover:text-red-500 flex items-center">
            <x-heroicon-o-arrow-right-start-on-rectangle class="h-5 w-5 mr-2" />
            Signout
        </x-link>
    </x-card.footer>

</x-card>
