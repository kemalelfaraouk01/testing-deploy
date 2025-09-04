<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Usulan Pensiun') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('pensiun.update', $pensiun->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            {{-- ▼▼▼ INI BAGIAN YANG DIPERBAIKI (FINAL) ▼▼▼ --}}
                            <div>
                                <x-input-label for="pegawai_nama" :value="__('Pegawai')" />

                                @php
                                    $namaLengkap = '[Data Pegawai Tidak Ditemukan]';
                                    $nip = '';

                                    if ($pensiun->pegawai) {
                                        $namaLengkap = $pensiun->pegawai->nama_lengkap ?: '[Nama Pegawai Kosong]';
                                        // Ambil NIP dari relasi user
                                        $nip = $pensiun->pegawai->user->nip ?? '[NIP tidak ditemukan]';
                                    }

                                    $namaTampil = $namaLengkap . ' (' . $nip . ')';
                                @endphp

                                <x-text-input id="pegawai_nama" class="block w-full mt-1 bg-gray-100" type="text"
                                    name="pegawai_nama" :value="$namaTampil" disabled />

                                <p class="mt-2 text-sm text-gray-600">Nama pegawai tidak dapat diubah.</p>
                            </div>
                            {{-- ▲▲▲ BATAS AKHIR PERBAIKAN ▲▲▲ --}}

                            {{-- Form lainnya tetap sama --}}
                            <div>
                                <x-input-label for="tanggal_pensiun" :value="__('Tanggal Pensiun')" />
                                <x-text-input id="tanggal_pensiun" class="block w-full mt-1" type="date"
                                    name="tanggal_pensiun" :value="old('tanggal_pensiun', $pensiun->tanggal_pensiun)" required />
                                <x-input-error :messages="$errors->get('tanggal_pensiun')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="jenis_pensiun" :value="__('Jenis Pensiun')" />
                                <select id="jenis_pensiun" name="jenis_pensiun"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="BUP" @selected(old('jenis_pensiun', $pensiun->jenis_pensiun) == 'BUP')>Batas Usia Pensiun (BUP)
                                    </option>
                                    <option value="Janda/Duda" @selected(old('jenis_pensiun', $pensiun->jenis_pensiun) == 'Janda/Duda')>Janda/Duda</option>
                                    <option value="Atas Permintaan Sendiri" @selected(old('jenis_pensiun', $pensiun->jenis_pensiun) == 'Atas Permintaan Sendiri')>Atas Permintaan
                                        Sendiri</option>
                                    <option value="Lainnya" @selected(old('jenis_pensiun', $pensiun->jenis_pensiun) == 'Lainnya')>Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="status" :value="__('Status Proses')" />
                                <select id="status" name="status"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Diusulkan" @selected(old('status', $pensiun->status) == 'Diusulkan')>Diusulkan</option>
                                    <option value="Diproses" @selected(old('status', $pensiun->status) == 'Diproses')>Diproses</option>
                                    <option value="Selesai" @selected(old('status', $pensiun->status) == 'Selesai')>Selesai</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-primary-button>
                                {{ __('Update Usulan') }}
                            </x-primary-button>
                            <a href="{{ route('pensiun.index') }}" class="ml-4 text-gray-600 hover:text-gray-900">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
