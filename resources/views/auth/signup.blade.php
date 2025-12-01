@extends('layouts.auth')

@section('content')
    <div class="flex min-h-screen items-center justify-center">
        <x-card class="min-w-sm p-2">
            {{-- Header --}}
            <x-card.header class="text-center">
                <x-aurum-logo class="text-primary mx-auto h-10 w-10" />
                <x-card.title class="text-2xl">Create an account</x-card.title>
                <x-card.description>Join the future of premium banking</x-card.description>
            </x-card.header>

            <x-card.content>
                {{-- Form --}}
                <form id="signup-form" action="{{ route('signup.post') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="flex gap-x-5">
                        <div class="flex-1">
                            <x-label for="first_name">First Name</x-label>
                            <x-input id="first_name" name="first_name" type="text" placeholder="John"
                                autocomplete="given-name" />
                        </div>

                        <div class="flex-1">
                            <x-label for="last_name">Last Name</x-label>
                            <x-input id="last_name" name="last_name" type="text" placeholder="Doe"
                                autocomplete="family-name" />
                        </div>
                    </div>

                    <div>
                        <x-label for="email">Email</x-label>
                        <x-input id="email" name="email" type="email" placeholder="someone@gmail.com"
                            autocomplete="email" autocapitalize="none" />
                    </div>

                    <div>
                        <x-label for="password">Password</x-label>
                        <x-input id="password" name="password" type="password" placeholder="••••••••"
                            autocomplete="new-password" />
                    </div>

                    <div>
                        <x-label for="password_confirmation">Confirm Password</x-label>
                        <x-input id="password_confirmation" name="password_confirmation" type="password"
                            placeholder="••••••••" autocomplete="new-password" />
                    </div>

                    <div>
                        <x-label for="pin">Create PIN (6 digits)</x-label>
                        <x-input id="pin" name="pin" type="password" inputmode="numeric" pattern="\d*"
                            maxlength="6" placeholder="••••••" autocomplete="new-password" />
                    </div>

                    <div>
                        <x-label for="pin_confirmation">Confirm PIN</x-label>
                        <x-input id="pin_confirmation" name="pin_confirmation" type="password" inputmode="numeric"
                            pattern="\d*" maxlength="6" placeholder="••••••" autocomplete="new-password" />
                    </div>
                </form>

            </x-card.content>

            <x-card.footer class="flex flex-col gap-y-5">
                {{-- Sign In --}}
                <x-button type="submit" form="signup-form" class="w-full">Create Account</x-button>

                {{-- Sign Up --}}
                <x-card.description>Already have an account? <x-link class="text-primary" href="login">Sign in</x-link>
                </x-card.description>
            </x-card.footer>
        </x-card>
    </div>
@endsection
