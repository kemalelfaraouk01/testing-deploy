<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Verifikasi Cuti
        </h2>
    </x-slot>

    {{-- Inisialisasi Alpine.js untuk mengelola modal --}}
    <div x-data="{
        showModal: @error('keterangan_penolakan') true @else false @enderror,
        modalType: @error('keterangan_penolakan') 'reject' @else '' @enderror,
        formAction: @error('keterangan_penolakan') '{{ old('form_action') }}' @else '' @enderror,
        modalTitle: @error('keterangan_penolakan') 'Konfirmasi Penolakan' @else '' @enderror,
    
        openModal(type, title, action) {
            this.modalType = type;
            this.modalTitle = title;
            this.formAction = action;
            this.showModal = true;
        }
    }">
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 md:p-8 bg-white border-b border-gray-200 space-y-6">

                        <a href="{{ route('verifikasi-cuti.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                            &larr; Kembali ke Daftar Verifikasi
                        </a>

                        {{-- Kartu Informasi Pengajuan --}}
                        <div class="bg-gray-50 p-6 rounded-lg shadow-inner">
                            <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Informasi Pengajuan Cuti</h4>
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nama Pegawai</dt>
                                    <dd class="mt-1 text-base font-semibold text-gray-900">
                                        {{ $cuti->pegawai->nama_lengkap }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">OPD</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $cuti->pegawai->opd->nama_opd ?? 'N/A' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Jenis Cuti</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $cuti->jenis_cuti }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Cuti</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->translatedFormat('d M Y') }} -
                                        {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->translatedFormat('d M Y') }}
                                    </dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Keterangan / Alasan</dt>
                                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $cuti->keterangan }}
                                    </dd>
                                </div>
                                @if ($cuti->file_lampiran)
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Berkas Lampiran</dt>
                                        <dd class="mt-1">
                                            <a href="{{ route('verifikasi-cuti.view-berkas', $cuti) }}" target="_blank"
                                                class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs font-bold rounded-md hover:bg-blue-600">
                                                Lihat Lampiran
                                            </a>
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        {{-- Panel Aksi Verifikasi --}}
                        <div class="bg-gray-50 p-6 rounded-lg shadow-inner">
                            <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Tindakan Verifikasi</h4>
                            <div class="flex items-center justify-start space-x-4">
                                <button
                                    @click="openModal('approve', 'Konfirmasi Persetujuan', '{{ route('verifikasi-cuti.approve', $cuti->id) }}')"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">Setujui</button>
                                <button
                                    @click="openModal('reject', 'Konfirmasi Penolakan', '{{ route('verifikasi-cuti.reject', $cuti->id) }}')"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">Tolak</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL KONFIRMASI --}}
        <div x-show="showModal" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
            <div @click="showModal = false" class="fixed inset-0 bg-black/50"></div>
            <div
                class="relative w-full max-w-lg overflow-hidden rounded-lg bg-white shadow-xl transform transition-all p-6">
                <h3 class="text-lg font-medium text-gray-900" x-text="modalTitle"></h3>
                <form :action="formAction" method="POST" class="mt-4">
                    @csrf
                    {{-- Simpan action form jika validasi gagal --}}
                    <input type="hidden" name="form_action" :value="formAction">

                    <p x-show="modalType === 'approve'" class="text-sm text-gray-600">Apakah Anda yakin ingin menyetujui
                        pengajuan cuti ini?</p>
                    <div x-show="modalType === 'reject'">
                        <p class="text-sm text-gray-600 mb-4">Harap berikan alasan penolakan.</p>
                        <x-input-label for="keterangan_penolakan" value="Alasan Penolakan (Wajib Diisi)" />
                        <textarea name="keterangan_penolakan" id="keterangan_penolakan" rows="4"
                            class="block mt-1 w-full rounded-md shadow-sm border-gray-300" :required="modalType === 'reject'">{{ old('keterangan_penolakan') }}</textarea>
                        <x-input-error :messages="$errors->get('keterangan_penolakan')" class="mt-2" />
                    </div>
                    <div class="mt-6 flex flex-row-reverse space-x-2 space-x-reverse">
                        <button type="submit"
                            :class="{ 'bg-green-600 hover:bg-green-700': modalType === 'approve', 'bg-red-600 hover:bg-red-700': modalType === 'reject' }"
                            class="inline-flex justify-center rounded-md border border-transparent px-4 py-2 text-base font-medium text-white shadow-sm sm:text-sm">Ya,
                            Lanjutkan</button>
                        <button @click="showModal = false" type="button"
                            class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 sm:text-sm">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
