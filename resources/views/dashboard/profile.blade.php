@extends('layouts.app')

@section('content')
    <main class="space-y-5 p-10 mx-auto">

        <div class="text-4xl font-bold mx-auto">Account Settings</div>

        <x-card class="min-w-2xl">

            <x-card.header class="space-y-2">

                <x-card.title>Profile Information</x-card.title>
                <x-card.description>Update your personal account details.</x-card.description>

                {{-- Avatar initials --}}
                <div class="mx-auto w-fit rounded-full bg-primary/10 p-4 text-center">
                    <span class="text-primary text-2xl font-bold">JD</span>
                </div>

            </x-card.header>

            <x-card.content>
                <form action="#" method="POST" class="space-y-5">

                    {{-- Name Fields --}}
                    <div class="flex gap-x-5">
                        <div class="flex-1">
                            <x-label>First Name</x-label>
                            <x-input value="John" />
                        </div>

                        <div class="flex-1">
                            <x-label>Last Name</x-label>
                            <x-input value="Doe" />
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <x-label>Email</x-label>
                        <x-input type="email" value="john.doe@example.com" />
                    </div>

                    {{-- Old Password --}}
                    <div>
                        <x-label>Old Password</x-label>
                        <x-input type="password" placeholder="Enter your current password" />
                    </div>

                    {{-- New Password --}}
                    <div>
                        <x-label>New Password</x-label>
                        <x-input type="password" placeholder="Enter a new password" />
                    </div>

                    <x-button class="w-full">Save Changes</x-button>
                </form>
            </x-card.content>

        </x-card>
    </main>
@endsection
