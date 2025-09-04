<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Detail Pengajuan TPP
        </h2>
    </x-slot>

    {{-- Awal dari state Alpine.js yang disempurnakan --}}
    <div x-data="{
        showModal: @error('keterangan') true @else false @enderror,
        modalType: @error('keterangan') 'reject' @else '' @enderror,
        formAction: @error('keterangan') '{{ route('verifikasi-tpp.reject', $pengajuanTpp->id) }}' @else '' @enderror,
        modalTitle: @error('keterangan') 'Konfirmasi Penolakan' @else '' @enderror,
    
        openModal(type, title, action) {
            this.modalType = type;
            this.modalTitle = title;
            this.formAction = action;
            this.showModal = true;
        }
    }">
        <div class="py-6 sm:py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6 md:p-8 bg-white border-b border-gray-200">

                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mb-6">
                            <a href="{{ url()->previous() }}"
                                class="inline-flex items-center justify-center px-4 py-3 sm:py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 w-full sm:w-auto">
                                &larr; Kembali
                            </a>

                            @if ($pengajuanTpp->status == 'disetujui')
                                <a href="{{ route('pengajuan-tpp.cetak', $pengajuanTpp->id) }}" target="_blank"
                                    class="inline-flex items-center justify-center px-4 py-3 sm:py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 w-full sm:w-auto">
                                    Cetak Dokumen
                                </a>
                            @endif
                        </div>

                        {{-- Kartu Informasi Utama - Mobile Responsive --}}
                        <div class="bg-gray-50 p-4 sm:p-6 rounded-lg shadow-inner">
                            <h4 class="text-base sm:text-lg font-bold text-gray-800 border-b pb-2 mb-4">Informasi
                                Pengajuan</h4>

                            <div
                                class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-1 lg:grid-cols-2 sm:gap-x-6 sm:gap-y-4">
                                <div class="bg-white p-3 sm:p-0 sm:bg-transparent rounded-md sm:rounded-none">
                                    <dt class="text-sm font-medium text-gray-500">Periode</dt>
                                    <dd class="mt-1 text-sm sm:text-base font-semibold text-gray-900">
                                        {{ $daftarBulan[$pengajuanTpp->periode_bulan] }}
                                        {{ $pengajuanTpp->periode_tahun }}
                                    </dd>
                                </div>

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
                                        {{ $pengajuanTpp->opd->nama_opd }}
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
                                    </div>
                                </div>
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 bg-white border rounded-md gap-3 sm:gap-0">
                                    <div class="flex-1">
                                        <span class="text-xs sm:text-sm font-medium text-gray-700 block">
                                            2. Surat Keterangan SPJ-TU Nihil
                                        </span>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if ($pengajuanTpp->berkas_spj)
                                            <a href="{{ asset('storage/' . $pengajuanTpp->berkas_spj) }}"
                                                target="_blank"
                                                class="inline-flex items-center justify-center w-full sm:w-auto px-3 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-blue-600">
                                                Lihat Berkas
                                            </a>
                                        @else
                                            <span class="text-xs text-red-500 block text-center sm:text-right">Berkas
                                                tidak ditemukan</span>
                                        @endif
                                    </div>
                                </div>
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 bg-white border rounded-md gap-3 sm:gap-0">
                                    <div class="flex-1">
                                        <span class="text-xs sm:text-sm font-medium text-gray-700 block">
                                            3. Surat Pernyataan Mutlak Kepala OPD
                                        </span>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if ($pengajuanTpp->berkas_pernyataan)
                                            <a href="{{ asset('storage/' . $pengajuanTpp->berkas_pernyataan) }}"
                                                target="_blank"
                                                class="inline-flex items-center justify-center w-full sm:w-auto px-3 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-blue-600">
                                                Lihat Berkas
                                            </a>
                                        @else
                                            <span class="text-xs text-red-500 block text-center sm:text-right">Berkas
                                                tidak ditemukan</span>
                                        @endif
                                    </div>
                                </div>
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 bg-white border rounded-md gap-3 sm:gap-0">
                                    <div class="flex-1">
                                        <span class="text-xs sm:text-sm font-medium text-gray-700 block">
                                            4. Surat Pengantar dari Atasan
                                        </span>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if ($pengajuanTpp->berkas_pengantar)
                                            <a href="{{ asset('storage/' . $pengajuanTpp->berkas_pengantar) }}"
                                                target="_blank"
                                                class="inline-flex items-center justify-center w-full sm:w-auto px-3 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-blue-600">
                                                Lihat Berkas
                                            </a>
                                        @else
                                            <span class="text-xs text-red-500 block text-center sm:text-right">Berkas
                                                tidak ditemukan</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Menampilkan Alasan Penolakan - Mobile Responsive --}}
                        @if ($pengajuanTpp->status == 'ditolak' && $pengajuanTpp->keterangan)
                            <div class="bg-red-50 border-l-4 border-red-400 p-4 sm:p-6 rounded-lg shadow-inner mt-6">
                                <h4 class="text-base sm:text-lg font-bold text-red-800 mb-2">Catatan Penolakan</h4>
                                <p class="text-sm sm:text-base text-gray-700 whitespace-pre-wrap break-words">
                                    {{ $pengajuanTpp->keterangan }}</p>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL KONFIRMASI - Mobile Responsive --}}
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click="showModal = false" class="fixed inset-0 bg-black/50"></div>
            <div
                class="relative w-full max-w-lg mx-4 sm:mx-0 overflow-hidden rounded-lg bg-white shadow-xl transform transition-all p-4 sm:p-6 max-h-[90vh] overflow-y-auto">
                <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-4" x-text="modalTitle"></h3>
                <form :action="formAction" method="POST">
                    @csrf

                    <p x-show="modalType === 'approve'" class="text-sm text-gray-600 mb-4">
                        Apakah Anda yakin ingin menyetujui pengajuan berkas ini?
                    </p>

                    <div x-show="modalType === 'reject'">
                        <p class="text-sm text-gray-600 mb-4">
                            Apakah Anda yakin ingin menolak pengajuan ini? Harap berikan alasan penolakan.
                        </p>
                        <x-input-label for="keterangan" value="Alasan Penolakan (Wajib Diisi, min. 10 karakter)" />
                        <textarea name="keterangan" id="keterangan" rows="4"
                            class="block mt-1 w-full rounded-md shadow-sm border-gray-300 text-sm" :required="modalType === 'reject'"
                            placeholder="Masukkan alasan penolakan...">{{ old('keterangan') }}</textarea>
                        <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                    </div>

                    <div
                        class="mt-6 flex flex-col-reverse sm:flex-row-reverse gap-3 sm:gap-0 sm:space-x-2 sm:space-x-reverse">
                        <button type="submit"
                            :class="{ 'bg-green-600 hover:bg-green-700': modalType === 'approve', 'bg-red-600 hover:bg-red-700': modalType === 'reject' }"
                            class="inline-flex justify-center rounded-md border border-transparent px-4 py-3 sm:py-2 text-sm font-medium text-white shadow-sm focus:outline-none w-full sm:w-auto">
                            Ya, Lanjutkan
                        </button>
                        <button @click="showModal = false" type="button"
                            class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-3 sm:py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none w-full sm:w-auto">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
