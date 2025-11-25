@props(['name' => null])

@php
    $state = $name ? "openDialog_{$name}" : 'openDialog';
@endphp

<div x-on:click="{{ $state }} = true">
    {{ $slot }}
</div>
