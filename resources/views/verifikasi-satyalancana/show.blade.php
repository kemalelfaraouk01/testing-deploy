<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Verifikasi Satyalancana
        </h2>
    </x-slot>

    <div x-data="{
        showModal: @error('keterangan') true @else false @enderror,
        modalType: @error('keterangan') 'reject' @else '' @enderror,
        formAction: @error('keterangan') '{{ old('form_action') }}' @else '' @enderror,
        modalTitle: @error('keterangan') 'Konfirmasi Penolakan' @else '' @enderror,
        openModal(type, title, action) {
            this.modalType = type;
            this.modalTitle = title;
            this.formAction = action;
            this.showModal = true;
        }
    }" class="py-6 sm:py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('verifikasi-satyalancana.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-lg font-medium text-sm text-gray-700 transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Verifikasi
                </a>
            </div>

            {{-- Menampilkan Pesan Sukses --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Informasi Pegawai
                            </h3>
                        </div>
                        <div class="p-6">
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <dt class="text-sm font-medium text-gray-500">Nama Pegawai</dt>
                                    <dd class="text-base font-semibold text-gray-900">
                                        {{ $satyalancana->pegawai->nama_lengkap }}</dd>
                                </div>
                                <div class="space-y-1">
                                    <dt class="text-sm font-medium text-gray-500">NIP</dt>
                                    <dd class="text-sm text-gray-900 font-mono">{{ $satyalancana->pegawai->user->nip }}
                                    </dd>
                                </div>
                                <div class="sm:col-span-2 space-y-1">
                                    <dt class="text-sm font-medium text-gray-500">OPD</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ $satyalancana->pegawai->opd->nama_opd ?? 'N/A' }}</dd>
                                </div>
                                <div class="space-y-1">
                                    <dt class="text-sm font-medium text-gray-500">Penghargaan Diusulkan</dt>
                                    <dd
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ $satyalancana->jenis_penghargaan }}
                                    </dd>
                                </div>
                                <div class="space-y-1">
                                    <dt class="text-sm font-medium text-gray-500">Periode Pengusulan</dt>
                                    <dd class="text-sm font-semibold text-gray-900">
                                        {{ $satyalancana->periode ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Daftar Berkas
                            </h3>
                        </div>
                        <div class="p-6">
                            @php
                                $berkas = [
                                    ['field' => 'file_drh', 'label' => 'Daftar Riwayat Hidup (DRH)'],
                                    ['field' => 'file_sk_cpns', 'label' => 'SK CPNS'],
                                    ['field' => 'file_sk_pangkat_terakhir', 'label' => 'SK Pangkat Terakhir'],
                                    ['field' => 'file_sk_jabatan_terakhir', 'label' => 'SK Jabatan Terakhir'],
                                    [
                                        'field' => 'file_surat_pernyataan_disiplin',
                                        'label' => 'Surat Pernyataan Tidak Pernah Dijatuhi Hukuman Disiplin',
                                    ],
                                    ['field' => 'file_skp', 'label' => 'SKP / Penilaian Kinerja'],
                                    ['field' => 'file_sptjm', 'label' => 'SPTJM (jika ada)'],
                                    [
                                        'field' => 'file_piagam_sebelumnya',
                                        'label' => 'Piagam SLKS Sebelumnya (jika ada)',
                                    ],
                                ];
                            @endphp

                            <div class="space-y-3">
                                @foreach ($berkas as $index => $file)
                                    <div
                                        class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors duration-200">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start gap-3">
                                                <span
                                                    class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full flex items-center justify-center">
                                                    {{ $index + 1 }}
                                                </span>
                                                <span
                                                    class="text-sm font-medium text-gray-700 leading-tight">{{ $file['label'] }}</span>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ml-4">
                                            @if ($satyalancana->{$file['field']})
                                                <a href="{{ asset('storage/' . $satyalancana->{$file['field']}) }}"
                                                    target="_blank"
                                                    class="inline-flex items-center gap-1 px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Lihat
                                                </a>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-md">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.866-.833-2.636 0L3.178 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                                    </svg>
                                                    Tidak ada
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-6">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Status & Tindakan
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Status Saat Ini</p>
                                @php
                                    $status = $satyalancana->status;
                                    $statusText = Str::title(str_replace('_', ' ', $status));
                                    $statusColorClasses = match ($status) {
                                        'disetujui' => 'bg-green-100 text-green-800',
                                        'perlu_perbaikan' => 'bg-yellow-100 text-yellow-800',
                                        'ditolak' => 'bg-red-100 text-red-800',
                                        default => 'bg-blue-100 text-blue-800',
                                    };
                                @endphp
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusColorClasses }}">
                                    {{ $statusText }}
                                </span>
                            </div>

                            @if (in_array($satyalancana->status, ['diusulkan', 'berkas_lengkap', 'menunggu_kelengkapan_berkas']))
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-2">Pilih Tindakan</p>
                                    <div class="space-y-3">
                                        <button
                                            @click="openModal('approve', 'Konfirmasi Persetujuan', '{{ route('verifikasi-satyalancana.approve', $satyalancana->id) }}')"
                                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 border border-transparent rounded-lg font-semibold text-sm text-white transition-all duration-200 transform hover:scale-105 active:scale-95">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Setujui Usulan
                                        </button>
                                        <button
                                            @click="openModal('reject', 'Konfirmasi Penolakan', '{{ route('verifikasi-satyalancana.reject', $satyalancana->id) }}')"
                                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-red-50 border border-red-300 rounded-lg font-semibold text-sm text-red-600 transition-all duration-200 transform hover:scale-105 active:scale-95">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                            Kembalikan untuk Perbaikan
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="text-sm text-gray-600 space-y-4">
                                    @if ($satyalancana->diverifikasiOleh)
                                        <div>
                                            <p class="font-medium text-gray-500 mb-1">Diproses oleh</p>
                                            <p class="font-semibold text-gray-800">
                                                {{ $satyalancana->diverifikasiOleh->name }}</p>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-500 mb-1">Tanggal Proses</p>
                                            <p class="font-semibold text-gray-800">
                                                {{ \Carbon\Carbon::parse($satyalancana->tanggal_verifikasi)->translatedFormat('d F Y, H:i') }}
                                            </p>
                                        </div>
                                    @endif
                                    @if ($satyalancana->status == 'perlu_perbaikan' && $satyalancana->keterangan)
                                        <div>
                                            <p class="font-medium text-gray-500 mb-1">Alasan Perbaikan</p>
                                            <div
                                                class="text-sm bg-yellow-50 border border-yellow-200 text-yellow-800 p-3 rounded-lg">
                                                {{ $satyalancana->keterangan }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showModal" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click="showModal = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
            <div class="relative w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden">
                <form :action="formAction" method="POST">
                    @csrf
                    <input type="hidden" name="form_action" :value="formAction">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900" x-text="modalTitle"></h3>
                    </div>
                    <div class="px-6 py-4">
                        <div x-show="modalType === 'approve'" class="text-sm text-gray-600">
                            <div class="flex items-start gap-3 p-4 bg-green-50 rounded-lg border border-green-200">
                                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p>Apakah Anda yakin ingin menyetujui usulan penghargaan ini? Tindakan ini tidak dapat
                                    dibatalkan.</p>
                            </div>
                        </div>
                        <div x-show="modalType === 'reject'">
                            <div class="mb-4 flex items-start gap-3 p-4 bg-red-50 rounded-lg border border-red-200">
                                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.866-.833-2.636 0L3.178 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                                <p class="text-sm text-red-800">Harap berikan alasan yang jelas untuk mengembalikan
                                    usulan ini untuk perbaikan.</p>
                            </div>
                            <x-input-label for="keterangan" value="Alasan Pengembalian (Wajib Diisi) *"
                                class="font-semibold" />
                            <textarea name="keterangan" id="keterangan" rows="4"
                                placeholder="Contoh: SK CPNS tidak terbaca, mohon unggah ulang."
                                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                                :required="modalType === 'reject'">{{ old('keterangan') }}</textarea>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row-reverse gap-3">
                        <button type="submit"
                            :class="{
                                'bg-green-600 hover:bg-green-700 focus:ring-green-500': modalType === 'approve',
                                'bg-red-600 hover:bg-red-700 focus:ring-red-500': modalType === 'reject'
                            }"
                            class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-lg text-sm font-semibold text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200">
                            Ya, Lanjutkan
                        </button>
                        <button @click="showModal = false" type="button"
                            class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
