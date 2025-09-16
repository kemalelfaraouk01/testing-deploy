<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pengajuan TPP
        </h2>
    </x-slot>

    <div class="py-6 lg:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

                <!-- Kolom Kiri (Konten Utama) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Card Informasi Pengajuan -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-xl">
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Pengajuan</h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5 text-sm">
                            <div>
                                <p class="text-gray-500">Nomor Pengajuan</p>
                                <p class="font-semibold text-gray-800">#{{ $pengajuanTpp->nomor_pengajuan ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Periode</p>
                                <p class="font-semibold text-gray-800">{{ $daftarBulan[$pengajuanTpp->periode_bulan] }} {{ $pengajuanTpp->periode_tahun }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-gray-500">Unit Kerja (OPD)</p>
                                <p class="font-semibold text-gray-800">{{ $namaOpd }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Diajukan Oleh</p>
                                <p class="font-semibold text-gray-800">{{ $pengajuanTpp->user?->name ?? 'Sistem' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Tanggal Diajukan</p>
                                <p class="font-semibold text-gray-800">{{ $pengajuanTpp->created_at->translatedFormat('d F Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Berkas Terlampir -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50 rounded-t-xl">
                            <h3 class="text-lg font-semibold text-gray-900">Berkas Terlampir</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            @php
                                $berkas = [
                                    ['field' => 'berkas_tpp', 'label' => 'Daftar Tambahan Penghasilan Pegawai (TPP)'],
                                    ['field' => 'berkas_spj', 'label' => 'Surat Keterangan SPJ-TU Nihil'],
                                    ['field' => 'berkas_pernyataan', 'label' => 'Surat Pernyataan Mutlak Kepala OPD'],
                                    ['field' => 'berkas_pengantar', 'label' => 'Surat Pengantar dari Atasan'],
                                ];
                            @endphp
                            @foreach ($berkas as $item)
                                <div class="flex items-center justify-between p-4 border rounded-lg bg-gray-50">
                                    <div class="flex items-center space-x-3 min-w-0">
                                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="text-sm font-medium text-gray-800 truncate">{{ $item['label'] }}</p>
                                    </div>
                                    @if ($pengajuanTpp->{$item['field']})
                                        <a href="{{ Storage::url($pengajuanTpp->{$item['field']}) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold hover:bg-blue-200 transition-colors">
                                            Lihat Berkas
                                        </a>
                                    @else
                                        <span class="px-3 py-1.5 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Tidak Ada</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan (Aksi & Status) -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Card Status -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6">
                            <p class="text-sm text-gray-500 mb-2">Status Pengajuan</p>
                            <x-status-badge :status="$pengajuanTpp->status" size="large" />
                            @if ($pengajuanTpp->status == 'perlu_perbaikan' || $pengajuanTpp->status == 'ditolak')
                                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-800">
                                    <p class="font-bold mb-1">Catatan dari Verifikator:</p>
                                    <p>{{ $pengajuanTpp->keterangan }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Panel Aksi untuk Verifikator -->
                    @can('verifikasi tpp')
                        @if ($pengajuanTpp->status == 'diajukan')
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                                <div class="p-6 border-b border-gray-100">
                                    <h3 class="text-lg font-semibold text-gray-900">Panel Aksi Verifikator</h3>
                                </div>
                                <div class="p-6 space-y-4">
                                    <form action="{{ route('verifikasi-tpp.update-besaran', $pengajuanTpp->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="space-y-2">
                                            <x-input-label for="besaran_tpp_diajukan" value="Input Besaran TPP (Rp)" />
                                            <x-text-input type="number" id="besaran_tpp_diajukan" name="besaran_tpp_diajukan" class="w-full" value="{{ old('besaran_tpp_diajukan', $pengajuanTpp->besaran_tpp_diajukan) }}" required />
                                            <x-input-error :messages="$errors->get('besaran_tpp_diajukan')" class="mt-2" />
                                        </div>
                                        <x-primary-button class="mt-3 w-full justify-center">Simpan Besaran TPP</x-primary-button>
                                    </form>

<<<<<<< HEAD
                                    <div class="flex items-center gap-2 pt-4 border-t">
                                        <form action="{{ route('verifikasi-tpp.reject', $pengajuanTpp->id) }}" method="POST" class="w-full">
                                            @csrf
                                            <x-text-input type="hidden" name="keterangan" value="Berkas tidak sesuai, harap perbaiki." />
                                            <x-danger-button type="submit" class="w-full justify-center">Tolak</x-danger-button>
                                        </form>
                                        <form action="{{ route('verifikasi-tpp.approve', $pengajuanTpp->id) }}" method="POST" class="w-full">
                                            @csrf
                                            <x-primary-button class="w-full justify-center bg-green-600 hover:bg-green-700">Setujui</x-primary-button>
                                        </form>
=======
                                <div class="bg-white p-3 sm:p-0 sm:bg-transparent rounded-md sm:rounded-none">
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if ($pengajuanTpp->status == 'diajukan')
                                            <span
                                                class="bg-yellow-200 text-yellow-800 text-xs sm:text-sm font-medium px-2 sm:px-3 py-1 rounded-full">{{ Str::ucfirst($pengajuanTpp->status) }}</span>
                                        @elseif($pengajuanTpp->status == 'disetujui')
                                            <span
                                                class="bg-green-200 text-green-800 text-xs sm:text-sm font-medium px-2 sm:px-3 py-1 rounded-full">{{ Str::ucfirst($pengajuanTpp->status) }}</span>
                                        @elseif($pengajuanTpp->status == 'ditolak')
                                            <span
                                                class="bg-red-200 text-red-800 text-xs sm:text-sm font-medium px-2 sm:px-3 py-1 rounded-full">{{ Str::ucfirst($pengajuanTpp->status) }}</span>
                                        @else
                                            <span
                                                class="bg-gray-200 text-gray-800 text-xs sm:text-sm font-medium px-2 sm:px-3 py-1 rounded-full">{{ Str::ucfirst($pengajuanTpp->status) }}</span>
                                        @endif
                                    </dd>
                                </div>

                                <div
                                    class="bg-white p-3 sm:p-0 sm:bg-transparent rounded-md sm:rounded-none sm:col-span-1 lg:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Unit Kerja (OPD)</dt>
                                    <dd class="mt-1 text-sm sm:text-base font-semibold text-gray-900 break-words">
                                        {{ $namaOpd }}
                                    </dd>
                                </div>

                                {{-- ▼▼▼ LOGIKA UNTUK MENAMPILKAN BESARAN TPP (HANYA JIKA SUDAH DIPROSES) ▼▼▼ --}}
                                @if ($pengajuanTpp->status != 'diajukan')
                                    <div
                                        class="bg-white p-3 sm:p-0 sm:bg-transparent rounded-md sm:rounded-none sm:col-span-1 lg:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Besaran TPP Disetujui</dt>
                                        <dd class="mt-1 text-sm sm:text-base font-semibold text-gray-900">
                                            Rp {{ number_format($pengajuanTpp->besaran_tpp_diajukan, 0, ',', '.') }}
                                        </dd>
                                    </div>
                                @endif
                                {{-- ▲▲▲ BATAS AKHIR LOGIKA BESARAN TPP ▲▲▲ --}}

                                <div
                                    class="bg-white p-3 sm:p-0 sm:bg-transparent rounded-md sm:rounded-none sm:col-span-1 lg:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Diajukan</dt>
                                    <dd class="mt-1 text-xs sm:text-sm text-gray-900">
                                        {{ $pengajuanTpp->created_at->translatedFormat('d F Y, H:i') }} WIB
                                    </dd>
                                </div>
                            </div>
                        </div>

                        {{-- Kartu Daftar Berkas - Mobile Responsive --}}
                        <div class="bg-gray-50 p-4 sm:p-6 rounded-lg shadow-inner mt-6">
                            <h4 class="text-base sm:text-lg font-bold text-gray-800 border-b pb-2 mb-4">Daftar Berkas
                                Terlampir</h4>
                            <div class="space-y-3 sm:space-y-4">
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 bg-white border rounded-md gap-3 sm:gap-0">
                                    <div class="flex-1">
                                        <span class="text-xs sm:text-sm font-medium text-gray-700 block">
                                            1. Daftar Tambahan Penghasilan Pegawai (TPP)
                                        </span>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if ($pengajuanTpp->berkas_tpp)
                                            <a href="{{ asset('storage/' . $pengajuanTpp->berkas_tpp) }}"
                                                target="_blank"
                                                class="inline-flex items-center justify-center w-full sm:w-auto px-3 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-blue-600">
                                                Lihat Berkas
                                            </a>
                                        @else
                                            <span class="text-xs text-red-500 block text-center sm:text-right">Berkas
                                                tidak ditemukan</span>
                                        @endif
>>>>>>> 82e007e84e5692e3a77758ea4a1d8379eb8fc049
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endcan

                    <!-- Tombol Cetak -->
                    @if ($pengajuanTpp->status == 'disetujui')
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                             <a href="{{ route('pengajuan-tpp.cetak', $pengajuanTpp->id) }}" target="_blank" class="inline-flex items-center justify-center w-full px-4 py-2.5 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700">
                                Cetak Dokumen
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>