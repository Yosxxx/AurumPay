@props([
    'name' => null,
    'width' => 'max-w-md',
])

@php
    $state = $name ? "openDialog_{$name}" : 'openDialog';
@endphp

{{-- Backdrop --}}
<div
    x-show="{{ $state }}"
    x-transition.opacity
    class="fixed inset-0 bg-black/70 backdrop-blur-sm z-40"
    x-on:click="{{ $state }} = false"
    x-cloak
></div>

{{-- Panel --}}
<div
    x-show="{{ $state }}"
    x-transition
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    x-on:keydown.escape.window="{{ $state }} = false"
>
    <div
        class="w-full {{ $width }} bg-card rounded-lg shadow-lg p-6 space-y-4"
        x-on:click.stop
    >
        {{ $slot }}
    </div>
</div>
