<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Welcome to AurumPay</title>
</head>
<body class="bg-black text-white min-h-screen flex flex-col items-center justify-center p-4 text-center">
    
    {{-- LOGO / BRAND --}}
    <div class="mb-8 animate-bounce">
        <div class="h-20 w-20 bg-yellow-500 rounded-full flex items-center justify-center mx-auto shadow-lg shadow-yellow-500/50">
            <span class="text-4xl font-bold text-black">$</span>
        </div>
    </div>

    {{-- HEADLINE (Responsive Text) --}}
    <h1 class="text-4xl md:text-6xl font-bold mb-4 tracking-tight">
        Aurum<span class="text-yellow-500">Pay</span>
    </h1>
    
    <p class="text-gray-400 text-lg md:text-xl max-w-md mb-8">
        The gold standard in secure digital payments. Send, receive, and manage your money effortlessly.
    </p>

    {{-- ACTION BUTTONS --}}
    <div class="flex flex-col md:flex-row gap-4 w-full max-w-sm">
        <a href="{{ route('login') }}" class="w-full bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-3 px-6 rounded-lg transition transform hover:scale-105 text-center">
            Log In
        </a>
        
        <a href="{{ route('signup') }}" class="w-full bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg border border-gray-700 transition transform hover:scale-105 text-center">
            Create Account
        </a>
    </div>

</body>
</html>