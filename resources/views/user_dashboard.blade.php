<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Pegawai') }}
            </h2>

        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Welcome Card --}}
            <div class="bg-gradient-to-r from-indigo-500 to-blue-600 overflow-hidden shadow-lg rounded-xl mb-6 text-white"
                style="background: linear-gradient(to right, rgb(99 102 241), rgb(37 99 235));">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h3 class="text-base sm:text-lg font-medium">Selamat Datang Kembali!</h3>
                            <p class="text-lg sm:text-xl font-bold mt-1">{{ Auth::user()->name }}</p>
                            <p class="text-xs sm:text-sm text-indigo-100 mt-2">Dashboard Pegawai - Sistem Informasi
                                Layanan Terintegerasi Kota Bengkulu</p>
                        </div>
                        <div class="hidden sm:block">
                            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (isset($tugasSatyalancana) && $tugasSatyalancana)
                <div class="mb-6">
                    <div class="bg-gradient-to-r from-orange-50 to-amber-50 border border-orange-200 rounded-xl p-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 p-3 bg-orange-100 rounded-full">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-orange-800">Tugas: Lengkapi Berkas Satyalancana
                                </h3>
                                <p class="mt-1 text-sm text-orange-700">
                                    Anda telah diusulkan untuk menerima penghargaan
                                    <strong>{{ $tugasSatyalancana->jenis_penghargaan }}</strong>. Mohon segera lengkapi
                                    berkas yang diperlukan.
                                </p>
                                <div class="mt-4">
                                    <a href="{{ route('berkas-satyalancana.create', $tugasSatyalancana->id) }}"
                                        class="inline-flex items-center px-4 py-2 bg-orange-600 text-white text-sm font-semibold rounded-lg hover:bg-orange-700">
                                        Lengkapi Berkas Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Quick Stats Cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
                {{-- Card Sisa Cuti --}}
                <div
                    class="bg-white overflow-hidden shadow-md hover:shadow-lg rounded-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-3 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <div
                                class="bg-green-500 p-2 sm:p-3 rounded-full text-white mb-2 sm:mb-0 sm:mr-4 self-center sm:self-auto">
                                <svg class="w-4 h-4 sm:w-6 sm:h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                            </div>
                            <div class="text-center sm:text-left">
                                <p class="text-xs sm:text-sm text-gray-500">Sisa Cuti</p>
                                <p class="text-lg sm:text-2xl font-bold text-gray-900">12</p>
                                <p class="text-xs text-gray-400">Hari</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Cuti Digunakan --}}
                <div
                    class="bg-white overflow-hidden shadow-md hover:shadow-lg rounded-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-3 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <div
                                class="bg-orange-500 p-2 sm:p-3 rounded-full text-white mb-2 sm:mb-0 sm:mr-4 self-center sm:self-auto">
                                <svg class="w-4 h-4 sm:w-6 sm:h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div class="text-center sm:text-left">
                                <p class="text-xs sm:text-sm text-gray-500">Cuti Digunakan</p>
                                <p class="text-lg sm:text-2xl font-bold text-gray-900">3</p>
                                <p class="text-xs text-gray-400">Hari</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Pengajuan Pending --}}
                <div
                    class="bg-white overflow-hidden shadow-md hover:shadow-lg rounded-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-3 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <div
                                class="bg-yellow-500 p-2 sm:p-3 rounded-full text-white mb-2 sm:mb-0 sm:mr-4 self-center sm:self-auto">
                                <svg class="w-4 h-4 sm:w-6 sm:h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                </svg>
                            </div>
                            <div class="text-center sm:text-left">
                                <p class="text-xs sm:text-sm text-gray-500">Pengajuan Pending</p>
                                <p class="text-lg sm:text-2xl font-bold text-gray-900">1</p>
                                <p class="text-xs text-gray-400">Item</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Status Aktif --}}
                <div
                    class="bg-white overflow-hidden shadow-md hover:shadow-lg rounded-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-3 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <div
                                class="bg-indigo-500 p-2 sm:p-3 rounded-full text-white mb-2 sm:mb-0 sm:mr-4 self-center sm:self-auto">
                                <svg class="w-4 h-4 sm:w-6 sm:h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div class="text-center sm:text-left">
                                <p class="text-xs sm:text-sm text-gray-500">Status</p>
                                <p class="text-lg sm:text-2xl font-bold text-gray-900">Aktif</p>
                                <p class="text-xs text-green-500">Online</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Content Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
                {{-- Left Column: Menu Cards --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Menu Utama --}}
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl">
                        <div class="p-4 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Menu Utama</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                {{-- Profil Saya --}}
                                <a href="{{ route('profile.edit') }}"
                                    class="group p-4 border border-gray-200 rounded-lg hover:border-indigo-300 hover:shadow-md transition-all duration-200">
                                    <div class="flex items-center">
                                        <div
                                            class="p-3 bg-indigo-100 group-hover:bg-indigo-200 rounded-lg transition-colors duration-200">
                                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h4
                                                class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200">
                                                Profil Saya</h4>
                                            <p class="text-xs text-gray-500 mt-1">Kelola data pribadi</p>
                                        </div>
                                    </div>
                                </a>

                                {{-- Pengajuan Cuti --}}
                                <a href="{{ route('cuti.index') }}"
                                    class="group p-4 border border-gray-200 rounded-lg hover:border-green-300 hover:shadow-md transition-all duration-200">
                                    <div class="flex items-center">
                                        <div
                                            class="p-3 bg-green-100 group-hover:bg-green-200 rounded-lg transition-colors duration-200">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h4
                                                class="text-sm font-semibold text-gray-900 group-hover:text-green-600 transition-colors duration-200">
                                                Pengajuan Cuti</h4>
                                            <p class="text-xs text-gray-500 mt-1">Ajukan & lihat riwayat cuti</p>
                                        </div>
                                    </div>
                                </a>

                                @role('Pengelola')
                                    {{-- Pengajuan TPP --}}
                                    <a href="{{ route('pengajuan-tpp.index') }}"
                                        class="group p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:shadow-md transition-all duration-200">
                                        <div class="flex items-center">
                                            <div
                                                class="p-3 bg-blue-100 group-hover:bg-blue-200 rounded-lg transition-colors duration-200">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <h4
                                                    class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                                    Pengajuan TPP</h4>
                                                <p class="text-xs text-gray-500 mt-1">Ajukan TPP bulanan</p>
                                            </div>
                                        </div>
                                    </a>
                                @endrole

                                {{-- Dokumen Saya --}}
                                <a href="#"
                                    class="group p-4 border border-gray-200 rounded-lg hover:border-purple-300 hover:shadow-md transition-all duration-200">
                                    <div class="flex items-center">
                                        <div
                                            class="p-3 bg-purple-100 group-hover:bg-purple-200 rounded-lg transition-colors duration-200">
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h4
                                                class="text-sm font-semibold text-gray-900 group-hover:text-purple-600 transition-colors duration-200">
                                                Dokumen Saya</h4>
                                            <p class="text-xs text-gray-500 mt-1">Kelola berkas dokumen</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Kartu Aktivitas Terbaru --}}
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-xl shadow-gray-900/5 hover:shadow-2xl hover:shadow-gray-900/10 transition-all duration-500">
                        <div class="p-8">
                            <!-- Modern Header with Glassmorphism -->
                            <div class="flex items-center justify-between mb-8">
                                <div class="space-y-2">
                                    <h3
                                        class="text-2xl font-bold bg-gradient-to-r from-gray-900 via-gray-800 to-gray-700 bg-clip-text text-transparent">
                                        Aktivitas Terbaru
                                    </h3>
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="w-16 h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-full">
                                        </div>
                                        <div
                                            class="w-2 h-1 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full opacity-60">
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="bg-gradient-to-r from-blue-50 to-purple-50 border border-blue-200/30 px-4 py-2 rounded-full">
                                    <span
                                        class="text-sm font-semibold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                        {{ count($activities) }} items
                                    </span>
                                </div>
                            </div>

                            <!-- Modern Activity List -->
                            <div class="space-y-4">
                                @forelse($activities as $log)
                                    <div class="group relative">
                                        <!-- Background with subtle animation -->
                                        <div
                                            class="absolute inset-0 bg-gradient-to-r from-transparent via-blue-50/30 to-purple-50/30 rounded-2xl opacity-0 group-hover:opacity-100 transition-all duration-500 transform group-hover:scale-105">
                                        </div>

                                        <!-- Content -->
                                        <div
                                            class="relative flex items-center space-x-4 p-5 rounded-2xl border border-transparent group-hover:border-gray-200/50 transition-all duration-300">
                                            <!-- Modern Status Indicator -->
                                            <div class="relative">
                                                <div
                                                    class="w-4 h-4 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full shadow-lg group-hover:shadow-xl group-hover:shadow-blue-500/25 transition-all duration-300">
                                                </div>
                                                <div
                                                    class="absolute inset-0 w-4 h-4 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full animate-ping opacity-20">
                                                </div>
                                            </div>

                                            <!-- Content Area -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-start justify-between gap-4">
                                                    <div class="flex-1">
                                                        <p
                                                            class="text-gray-900 font-semibold text-sm group-hover:text-gray-800 transition-colors">
                                                            @php
                                                                $activityText = '';
                                                                if (
                                                                    $log->subject_type == 'App\Models\Cuti' &&
                                                                    $log->activity == 'created'
                                                                ) {
                                                                    $activityText = 'Mengajukan cuti baru';
                                                                } elseif (
                                                                    $log->subject_type == 'App\Models\User' &&
                                                                    $log->activity == 'updated'
                                                                ) {
                                                                    $activityText = 'Memperbarui profil';
                                                                } else {
                                                                    $activityText = "Melakukan aksi '{$log->activity}'";
                                                                }
                                                            @endphp
                                                            {{ $activityText }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 mt-1 font-medium">
                                                            {{ $log->created_at->diffForHumans() }}
                                                        </p>
                                                    </div>

                                                    <!-- Modern Time Badge -->
                                                    <div
                                                        class="bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200/50 px-3 py-1.5 rounded-full group-hover:from-blue-50 group-hover:to-purple-50 group-hover:border-blue-200/30 transition-all duration-300">
                                                        <span
                                                            class="text-xs font-bold text-gray-600 group-hover:bg-gradient-to-r group-hover:from-blue-600 group-hover:to-purple-600 group-hover:bg-clip-text group-hover:text-transparent">
                                                            {{ $log->created_at->format('H:i') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-16">
                                        <!-- Modern Empty State -->
                                        <div class="relative mx-auto w-20 h-20 mb-6">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-r from-blue-100 to-purple-100 rounded-2xl rotate-6">
                                            </div>
                                            <div
                                                class="relative bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl w-full h-full flex items-center justify-center border border-gray-200/50">
                                                <svg class="w-8 h-8 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Belum ada aktivitas</h4>
                                        <p class="text-sm text-gray-500 max-w-sm mx-auto">Aktivitas terbaru Anda akan
                                            muncul di sini</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Info Panel --}}
                <div class="space-y-6">
                    {{-- Informasi Penting --}}
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl">
                        <div class="p-4 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Penting</h3>
                            <div class="space-y-3">
                                <div class="p-3 bg-blue-50 border-l-4 border-blue-400 rounded">
                                    <p class="text-sm text-blue-700 font-medium">Pengumuman</p>
                                    <p class="text-xs text-blue-600 mt-1">Jadwal evaluasi kinerja bulan depan</p>
                                </div>

                                <div class="p-3 bg-yellow-50 border-l-4 border-yellow-400 rounded">
                                    <p class="text-sm text-yellow-700 font-medium">Reminder</p>
                                    <p class="text-xs text-yellow-600 mt-1">Jangan lupa update data keluarga</p>
                                </div>

                                <div class="p-3 bg-green-50 border-l-4 border-green-400 rounded">
                                    <p class="text-sm text-green-700 font-medium">Info</p>
                                    <p class="text-xs text-green-600 mt-1">Sistem maintenance Sabtu malam</p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>
</x-app-layout>
