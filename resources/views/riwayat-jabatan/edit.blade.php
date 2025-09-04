<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Riwayat Jabatan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        Mengubah Riwayat Jabatan untuk: {{ $riwayatJabatan->pegawai->nama_lengkap }}
                    </h3>

                    <form action="{{ route('riwayat-jabatan.update', $riwayatJabatan->id) }}" method="POST"
                        class="mt-4 space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <x-input-label for="jabatan" value="Jabatan" />
                                <x-text-input id="jabatan" name="jabatan" type="text" class="mt-1 block w-full"
                                    :value="old('jabatan', $riwayatJabatan->jabatan)" required />
                                <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="unit_kerja" value="Unit Kerja" />
                                <x-text-input id="unit_kerja" name="unit_kerja" type="text" class="mt-1 block w-full"
                                    :value="old('unit_kerja', $riwayatJabatan->unit_kerja)" required />
                                <x-input-error :messages="$errors->get('unit_kerja')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="jenis_jabatan" value="Jenis Jabatan" />
                                <select name="jenis_jabatan" id="jenis_jabatan"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                                    <option value="Struktural"
                                        {{ old('jenis_jabatan', $riwayatJabatan->jenis_jabatan) == 'Struktural' ? 'selected' : '' }}>
                                        Struktural</option>
                                    <option value="Fungsional"
                                        {{ old('jenis_jabatan', $riwayatJabatan->jenis_jabatan) == 'Fungsional' ? 'selected' : '' }}>
                                        Fungsional</option>
                                    <option value="Pelaksana"
                                        {{ old('jenis_jabatan', $riwayatJabatan->jenis_jabatan) == 'Pelaksana' ? 'selected' : '' }}>
                                        Pelaksana</option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis_jabatan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tmt_jabatan" value="TMT Jabatan" />
                                <x-text-input id="tmt_jabatan" name="tmt_jabatan" type="date"
                                    class="mt-1 block w-full" :value="old('tmt_jabatan', $riwayatJabatan->tmt_jabatan)" required />
                                <x-input-error :messages="$errors->get('tmt_jabatan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nomor_sk" value="Nomor SK" />
                                <x-text-input id="nomor_sk" name="nomor_sk" type="text" class="mt-1 block w-full"
                                    :value="old('nomor_sk', $riwayatJabatan->nomor_sk)" required />
                                <x-input-error :messages="$errors->get('nomor_sk')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_sk" value="Tanggal SK" />
                                <x-text-input id="tanggal_sk" name="tanggal_sk" type="date" class="mt-1 block w-full"
                                    :value="old('tanggal_sk', $riwayatJabatan->tanggal_sk)" required />
                                <x-input-error :messages="$errors->get('tanggal_sk')" class="mt-2" />
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end space-x-4">
                            <a href="{{ route('pegawai.show', $riwayatJabatan->pegawai_id) }}"
                                class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                            <x-primary-button>Perbarui Riwayat</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
