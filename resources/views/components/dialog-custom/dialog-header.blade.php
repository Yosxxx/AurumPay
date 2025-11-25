@props([
    'title' => null,
    'name' => null,
])

@php
    $state = $name ? "openDialog_{$name}" : 'openDialog';
@endphp

<div class="flex justify-between items-center">
    <h2 class="text-lg font-semibold">{{ $title }}</h2>

    <button x-on:click="{{ $state }} = false" class="text-gray-400 hover:text-gray-500">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke-width="1.5"
             stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</div>
