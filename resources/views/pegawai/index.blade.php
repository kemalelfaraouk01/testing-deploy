<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Pegawai') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @role('Admin')
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    {{-- Tombol di Kiri --}}
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('pegawai.create') }}"
                            class="group inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                                <path
                                    d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                            </svg>
                            Tambah Pegawai
                        </a>
                        <a href="{{ route('pegawai.pensiun') }}"
                            class="group inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg shadow-sm hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10zm0 5.25a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75z" clip-rule="evenodd" /></svg>
                            Arsip Pensiun
                        </a>
                    </div>
                    {{-- Tombol di Kanan --}}
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('pegawai.import.form') }}"
                            class="group inline-flex items-center px-4 py-2 bg-green-100 text-green-700 hover:bg-green-200 border border-green-200 text-sm font-medium rounded-lg shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-4 h-4 mr-2">
                                <path
                                    d="M9.25 13.25a.75.75 0 0 0 1.5 0V4.636l2.955 3.129a.75.75 0 0 0 1.09-1.03l-4.25-4.5a.75.75 0 0 0-1.09 0l-4.25 4.5a.75.75 0 1 0 1.09 1.03L9.25 4.636v8.614Z" />
                                <path
                                    d="M3.5 12.75a.75.75 0 0 0-1.5 0v2.5A2.75 2.75 0 0 0 4.75 18h10.5A2.75 2.75 0 0 0 18 15.25v-2.5a.75.75 0 0 0-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5Z" />
                            </svg>
                            Import Data
                        </a>
                        <button x-data @click.prevent="$dispatch('open-modal', 'confirm-delete-all-pegawai')"
                            class="group inline-flex items-center px-4 py-2 bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 text-sm font-medium rounded-lg shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Semua Data
                        </button>
                    </div>
                </div>
            @endrole

            {{-- ▼▼▼ INI BAGIAN YANG DIPERBAIKI ▼▼▼ --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-green-600 hover:text-green-800">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif
            {{-- ▲▲▲ BATAS AKHIR PERBAIKAN ▲▲▲ --}}

            {{-- Form Filter --}}
            <div class="mb-6 bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                <form method="GET" action="{{ route('pegawai.index') }}">
                    <div class="flex flex-col sm:flex-row items-end gap-4">
                        {{-- Filter Nama Pegawai (Semua Role) --}}
                        <div class="w-full sm:flex-1">
                            <label for="search_nama" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama
                                Pegawai</label>
                            <input type="text" name="search_nama" id="search_nama" placeholder="Ketik nama pegawai..."
                                value="{{ $searchNama ?? '' }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        {{-- Filter OPD (Hanya Admin) --}}
                        @role('Admin')
                            <div class="w-full sm:flex-1">
                                <label for="opd_id" class="block text-sm font-medium text-gray-700 mb-1">Filter per
                                    OPD</label>
                                <select name="opd_id" id="opd_id"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Semua OPD --</option>
                                    @foreach ($opds as $opd)
                                        <option value="{{ $opd->id }}" {{ $selectedOpdId == $opd->id ? 'selected' : '' }}>
                                            {{ $opd->nama_opd }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Filter Status Kepegawaian (Hanya Admin) --}}
                            <div class="w-full sm:flex-1">
                                <label for="status_kepegawaian"
                                    class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status_kepegawaian" id="status_kepegawaian"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Semua Status --</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" {{ ($searchStatus ?? '') == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endrole

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center space-x-2">
                            <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-4 h-4 mr-1.5">
                                    <path fill-rule="evenodd"
                                        d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z"
                                        clip-rule="evenodd" />
                                </svg>
                                Cari
                            </button>
                            <a href="{{ route('pegawai.index') }}"
                                class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Daftar Pegawai</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Menampilkan data pegawai dari <span
                                    class="font-semibold text-blue-600">{{ $namaOpd }}</span>
                            </p>
                        </div>
                        <div class="hidden sm:block">
                            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border">
                                <div class="flex items-center text-sm">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z">
                                        </path>
                                    </svg>
                                    <span class="text-gray-600">Total:</span>
                                    <span class="font-semibold text-gray-900 ml-1">{{ $pegawais->total() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="sticky left-0 bg-gray-50 z-20 px-4 py-4 text-left">
                                    <div class="flex items-center space-x-1">
                                        <span
                                            class="text-xs font-semibold text-gray-600 uppercase tracking-wider">No</span>
                                    </div>
                                </th>
                                <th
                                    class="sticky left-[80px] bg-gray-50 z-20 px-6 py-4 text-left border-r border-gray-200">
                                    <div class="flex items-center space-x-1">
                                        <span
                                            class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Pegawai</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <span
                                        class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Jabatan</span>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <span
                                        class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Pangkat</span>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <span
                                        class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Golongan</span>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <span
                                        class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</span>
                                </th>
                                @role('Admin')
                                    <th class="px-6 py-4 text-center">
                                        <span
                                            class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</span>
                                    </th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($pegawais as $index => $pegawai)
                                <tr class="hover:bg-blue-50 transition-colors group">
                                    <td class="sticky left-0 bg-white z-10 group-hover:bg-blue-50 px-4 py-6">
                                        <div
                                            class="flex items-center justify-center w-8 h-8 bg-gray-100 group-hover:bg-blue-100 rounded-full">
                                            <span class="text-sm font-semibold text-gray-600 group-hover:text-blue-600">
                                                {{ $pegawais->firstItem() + $index }}
                                            </span>
                                        </div>
                                    </td>

                                    <td
                                        class="sticky left-[80px] bg-white z-10 group-hover:bg-blue-50 px-6 py-6 border-r border-gray-100">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-bold text-white">
                                                        {{ substr($pegawai->nama_lengkap, 0, 1) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <a href="{{ route('pegawai.show', $pegawai->id) }}"
                                                    class="text-sm font-semibold text-gray-900 hover:text-blue-600 transition-colors line-clamp-1 block">
                                                    {{ $pegawai->nama_lengkap }}
                                                </a>
                                                <div class="flex items-center mt-1">
                                                    <svg class="w-3 h-3 text-gray-400 mr-1" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a.997.997 0 01-1.414 0l-7-7A1.997 1.997 0 013 12V7a4 4 0 014-4z">
                                                        </path>
                                                    </svg>
                                                    <span
                                                        class="text-xs text-gray-500">{{ $pegawai->user->nip }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-6">
                                        <div class="text-sm text-gray-900 line-clamp-2 max-w-xs">
                                            {{ $pegawai->jabatan ?? 'Belum Diatur' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-6">
                                        <span class="text-sm text-gray-900">{{ $pegawai->pangkat ?: '-' }}</span>
                                    </td>

                                    <td class="px-6 py-6">
                                        <span
                                            class="text-sm font-medium text-gray-900">{{ $pegawai->golongan ?: '-' }}</span>
                                    </td>

                                    <td class="px-6 py-6">
                                        @php
                                            $status = $pegawai->status_kepegawaian;
                                            $base_class = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border';
                                            $color_classes = '';
                                            $dot_class = '';

                                            switch ($status) {
                                                case 'PNS':
                                                    $color_classes = 'bg-green-100 text-green-800 border-green-200';
                                                    $dot_class = 'bg-green-500';
                                                    break;
                                                case 'CPNS':
                                                    $color_classes = 'bg-orange-100 text-orange-800 border-orange-200';
                                                    $dot_class = 'bg-orange-500';
                                                    break;
                                                case 'PPPK':
                                                    $color_classes = 'bg-blue-100 text-blue-800 border-blue-200';
                                                    $dot_class = 'bg-blue-500';
                                                    break;
                                                case 'Honorer':
                                                    $color_classes = 'bg-purple-100 text-purple-800 border-purple-200';
                                                    $dot_class = 'bg-purple-500';
                                                    break;
                                                case 'Pensiun':
                                                    $color_classes = 'bg-red-100 text-red-800 border-red-200';
                                                    $dot_class = 'bg-red-500';
                                                    break;
                                                default:
                                                    $color_classes = 'bg-gray-100 text-gray-800 border-gray-200';
                                                    $dot_class = 'bg-gray-500';
                                                    break;
                                            }
                                        @endphp
                                        <span class="{{ $base_class }} {{ $color_classes }}">
                                            <div class="w-1.5 h-1.5 {{ $dot_class }} rounded-full mr-2"></div>
                                            <span>{{ $status ?? 'N/A' }}</span>
                                        </span>
                                    </td>

                                    @role('Admin')
                                        <td class="px-6 py-6">
                                            <div class="flex items-center justify-center space-x-3">
                                                <a href="{{ route('pegawai.edit', $pegawai->id) }}"
                                                    class="inline-flex items-center px-3 py-2 text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-150">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <button x-data=""
                                                    x-on:click.prevent="$dispatch('open-delete-modal', { action: '{{ route('pegawai.destroy', $pegawai->id) }}' })"
                                                    class="inline-flex items-center px-3 py-2 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors duration-150">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </div>
                                        </td>
                                    @endrole
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->hasRole('Admin') ? '7' : '6' }}"
                                        class="px-6 py-20">
                                        <div class="text-center">
                                            <div
                                                class="mx-auto flex items-center justify-center h-16 w-16 bg-gray-100 rounded-full mb-4">
                                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data pegawai
                                            </h3>
                                            <p class="text-sm text-gray-500 max-w-sm mx-auto">
                                                Data pegawai belum tersedia untuk ditampilkan. Mulai dengan menambahkan
                                                data pegawai baru.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="sm:hidden px-6 py-3 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-center text-xs text-gray-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16l4-4m0 0l4 4m-4-4v12"></path>
                        </svg>
                        Geser ke kanan untuk melihat kolom lainnya
                    </div>
                </div>
            </div>

            <div class="mt-8">
                {{ $pegawais->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    {{-- Modal Konfirmasi Hapus Semua Data --}}
    <x-modal name="confirm-delete-all-pegawai" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div class="p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-start sm:gap-5">
                {{-- Ikon Peringatan --}}
                <div
                    class="mx-auto mb-4 sm:mb-0 flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <div class="text-center sm:text-left flex-grow">
                    <h3 class="text-xl font-bold text-gray-900" id="modal-title">
                        Hapus Semua Data Pegawai?
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-600">
                            Tindakan ini akan <strong class="font-semibold text-red-700">menghapus permanen</strong>
                            semua data pegawai, termasuk akun login mereka (kecuali akun Admin).
                            <br>
                            <strong class="font-semibold">Tindakan ini tidak dapat dibatalkan.</strong>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form Konfirmasi --}}
            <form method="post" action="{{ route('pegawai.destroy.all') }}" class="mt-6"
                x-data="{ phrase: 'HAPUS SEMUA DATA', userInput: '' }">
                @csrf
                @method('delete')

                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-md">
                    <label for="confirm_text" class="block text-sm font-medium text-red-800">
                        Untuk konfirmasi, silakan ketik frasa berikut:
                        <strong class="font-bold" x-text="phrase"></strong>
                    </label>
                    <div class="mt-2">
                        <x-text-input x-model="userInput" id="confirm_text" name="confirm_text" type="text"
                                                class="w-full tracking-widest" x-bind:placeholder="phrase" />                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="mt-8 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3 space-y-2 space-y-reverse sm:space-y-0">
                    <x-secondary-button x-on:click="$dispatch('close')" class="w-full sm:w-auto justify-center">
                        Batal
                    </x-secondary-button>
                    <x-danger-button class="w-full sm:w-auto justify-center" x-bind:disabled="userInput !== phrase">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Ya, Hapus Semua Data
                    </x-danger-button>
                </div>
            </form>
        </div>
    </x-modal>


    <style>
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .overflow-x-auto {
            scroll-behavior: smooth;
        }

        .sticky {
            box-shadow: 4px 0 8px -4px rgba(0, 0, 0, 0.1);
        }

        .group:hover .sticky {
            box-shadow: 4px 0 8px -4px rgba(59, 130, 246, 0.15);
        }
    </style>
</x-app-layout>
