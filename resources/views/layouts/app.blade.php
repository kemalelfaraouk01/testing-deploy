<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="turbo-prefetch-hover-enabled" content="true">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    @php
        if (Auth::check()) {
            $notifications = auth()->user()->unreadNotifications()->take(5)->get();
        } else {
            $notifications = collect();
        }
    @endphp

    <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-50 flex">

        {{-- Include Sidebar Component --}}
        @include('layouts.sidebar')

        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 lg:hidden"
            style="display: none;"></div>

        {{-- Kontainer utama --}}
        <div class=" flex flex-col flex-1">
            @if (isset($header))
                <header id="main-header" class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <button @click.stop="sidebarOpen = !sidebarOpen"
                                    class="lg:hidden mr-4 text-gray-600 focus:outline-none">
                                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                </button>
                                {{ $header }}
                            </div>
                            <div class="flex items-center space-x-2">

                                <x-dropdown align="right" width="80">
                                    <x-slot name="trigger">
                                        <button
                                            class="relative inline-flex items-center p-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 bg-white hover:text-gray-800 focus:outline-none transition ease-in-out duration-150">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                            </svg>
                                            @if ($notifications->isNotEmpty())
                                                <span
                                                    class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                                            @endif
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <div class="px-4 py-2 font-bold border-b">Notifikasi</div>
                                        @forelse($notifications as $notification)
                                            @php
                                                $link = '#'; // Default link

                                                // Prioritaskan URL dari data notifikasi jika ada
                                                if (isset($notification->data['url'])) {
                                                    $link = $notification->data['url'];
                                                } 
                                                // Fallback untuk notifikasi lama
                                                elseif (isset($notification->data['pengajuan_id'])) {
                                                    $link = route('pengajuan-tpp.show', $notification->data['pengajuan_id']);
                                                } elseif (isset($notification->data['satyalancana_id'])) {
                                                    $link = route('satyalancana.berkas.show', $notification->data['satyalancana_id']);
                                                }
                                            @endphp

                                            <x-dropdown-link :href="$link"
                                                title="{{ $notification->data['message'] }}">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $notification->data['message'] }}
                                                </p>
                                                @if (isset($notification->data['catatan']))
                                                    <p class="text-xs text-red-600 mt-1" title="{{ $notification->data['catatan'] }}">
                                                        Catatan: {{ Str::limit($notification->data['catatan'], 50) }}
                                                    </p>
                                                @endif
                                                <p class="text-xs text-gray-500 mt-1">
                                                    {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                                </p>
                                            </x-dropdown-link>
                                        @empty
                                            <div class="px-4 py-3 text-sm text-center text-gray-500">Tidak ada
                                                notifikasi baru.</div>
                                        @endforelse
                                    </x-slot>
                                </x-dropdown>

                                <div class="flex items-center">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 bg-white hover:text-gray-800 focus:outline-none transition ease-in-out duration-150">
                                                <div class="flex items-center space-x-2">
                                                    <div><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                        </svg>
                                                    </div>
                                                    <div>{{ Auth::user()->name }}</div>
                                                </div>
                                                <div class="ms-1">
                                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profil Saya') }}</x-dropdown-link>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>
    </div>

    <x-success-toast />
    <x-error-modal />

</body>

</html>
