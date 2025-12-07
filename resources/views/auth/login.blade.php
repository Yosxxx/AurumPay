@extends('layouts.auth')

@section('content')
    {{-- 
        REMOVED: <div class="flex min-h-screen..."> 
        The layout already centers this, so we just need the Card.
    --}}
    
    <x-card class="w-full p-2">
        {{-- Header --}}
        <x-card.header class="text-center">
            <x-aurum-logo class="h-10 w-10 text-primary mx-auto" />
            <x-card.title class="text-2xl">Welcome back</x-card.title>
            <x-card.description>Enter your credentials to access your account</x-card.description>
        </x-card.header>

        <x-card.content>
            {{-- Form --}}
            <form id="login-form" action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <x-label>Email</x-label>
                    <x-input name="email" type="email" placeholder="someone@gmail.com" class="w-full"></x-input>
                </div>

                <div>
                    <x-label>Password</x-label>
                    <x-input name="password" type="password" placeholder="●●●●●●●●" class="w-full"></x-input>
                </div>
            </form>
        </x-card.content>

        <x-card.footer class="flex flex-col gap-y-5">
            {{-- Sign In --}}
            <x-button type="submit" form="login-form" class="w-full">Sign In</x-button>

            {{-- Sign Up --}}
            <x-card.description>Don't have an account? <x-link class="text-primary" href="{{ route('signup') }}">Sign up</x-link> </x-card.description>
        </x-card.footer>
    </x-card>
@endsection