<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            Detail Verifikasi TPP
        </h2>
    </x-slot>

    <div x-data="{
        showModal: @error('keterangan') true @else false @enderror,
        modalType: @error('keterangan') 'reject' @else '' @enderror,
        formAction: @error('keterangan') '{{ route('verifikasi-tpp.reject', $pengajuanTpp->id) }}' @else '' @enderror,
        modalTitle: @error('keterangan') 'Konfirmasi Penolakan' @else '' @enderror,
        besaranTpp: {{ $pengajuanTpp->besaran_tpp_diajukan ?? 0 }},
    
        openModal(type, title, action) {
            this.modalType = type;
            this.modalTitle = title;
            this.formAction = action;
            this.showModal = true;
        }
    }">
        <div class="py-6">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Navigation -->
                <div class="mb-6 flex items-center justify-between">
                    <a href="{{ route('verifikasi-tpp.index') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali
                    </a>

                    @if ($pengajuanTpp->status == 'disetujui')
                        <a href="{{ route('pengajuan-tpp.cetak', $pengajuanTpp->id) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Cetak
                        </a>
                    @endif
                </div>

                <!-- Error Alert -->
                @if (session('error'))
                    <div class="mb-6 p-4 text-red-800 bg-red-50 border border-red-200 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 ">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-indigo-50">
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Pengajuan</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <div class="text-sm text-gray-500 mb-1">Periode</div>
                                    <div class="text-base font-medium text-gray-900">
                                        {{ $daftarBulan[$pengajuanTpp->periode_bulan] }}
                                        {{ $pengajuanTpp->periode_tahun }}
                                    </div>
                                </div>

                                <div>
                                    <div class="text-sm text-gray-500 mb-1">Status</div>
                                    <div>
                                        @if ($pengajuanTpp->status == 'diajukan')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                Menunggu Verifikasi
                                            </span>
                                        @elseif($pengajuanTpp->status == 'disetujui')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                Disetujui
                                            </span>
                                        @elseif($pengajuanTpp->status == 'ditolak')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                Ditolak
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <div class="text-sm text-gray-500 mb-1">Unit Kerja</div>
                                    <div class="text-base font-medium text-gray-900">
                                        {{ $pengajuanTpp->opd?->nama_opd ?? '[OPD tidak ditemukan]' }}
                                    </div>
                                </div>

                                <div>
                                    <div class="text-sm text-gray-500 mb-1">Tanggal Diajukan</div>
                                    <div class="text-sm text-gray-900">
                                        {{ $pengajuanTpp->created_at->translatedFormat('d F Y, H:i') }} WIB
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <!-- Header Section -->
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900">Berkas Terlampir</h3>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">Dokumen yang diperlukan untuk pengajuan TPP</p>
                        </div>

                        <!-- Content Section -->
                        <div class="p-6">
                            <div class="space-y-3">
                                <!-- File Item 1 -->
                                <div
                                    class="flex items-center justify-between p-4 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                Daftar Tambahan Penghasilan Pegawai (TPP)
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                Dokumen daftar TPP yang akan diajukan
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if ($pengajuanTpp->berkas_tpp)
                                            <a href="{{ asset('storage/' . $pengajuanTpp->berkas_tpp) }}"
                                                target="_blank"
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                Lihat
                                            </a>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-md text-red-700 bg-red-100">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Tidak ada
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- File Item 2 -->
                                <div
                                    class="flex items-center justify-between p-4 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                Surat Keterangan SPJ-TU Nihil
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                Surat pertanggungjawaban tata usaha
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if ($pengajuanTpp->berkas_spj)
                                            <a href="{{ asset('storage/' . $pengajuanTpp->berkas_spj) }}"
                                                target="_blank"
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                Lihat
                                            </a>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-md text-red-700 bg-red-100">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Tidak ada
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- File Item 3 -->
                                <div
                                    class="flex items-center justify-between p-4 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                Surat Pernyataan Mutlak Kepala OPD
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                Surat pernyataan resmi dari kepala organisasi
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if ($pengajuanTpp->berkas_pernyataan)
                                            <a href="{{ asset('storage/' . $pengajuanTpp->berkas_pernyataan) }}"
                                                target="_blank"
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                Lihat
                                            </a>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-md text-red-700 bg-red-100">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Tidak ada
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- File Item 4 -->
                                <div
                                    class="flex items-center justify-between p-4 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                Surat Pengantar dari Atasan
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                Surat pengantar resmi dari atasan langsung
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if ($pengajuanTpp->berkas_pengantar)
                                            <a href="{{ asset('storage/' . $pengajuanTpp->berkas_pengantar) }}"
                                                target="_blank"
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                Lihat
                                            </a>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-md text-red-700 bg-red-100">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Tidak ada
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Info -->
                            <div class="mt-6 p-3 bg-blue-50 rounded-lg border-l-4 border-blue-400">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            <span class="font-medium">Catatan:</span> Pastikan semua berkas telah
                                            diunggah dengan format yang benar sebelum melanjutkan proses pengajuan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TPP Amount -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-yellow-50 to-indigo-50">
                            <h3 class="text-lg font-semibold text-gray-900">Besaran TPP</h3>
                        </div>
                        <div class="p-6">
                            @if ($pengajuanTpp->status == 'diajukan')
                                <form action="{{ route('verifikasi-tpp.update-besaran', $pengajuanTpp->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="space-y-4">
                                        <div>
                                            <x-input-label for="besaran_tpp_diajukan"
                                                value="Total Besaran TPP (Rp)" />
                                            <x-text-input id="besaran_tpp_diajukan" name="besaran_tpp_diajukan"
                                                type="number" x-model.number="besaranTpp" class="block mt-1 w-full"
                                                :value="old(
                                                    'besaran_tpp_diajukan',
                                                    $pengajuanTpp->besaran_tpp_diajukan,
                                                )" placeholder="Contoh: 150000000" required
                                                step="any" />
                                            <x-input-error :messages="$errors->get('besaran_tpp_diajukan')" class="mt-2" />
                                            <p class="mt-2 text-sm text-gray-500">
                                                Masukkan nominal tanpa titik atau koma. Contoh: 150000000
                                            </p>
                                        </div>
                                        <x-primary-button>
                                            Simpan Besaran
                                        </x-primary-button>
                                    </div>
                                </form>
                            @else
                                <div>
                                    <div class="text-sm text-gray-500 mb-1">Total Besaran TPP</div>
                                    <div class="text-2xl font-bold text-gray-900">
                                        Rp {{ number_format($pengajuanTpp->besaran_tpp_diajukan, 0, ',', '.') ?? '0' }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    @if ($pengajuanTpp->status == 'diajukan')
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Tindakan Verifikasi</h3>
                            </div>
                            <div class="p-6">
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <button
                                        @click="openModal('approve', 'Konfirmasi Persetujuan', '{{ route('verifikasi-tpp.approve', $pengajuanTpp->id) }}')"
                                        :disabled="!besaranTpp || besaranTpp <= 0"
                                        :class="{ 'opacity-50 cursor-not-allowed': !besaranTpp || besaranTpp <= 0 }"
                                        class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-green-600 border border-transparent rounded-lg font-medium text-white hover:bg-green-700 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Setujui
                                    </button>
                                    <button
                                        @click="openModal('reject', 'Konfirmasi Penolakan', '{{ route('verifikasi-tpp.reject', $pengajuanTpp->id) }}')"
                                        class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-red-600 border border-transparent rounded-lg font-medium text-white hover:bg-red-700 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Tolak
                                    </button>
                                </div>

                                <div x-show="!besaranTpp || besaranTpp <= 0"
                                    class="mt-4 p-3 text-sm text-amber-800 bg-amber-50 border border-amber-200 rounded-lg">
                                    <div class="flex">
                                        <svg class="w-5 h-5 mr-2 mt-0.5 text-amber-400" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>Harap isi dan simpan nominal TPP terlebih dahulu sebelum
                                            menyetujui.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div x-show="showModal" style="display: none;" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div @click="showModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity">
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div
                    class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10"
                            :class="{ 'bg-green-100': modalType === 'approve', 'bg-red-100': modalType === 'reject' }">
                            <svg x-show="modalType === 'approve'" class="w-6 h-6 text-green-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <svg x-show="modalType === 'reject'" class="w-6 h-6 text-red-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>

                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg font-medium text-gray-900" x-text="modalTitle"></h3>

                            <form :action="formAction" method="POST" class="mt-4">
                                @csrf

                                <p x-show="modalType === 'approve'" class="text-sm text-gray-600 mb-4">
                                    Apakah Anda yakin ingin menyetujui pengajuan ini?
                                </p>

                                <div x-show="modalType === 'reject'">
                                    <p class="text-sm text-gray-600 mb-4">
                                        Berikan alasan penolakan pengajuan ini.
                                    </p>
                                    <div>
                                        <x-input-label for="keterangan" value="Alasan Penolakan" />
                                        <textarea name="keterangan" id="keterangan" rows="4"
                                            class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            :required="modalType === 'reject'" placeholder="Masukkan alasan penolakan...">{{ old('keterangan') }}</textarea>
                                        <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                                    <button @click="showModal = false" type="button"
                                        class="inline-flex justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:text-sm">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        :class="{
                                            'bg-green-600 hover:bg-green-700 focus:ring-green-500': modalType === 'approve',
                                            'bg-red-600 hover:bg-red-700 focus:ring-red-500': modalType === 'reject'
                                        }"
                                        class="inline-flex justify-center rounded-lg border border-transparent px-4 py-2 text-base font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:text-sm">
                                        Ya, Lanjutkan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
