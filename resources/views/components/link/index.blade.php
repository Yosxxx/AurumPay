{{-- <a {{ $attributes->twMerge('font-medium underline underline-offset-4') }}>{{ $slot }}</a> --}}

<a {{ $attributes->twMerge('font-medium underline underline-offset-4 hover:cursor-pointer') }}>{{ $slot }}</a>
