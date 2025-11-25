{{-- @props([
    'variant' => null,
    'size' => null,
    'type' => 'button',
])

@inject('button', 'App\Services\ButtonCvaService')

<button
    type="{{ $type }}"
    {{ $attributes->twMerge($button(['variant' => $variant, 'size' => $size])) }}
>
    {{ $slot }}
</button> --}}

@props([
    'variant' => 'default',
    'size' => 'default',
    'type' => 'button',
])

@php
$variantClass = match ($variant) {
    'secondary'   => 'btn-secondary',
    'destructive' => 'btn-destructive',
    'outline'     => 'btn-outline',
    'ghost'       => 'btn-ghost',
    'link'        => 'btn-link',
    default       => 'btn-default',
};

$sizeClass = match ($size) {
    'sm'        => 'btn-sm',
    'lg'        => 'btn-lg',
    'icon'      => 'btn-icon',
    'icon-sm'   => 'btn-icon-sm',
    'icon-lg'   => 'btn-icon-lg',
    default     => 'btn-default-size',
};
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->twMerge("btn $variantClass $sizeClass hover:cursor-pointer") }}
>
    {{ $slot }}
</button>
