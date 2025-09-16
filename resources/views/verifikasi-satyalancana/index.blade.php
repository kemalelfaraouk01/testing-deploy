<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                {{ __('Verifikasi Usulan Satyalancana') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Kotak Filter Periode --}}
            <div class="mb-6">
                <div class="bg-white p-4 rounded-xl shadow border">
                    <form action="{{ route('verifikasi-satyalancana.index') }}" method="GET">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1">
                                <label for="periode" class="block text-sm font-medium text-gray-700">Filter Berdasarkan
                                    Periode</label>
                                <select name="periode" id="periode"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Tampilkan Semua Periode</option>
                                    @foreach ($periodes as $periode)
                                        <option value="{{ $periode }}" @selected(request('periode') == $periode)>
                                            {{ $periode }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="pt-6">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700">
                                    Filter
                                </button>
                                <a href="{{ route('verifikasi-satyalancana.index') }}"
                                    class="ml-2 inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-300">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mb-6">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">Total Usulan Diproses</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $usulans->total() }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
                <div class="px-4 sm:px-6 lg:px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 flex items-center space-x-2">
                        <span class="w-2 h-6 bg-blue-500 rounded-full"></span>
                        <span>Daftar Usulan Masuk</span>
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Usulan yang siap untuk diverifikasi</p>
                </div>

                <div class="hidden lg:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Nama Pegawai / OPD
                                    </th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Masa Kerja
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Tgl Pengajuan
                                    </th>
                                    {{-- ▼▼▼ KOLOM BARU ▼▼▼ --}}
                                    <th
                                        class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Status
                                    </th>
                                    {{-- ▲▲▲ BATAS AKHIR KOLOM BARU ▲▲▲ --}}
                                    <th
                                        class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($usulans as $usulan)
                                    @php
                                        $status = $usulan->status;
                                        $statusText = Str::title(str_replace('_', ' ', $status));
                                        $statusColorClasses = match ($status) {
                                            'disetujui' => 'bg-green-100 text-green-800',
                                            'perlu_perbaikan' => 'bg-yellow-100 text-yellow-800',
                                            'ditolak' => 'bg-red-100 text-red-800',
                                            'berkas_lengkap', 'diverifikasi' => 'bg-purple-100 text-purple-800',
                                            default => 'bg-blue-100 text-blue-800',
                                        };
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                                    <span class="text-gray-600 font-semibold text-sm">
                                                        {{ strtoupper(substr($usulan->pegawai->nama_lengkap, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-900">
                                                        {{ $usulan->pegawai->nama_lengkap }}</div>
                                                    <div class="text-sm text-gray-500 flex items-center space-x-1">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm3 1h6v4H7V5zm8 8v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2h8z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <span>{{ $usulan->pegawai->opd->nama_opd ?? 'N/A' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="inline-flex px-3 py-1 text-sm font-semibold bg-gray-100 text-gray-800 rounded-full">
                                                {{ $usulan->masa_kerja }} Tahun
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span
                                                    class="text-gray-900 font-medium">{{ $usulan->created_at->translatedFormat('d M Y') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColorClasses }}">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('verifikasi-satyalancana.show', $usulan->id) }}"
                                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Lihat & Proses
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center space-y-3">
                                                <p class="text-gray-500 font-medium">Tidak ada usulan yang ditemukan</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="lg:hidden">
                    <div class="divide-y divide-gray-200">
                        @forelse ($usulans as $usulan)
                            <div class="p-4 sm:p-6 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 font-bold">
                                            {{ strtoupper(substr($usulan->pegawai->nama_lengkap, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="font-semibold text-gray-900 mb-1">
                                            {{ $usulan->pegawai->nama_lengkap }}</div>

                                        <div class="mb-2">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColorClasses }}">
                                                {{ $statusText }}
                                            </span>
                                        </div>

                                        <div class="space-y-2">
                                            <div class="flex items-center space-x-2 text-sm text-gray-600">
                                                <svg class="w-4 h-4 text-gray-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm3 1h6v4H7V5zm8 8v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2h8z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span>{{ $usulan->pegawai->opd->nama_opd ?? 'N/A' }}</span>
                                            </div>

                                            <div class="flex flex-wrap items-center gap-3">
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">
                                                    {{ $usulan->masa_kerja }} Tahun
                                                </span>
                                                <div class="flex items-center space-x-1 text-sm text-gray-600">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span>{{ $usulan->created_at->translatedFormat('d M Y') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <a href="{{ route('verifikasi-satyalancana.show', $usulan->id) }}"
                                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg w-full sm:w-auto justify-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Lihat & Proses Berkas
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <p class="text-sm text-gray-500">Tidak ada usulan ditemukan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                @if ($usulans->hasPages())
                    <div class="px-4 sm:px-6 lg:px-8 py-6 border-t border-gray-200 bg-gray-50">
                        {{ $usulans->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
