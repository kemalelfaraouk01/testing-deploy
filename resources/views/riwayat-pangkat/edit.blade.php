<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Riwayat Pangkat
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">
                    <form action="{{ route('riwayat-pangkat.update', $riwayatPangkat->id) }}" method="POST"
                        class="mt-4 space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="pangkat" value="Pangkat" />
                                <x-text-input id="pangkat" name="pangkat" type="text" class="mt-1 block w-full"
                                    :value="old('pangkat', $riwayatPangkat->pangkat)" required />
                            </div>
                            <div>
                                <x-input-label for="golongan" value="Golongan" />
                                <x-text-input id="golongan" name="golongan" type="text" class="mt-1 block w-full"
                                    :value="old('golongan', $riwayatPangkat->golongan)" required />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="jabatan" value="Jabatan" />
                                <x-text-input id="jabatan" name="jabatan" type="text" class="mt-1 block w-full"
                                    :value="old('jabatan', $riwayatPangkat->jabatan)" required />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="unit_kerja" value="Unit Kerja" />
                                <x-text-input id="unit_kerja" name="unit_kerja" type="text" class="mt-1 block w-full"
                                    :value="old('unit_kerja', $riwayatPangkat->unit_kerja)" required />
                            </div>
                            <div>
                                <x-input-label for="tmt_pangkat" value="TMT Pangkat" />
                                <x-text-input id="tmt_pangkat" name="tmt_pangkat" type="date"
                                    class="mt-1 block w-full" :value="old('tmt_pangkat', $riwayatPangkat->tmt_pangkat)" required />
                            </div>
                            <div>
                                <x-input-label for="nomor_sk" value="Nomor SK" />
                                <x-text-input id="nomor_sk" name="nomor_sk" type="text" class="mt-1 block w-full"
                                    :value="old('nomor_sk', $riwayatPangkat->nomor_sk)" required />
                            </div>
                            <div>
                                <x-input-label for="tanggal_sk" value="Tanggal SK" />
                                <x-text-input id="tanggal_sk" name="tanggal_sk" type="date" class="mt-1 block w-full"
                                    :value="old('tanggal_sk', $riwayatPangkat->tanggal_sk)" required />
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end space-x-4">
                            <a href="{{ route('pegawai.show', $riwayatPangkat->pegawai_id) }}"
                                class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                            <x-primary-button>Perbarui Riwayat</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
