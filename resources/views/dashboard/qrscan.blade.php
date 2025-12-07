@extends('layouts.app')

@section('content')
    {{-- RESPONSIVE FIX: p-4 on mobile, p-10 on desktop. Center items. --}}
    <main class="mx-auto space-y-5 p-4 md:p-10 w-full flex flex-col items-center">

        {{-- RESPONSIVE FIX: Smaller text on mobile --}}
        <div class="mx-auto text-2xl md:text-4xl font-bold">Transfer Money</div>

        @php
            $tab = request('tab', 'scan');
        @endphp

        {{-- Tabs --}}
        <div class="flex justify-center space-x-4 w-full max-w-md">
            <x-link href="?tab=scan"
                class="{{ $tab === 'scan' ? 'bg-card text-white' : 'text-gray-400' }} flex-1 rounded-md px-5 py-2 text-center text-sm font-medium no-underline transition-colors hover:text-white">
                Scan QR
            </x-link>

            <x-link href="?tab=my"
                class="{{ $tab === 'my' ? 'bg-card text-white' : 'text-gray-400' }} flex-1 rounded-md px-5 py-2 text-center text-sm font-medium no-underline transition-colors hover:text-white">
                My QR
            </x-link>
        </div>

        {{-- 
            RESPONSIVE CARD CONTAINER 
            w-full: Full width on mobile
            max-w-2xl: Fixed width on desktop
        --}}
        <x-card class="w-full max-w-md mt-2">

            @if ($tab === 'scan')
                <x-card.content class="flex flex-col items-center space-y-4 py-10">
                    {{-- Camera Preview --}}
                    <div class="relative overflow-hidden rounded-xl bg-black shadow-lg">
                        <video id="cameraPreview" autoplay playsinline
                            class="h-[260px] w-[260px] object-cover"></video>
                        {{-- Scanning Line Animation (Optional visual flair) --}}
                        <div class="absolute inset-0 border-2 border-yellow-500/50 rounded-xl pointer-events-none"></div>
                    </div>

                    <button id="toggleCamera" class="rounded-md bg-yellow-600 hover:bg-yellow-500 transition px-6 py-2 text-sm font-bold text-black">
                        Enable Camera
                    </button>

                    <div class="text-sm text-gray-400 text-center px-4">
                        Allow camera permission to scan QR codes
                    </div>
                </x-card.content>
            @endif

            @if ($tab === 'my')
                <x-card.content class="flex flex-col items-center py-10 text-center">
                    <div class="bg-white p-4 rounded-xl shadow-inner">
                        {{-- Generates the Account Number --}}
                        {!! QrCode::size(200)->generate(auth()->user()->account_number) !!}
                    </div>
                    
                    <div class="mt-6">
                        <div class="text-xs text-gray-500 uppercase font-bold tracking-widest mb-1">Your Account Number</div>
                        <div class="font-mono font-bold text-2xl text-yellow-500 tracking-wider">
                            {{ auth()->user()->account_number }}
                        </div>
                    </div>
                    
                    <div class="mt-2 text-sm text-gray-400">
                        Share this QR to receive money instantly.
                    </div>
                </x-card.content>
            @endif

        </x-card>

        <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const video = document.getElementById("cameraPreview");
                const toggleBtn = document.getElementById("toggleCamera");
                
                // Only run script if elements exist (in case user is on 'My QR' tab)
                if(!video || !toggleBtn) return;

                let stream = null;
                let isCameraOn = false;
                let animationFrameId = null;

                const canvas = document.createElement("canvas");
                const ctx = canvas.getContext("2d");

                async function startCamera() {
                    try {
                        stream = await navigator.mediaDevices.getUserMedia({
                            video: { facingMode: "environment" }
                        });
                        video.srcObject = stream;
                        video.setAttribute("playsinline", true);
                        video.play();
                        
                        isCameraOn = true;
                        toggleBtn.textContent = "Disable Camera";
                        toggleBtn.classList.replace("bg-yellow-600", "bg-red-600"); // Visual feedback
                        
                        requestAnimationFrame(tick);
                    } catch (err) {
                        alert("Camera access denied or unavailable.");
                        console.error(err);
                    }
                }

                function tick() {
                    if (!isCameraOn || !video) return;

                    if (video.readyState === video.HAVE_ENOUGH_DATA) {
                        canvas.height = video.videoHeight;
                        canvas.width = video.videoWidth;
                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                        
                        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                        const code = jsQR(imageData.data, imageData.width, imageData.height, {
                            inversionAttempts: "dontInvert",
                        });

                        if (code) {
                            console.log("Found QR code", code.data);
                            stopCamera();
                            // Redirect to transfer page with account number filled
                            window.location.href = `/dashboard/transfer?account_number=${encodeURIComponent(code.data)}`;
                            return;
                        }
                    }
                    animationFrameId = requestAnimationFrame(tick);
                }

                function stopCamera() {
                    if (stream) {
                        stream.getTracks().forEach(track => track.stop());
                    }
                    if (animationFrameId) {
                        cancelAnimationFrame(animationFrameId);
                    }
                    video.srcObject = null;
                    isCameraOn = false;
                    toggleBtn.textContent = "Enable Camera";
                    toggleBtn.classList.replace("bg-red-600", "bg-yellow-600");
                }

                toggleBtn.addEventListener("click", () => {
                    if (isCameraOn) {
                        stopCamera();
                    } else {
                        startCamera();
                    }
                });
            });
        </script>

    </main>
@endsection