@props([
    'open' => false,
    'name' => null, // allow unique names when multiple dialogs exist
])

@php
    $state = $name ? "openDialog_{$name}" : 'openDialog';
@endphp

<div x-data="{ {{ $state }}: @js($open) }" x-cloak>
    {{ $slot }}
</div>
