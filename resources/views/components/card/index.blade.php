{{-- <div {{ $attributes->twMerge('rounded-xl border bg-card text-card-foreground shadow') }}>
    {{ $slot }}
</div> --}}

<div {{ $attributes->twMerge('rounded-xl border bg-card/50 text-card-foreground shadow border-white/10') }}>
    {{ $slot }}
</div>
