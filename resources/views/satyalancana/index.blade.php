<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                {{ __('Usulan Penghargaan Satyalancana') }}
            </h2>
        </div>
    </x-slot>
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 sm:space-y-6">

            {{-- Menampilkan Pesan Feedback --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                    <p class="font-bold">Terjadi Kesalahan</p>
                    <p>{{ $errors->first() }}</p>
                </div>
            @endif

            {{-- ▼▼▼ KOTAK INFORMASI PERIODE ▼▼▼ --}}
            <div
                class="p-4 sm:p-6 bg-white shadow sm:rounded-lg border-l-4 @if ($isPeriodeDibuka) border-blue-500 @else border-gray-400 @endif">
                @if ($isPeriodeDibuka)
                    <h3 class="font-semibold text-blue-800">Periode Pengusulan Aktif: {{ $periodeAktif }}</h3>
                    <p class="text-sm text-gray-600 mt-1">Anda dapat mengusulkan kandidat untuk periode yang sedang
                        berjalan.</p>
                @else
                    <h3 class="font-semibold text-gray-800">Periode Pengusulan Saat Ini Ditutup</h3>
                    <p class="text-sm text-gray-600 mt-1">Periode pengusulan selanjutnya adalah pada bulan Agustus dan
                        November.</p>
                @endif
            </div>
            {{-- ▲▲▲ BATAS AKHIR KOTAK INFORMASI ▲▲▲ --}}

            {{-- KARTU 30 TAHUN --}}
            <div class="p-4 sm:p-6 lg:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-base sm:text-lg font-bold text-gray-800 border-b pb-2 mb-4">
                    Pegawai yang Memenuhi Syarat Satyalancana XXX (30 Tahun)
                </h3>
                <form action="{{ route('satyalancana.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="masa_kerja" value="30">
                    <input type="hidden" name="periode" value="{{ $periodeAktif }}"> {{-- Sertakan periode --}}

                    <div class="space-y-2 sm:space-y-3">
                        @forelse($eligible['xxx'] as $item)
                            <label
                                class="flex items-start sm:items-center border-b pb-3 sm:pb-2 last:border-b-0 cursor-pointer hover:bg-gray-50 -mx-2 px-2 rounded transition-colors">
                                <input type="checkbox" name="pegawai_ids[]" value="{{ $item['pegawai']->id }}"
                                    class="mt-1 sm:mt-0 mr-3 sm:mr-4 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-gray-900 text-sm sm:text-base break-words">
                                        {{ $item['pegawai']->nama_lengkap }}
                                    </div>
                                    <div class="text-xs sm:text-sm text-gray-600 mt-1 space-y-1">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                                OPD: {{ Str::limit($item['pegawai']->opd->nama_opd ?? 'N/A', 25) }}
                                            </span>
                                            <span class="flex items-center mt-1 sm:mt-0">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Masa Kerja: {{ floor($item['masaKerja']) }} Tahun
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24"></svg>
                                <p class="text-sm text-gray-500">Tidak ada pegawai yang memenuhi syarat.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Tombol hanya aktif jika periode dibuka --}}
                    @if (!empty($eligible['xxx']) && $isPeriodeDibuka)
                        <div class="flex justify-end mt-4 pt-4 border-t">
                            <x-primary-button class="w-full sm:w-auto text-center justify-center">
                                Usulkan Pegawai Terpilih
                            </x-primary-button>
                        </div>
                    @endif
                </form>
            </div>

            {{-- KARTU 20 TAHUN --}}
            <div class="p-4 sm:p-6 lg:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-base sm:text-lg font-bold text-gray-800 border-b pb-2 mb-4">
                    Pegawai yang Memenuhi Syarat Satyalancana XX (20 Tahun)
                </h3>
                <form action="{{ route('satyalancana.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="masa_kerja" value="20">
                    <input type="hidden" name="periode" value="{{ $periodeAktif }}">

                    <div class="space-y-2 sm:space-y-3">
                        @forelse($eligible['xx'] as $item)
                            <label
                                class="flex items-start sm:items-center border-b pb-3 sm:pb-2 last:border-b-0 cursor-pointer hover:bg-gray-50 -mx-2 px-2 rounded transition-colors">
                                <input type="checkbox" name="pegawai_ids[]" value="{{ $item['pegawai']->id }}"
                                    class="mt-1 sm:mt-0 mr-3 sm:mr-4 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-gray-900 text-sm sm:text-base break-words">
                                        {{ $item['pegawai']->nama_lengkap }}
                                    </div>
                                    <div class="text-xs sm:text-sm text-gray-600 mt-1 space-y-1">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                                OPD: {{ Str::limit($item['pegawai']->opd->nama_opd ?? 'N/A', 25) }}
                                            </span>
                                            <span class="flex items-center mt-1 sm:mt-0">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Masa Kerja: {{ floor($item['masaKerja']) }} Tahun
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-sm text-gray-500">Tidak ada pegawai yang memenuhi syarat.</p>
                            </div>
                        @endforelse
                    </div>

                    @if (!empty($eligible['xx']) && $isPeriodeDibuka)
                        <div class="flex justify-end mt-4 pt-4 border-t">
                            <x-primary-button class="w-full sm:w-auto text-center justify-center">
                                Usulkan Pegawai Terpilih
                            </x-primary-button>
                        </div>
                    @endif
                </form>
            </div>

            {{-- KARTU 10 TAHUN --}}
            <div class="p-4 sm:p-6 lg:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-base sm:text-lg font-bold text-gray-800 border-b pb-2 mb-4">
                    Pegawai yang Memenuhi Syarat Satyalancana X (10 Tahun)
                </h3>
                <form action="{{ route('satyalancana.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="masa_kerja" value="10">
                    <input type="hidden" name="periode" value="{{ $periodeAktif }}">

                    <div class="space-y-2 sm:space-y-3">
                        @forelse($eligible['x'] as $item)
                            <label
                                class="flex items-start sm:items-center border-b pb-3 sm:pb-2 last:border-b-0 cursor-pointer hover:bg-gray-50 -mx-2 px-2 rounded transition-colors">
                                <input type="checkbox" name="pegawai_ids[]" value="{{ $item['pegawai']->id }}"
                                    class="mt-1 sm:mt-0 mr-3 sm:mr-4 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-gray-900 text-sm sm:text-base break-words">
                                        {{ $item['pegawai']->nama_lengkap }}
                                    </div>
                                    <div class="text-xs sm:text-sm text-gray-600 mt-1 space-y-1">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                                OPD: {{ Str::limit($item['pegawai']->opd->nama_opd ?? 'N/A', 25) }}
                                            </span>
                                            <span class="flex items-center mt-1 sm:mt-0">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Masa Kerja: {{ floor($item['masaKerja']) }} Tahun
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-sm text-gray-500">Tidak ada pegawai yang memenuhi syarat.</p>
                            </div>
                        @endforelse
                    </div>

                    @if (!empty($eligible['x']) && $isPeriodeDibuka)
                        <div class="flex justify-end mt-4 pt-4 border-t">
                            <x-primary-button class="w-full sm:w-auto text-center justify-center">
                                Usulkan Pegawai Terpilih
                            </x-primary-button>
                        </div>
                    @endif
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
