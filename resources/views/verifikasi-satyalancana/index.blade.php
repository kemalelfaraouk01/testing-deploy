<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col space-y-2">
            <h2 class="text-xl sm:text-2xl text-gray-900 leading-tight">
                {{ __('Verif Usul Satyalancana') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">

            {{-- Filter Section - Mobile Optimized --}}
            <div class="mb-4 sm:mb-6">
                <div class="bg-white p-3 sm:p-4 rounded-lg sm:rounded-xl shadow border">
                    <form action="{{ route('verifikasi-satyalancana.index') }}" method="GET" x-data>
                        <div class="space-y-3 sm:space-y-0 sm:flex sm:items-end sm:gap-4">
                            <div class="flex-1">
                                <label for="periode" class="block text-sm font-medium text-gray-700 mb-1">
                                    Filter Berdasarkan Periode
                                </label>
                                <select name="periode" id="periode" x-ref="periodeSelect"
                                    class="block w-full px-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                                    <option value="">Tampilkan Semua Periode</option>
                                    @foreach ($periodes as $periode)
                                        <option value="{{ $periode }}" @selected(request('periode') == $periode)>
                                            {{ $periode }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Mobile: Stack buttons vertically, Desktop: Horizontal --}}
                            <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-2">
                                <button type="submit"
                                    class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2 sm:hidden" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Filter
                                </button>

                                <a href="{{ route('verifikasi-satyalancana.index') }}"
                                    class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                                    <svg class="w-4 h-4 mr-2 sm:hidden" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Reset
                                </a>

                                <a :href="'{{ route('satyalancana.export') }}?periode=' + $refs.periodeSelect.value"
                                    class="w-full sm:w-auto group inline-flex items-center justify-center px-4 py-2 bg-teal-100 text-teal-700 hover:bg-teal-200 border border-teal-200 text-sm font-medium rounded-lg shadow-sm transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-4 h-4 mr-2">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v4.59L7.3 9.24a.75.75 0 00-1.1 1.02l3.25 3.5a.75.75 0 001.1 0l3.25-3.5a.75.75 0 10-1.1-1.02l-1.95 2.1V6.75z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="hidden sm:inline">Export Excel</span>
                                    <span class="sm:hidden">Export</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Stats Card - Mobile Optimized --}}
            <div class="mb-4 sm:mb-6">
                <div
                    class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg sm:rounded-xl p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm font-medium text-blue-600">Total Usulan Diproses</p>
                            <p class="text-xl sm:text-2xl font-bold text-blue-900">{{ $usulans->total() }}</p>
                        </div>
                        <div class="p-2 sm:p-3 bg-blue-100 rounded-full">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Content Card --}}
            <div
                class="bg-white shadow-lg sm:shadow-xl rounded-lg sm:rounded-2xl border border-gray-100 overflow-hidden">
                {{-- Header --}}
                <div
                    class="px-3 sm:px-6 lg:px-8 py-4 sm:py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-base sm:text-lg lg:text-xl font-bold text-gray-900 flex items-center space-x-2">
                        <span class="w-1 sm:w-2 h-4 sm:h-6 bg-blue-500 rounded-full"></span>
                        <span>Daftar Usulan Masuk</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1">Usulan yang siap untuk diverifikasi</p>
                </div>

                {{-- Desktop Table View --}}
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
                                    <th
                                        class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Status
                                    </th>
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
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColorClasses }}">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('verifikasi-satyalancana.show', $usulan->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Proses
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center space-y-3">
                                                <svg class="w-12 h-12 text-gray-300" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <p class="text-gray-500 font-medium">Tidak ada usulan yang ditemukan
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Mobile Card View - Improved --}}
                {{-- Mobile Card View - Styled like TPP Page --}}
                <div class="lg:hidden grid grid-cols-1 sm:grid-cols-2 gap-6">
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
                        <div
                            class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 flex flex-col">
                            <div class="p-5 flex-grow">
                                <div class="flex justify-between items-start">
                                    <p class="text-xs font-semibold text-gray-500">
                                        {{ $usulan->pegawai->opd->nama_opd ?? 'N/A' }}</p>
                                    <div class="flex-shrink-0 ml-2">
                                        @switch($usulan->status)
                                            @case('disetujui')
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                            @break

                                            @case('perlu_perbaikan')
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-yellow-100 text-yellow-800">Perlu
                                                    Perbaikan</span>
                                            @break

                                            @case('ditolak')
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                            @break

                                            @case('berkas_lengkap')
                                            @case('diverifikasi')
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-purple-100 text-purple-800">Berkas
                                                    Lengkap</span>
                                            @break

                                            @default
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-blue-100 text-blue-800">{{ Str::title(str_replace('_', ' ', $usulan->status)) }}</span>
                                        @endswitch
                                    </div>
                                </div>
                                <h4 class="font-bold text-gray-900 text-md mt-2">
                                    {{ $usulan->pegawai->nama_lengkap }}
                                </h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $usulan->masa_kerja }} Tahun</p>
                                <p class="text-xs text-gray-500 mt-2">Diajukan pada:
                                    {{ $usulan->created_at->translatedFormat('d M Y') }}</p>
                            </div>
                            <div class="px-5 py-3 bg-gray-50 rounded-b-lg border-t border-gray-200">
                                <a href="{{ route('verifikasi-satyalancana.show', $usulan->id) }}"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all">
                                    Lihat & Proses
                                </a>
                            </div>
                        </div>
                        @empty
                            <div class="sm:col-span-2 p-8 text-center">
                                <div class="flex flex-col items-center space-y-3">
                                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-sm text-gray-500 font-medium">Tidak ada usulan ditemukan</p>
                                    <p class="text-xs text-gray-400">Coba ubah filter atau periode pencarian</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if ($usulans->hasPages())
                        <div class="px-3 sm:px-6 lg:px-8 py-4 sm:py-6 border-t border-gray-200 bg-gray-50">
                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                                <div class="text-xs sm:text-sm text-gray-700 order-2 sm:order-1">
                                    Menampilkan {{ $usulans->firstItem() }} - {{ $usulans->lastItem() }} dari
                                    {{ $usulans->total() }} hasil
                                </div>
                                <div class="order-1 sm:order-2">
                                    {{ $usulans->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-app-layout>
