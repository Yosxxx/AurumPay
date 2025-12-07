<nav class="flex items-center justify-between p-4 border-b border-gray-800 bg-background text-white h-16">
    
    {{-- HAMBURGER BUTTON (Mobile Only) --}}
    {{-- This toggles the 'mobileMenuOpen' variable defined in App.blade.php --}}
    <button 
        @click="mobileMenuOpen = !mobileMenuOpen" 
        class="md:hidden p-2 -ml-2 rounded hover:bg-gray-800 focus:outline-none text-white"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>

    {{-- WELCOME TEXT --}}
    <div class="font-medium ml-auto">
        Welcome, {{ Auth::user()->name ?? 'User' }}!
    </div>
</nav>