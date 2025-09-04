<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex">
        <div class="hidden lg:flex w-1/2 bg-cover bg-center relative"
            style="background-image: url('{{ asset('images/bg-bengkulu.jpg') }}');">
            <div class="absolute inset-0 bg-blue-900 bg-opacity-75"></div>
            <div class="relative z-10 flex flex-col items-center justify-center w-full text-white p-10 text-center">
                <img src="{{ asset('images/logo-bkpsdm.png') }}" alt="Logo BKPSDM" class="w-28 h-28 mb-4">
                <h1 class="text-4xl font-bold mb-2 tracking-wide">SIMPEG</h1>
                <p class="text-xl font-light text-blue-200">Badan Kepegawaian & Pengembangan SDM<br>Kota Bengkulu</p>
            </div>
        </div>
        <div class="w-full lg:w-1/2">
            <div class="header">
                <div class="inner-header">
                    {{ $slot }}
                </div>
                <div>
                    <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                        <defs>
                            <path id="gentle-wave"
                                d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                        </defs>
                        <g class="parallax">
                            <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
                            <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                            <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                            <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
