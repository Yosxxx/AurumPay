@extends('layouts.app')

@section('content')
    <main class="mx-auto space-y-5 p-10">

        <div class="mx-auto text-4xl font-bold">Transfer Money</div>

        @php
            $tab = request('tab', 'scan');
        @endphp

        <div class="flex justify-center space-x-4">

            <x-link href="?tab=scan"
                class="{{ $tab === 'scan' ? 'bg-card text-white' : 'text-gray-400' }} flex-1 rounded-md px-5 py-2 text-center text-sm font-medium no-underline">
                Scan QR
            </x-link>

            <x-link href="?tab=my"
                class="{{ $tab === 'my' ? 'bg-card text-white' : 'text-gray-400' }} flex-1 rounded-md px-5 py-2 text-center text-sm font-medium no-underline">
                My QR
            </x-link>

        </div>

        {{-- CARD CONTAINER --}}
        <x-card class="min-w-2xl mt-2">

            @if ($tab === 'scan')
                <x-card.content class="flex flex-col items-center space-y-4 py-10">
                    <video id="cameraPreview" autoplay playsinline
                        class="h-[260px] w-[260px] rounded-xl bg-black object-cover"></video>

                    <button id="toggleCamera" class="rounded-md bg-yellow-600 px-4 py-2 text-sm font-medium text-white">
                        Enable Camera
                    </button>

                    <div class="text-sm text-gray-400">
                        Allow camera permission to scan QR codes
                    </div>

                </x-card.content>
            @endif

            @if ($tab === 'my')
                <x-card.content class="flex flex-col items-center py-10">
                    <div class="bg-white p-4 rounded-xl">
                        {{-- Generates the Account Number --}}
                        {!! QrCode::size(200)->generate(auth()->user()->account_number) !!}
                    </div>
                    <div class="mt-4 font-mono font-bold text-lg">
                        {{ auth()->user()->account_number }}
                    </div>
                    <div class="mt-4 text-sm text-gray-400">
                        Share this QR to receive money
                    </div>
                </x-card.content>
            @endif

        </x-card>

        <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const video = document.getElementById("cameraPreview");
                const toggleBtn = document.getElementById("toggleCamera");
                
                let stream = null;
                let isCameraOn = false;
                let animationFrameId = null;

                // Create a hidden canvas for processing frames
                const canvas = document.createElement("canvas");
                const ctx = canvas.getContext("2d");

                async function startCamera() {
                    try {
                        stream = await navigator.mediaDevices.getUserMedia({
                            video: { facingMode: "environment" }
                        });
                        video.srcObject = stream;
                        video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
                        video.play();
                        
                        isCameraOn = true;
                        toggleBtn.textContent = "Disable Camera";
                        
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
