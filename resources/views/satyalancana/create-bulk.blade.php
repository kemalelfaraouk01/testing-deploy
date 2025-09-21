<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lengkapi Detail Usulan Satyalancana') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('satyalancana.store') }}" method="POST">
                @csrf
                <input type="hidden" name="masa_kerja" value="{{ $masa_kerja }}">
                <input type="hidden" name="periode" value="{{ $periode }}">

                <div class="bg-white rounded-2xl shadow-lg">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-bold">Konfirmasi Usulan untuk {{ count($pegawais) }} Kandidat</h3>
                        <p class="text-sm text-gray-600">Masa Kerja: <span class="font-semibold">{{ $masa_kerja }} Tahun</span></p>
                        <p class="text-sm text-gray-600">Periode: <span class="font-semibold">{{ $periode }}</span></p>
                    </div>

                    <div class="divide-y">
                        @foreach ($pegawais as $pegawai)
                            <div class="p-6 space-y-4">
                                <input type="hidden" name="proposals[{{ $pegawai->id }}][pegawai_id]" value="{{ $pegawai->id }}">

                                {{-- Informasi Pegawai --}}
                                <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                                    <p class="font-bold text-blue-800">{{ $pegawai->nama_lengkap }}</p>
                                    <p class="text-sm text-gray-600">NIP: {{ $pegawai->user->nip ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600">OPD: {{ $pegawai->opd->nama_opd ?? 'N/A' }}</p>
                                </div>

                                {{-- Form Inputs --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div>
                                        <label for="no_sk_hukdis_{{ $pegawai->id }}" class="block text-sm font-medium text-gray-700">No. SK Hukdis</label>
                                        <input type="text" name="proposals[{{ $pegawai->id }}][no_sk_hukdis]" id="no_sk_hukdis_{{ $pegawai->id }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    <div>
                                        <label for="no_sk_cltn_{{ $pegawai->id }}" class="block text-sm font-medium text-gray-700">No. SK CLTN</label>
                                        <input type="text" name="proposals[{{ $pegawai->id }}][no_sk_cltn]" id="no_sk_cltn_{{ $pegawai->id }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    <div>
                                        <label for="slks_lama_{{ $pegawai->id }}" class="block text-sm font-medium text-gray-700">SLKS Lama</label>
                                        <select name="proposals[{{ $pegawai->id }}][slks_lama]" id="slks_lama_{{ $pegawai->id }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @foreach ($slksLamaOptions as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="no_keppres_{{ $pegawai->id }}" class="block text-sm font-medium text-gray-700">No. Keppres</label>
                                        <input type="text" name="proposals[{{ $pegawai->id }}][no_keppres]" id="no_keppres_{{ $pegawai->id }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    <div>
                                        <label for="tanggal_keppres_{{ $pegawai->id }}" class="block text-sm font-medium text-gray-700">Tgl. Keppres</label>
                                        <input type="date" name="proposals[{{ $pegawai->id }}][tanggal_keppres]" id="tanggal_keppres_{{ $pegawai->id }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    <div>
                                        <label for="ms_tms_{{ $pegawai->id }}" class="block text-sm font-medium text-gray-700">MS/TMS</label>
                                        <select name="proposals[{{ $pegawai->id }}][ms_tms]" id="ms_tms_{{ $pegawai->id }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @foreach ($msTmsOptions as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md:col-span-3">
                                        <label for="keterangan_operator_{{ $pegawai->id }}" class="block text-sm font-medium text-gray-700">Keterangan</label>
                                        <textarea name="proposals[{{ $pegawai->id }}][keterangan_operator]" id="keterangan_operator_{{ $pegawai->id }}" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="p-6 bg-gray-50 rounded-b-2xl">
                        <div class="flex justify-end">
                            <a href="{{ route('satyalancana.index') }}" class="text-gray-600 hover:text-gray-900 mr-4 self-center">Batal</a>
                            <x-primary-button type="submit">
                                Simpan dan Usulkan Semua
                            </x-primary-button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
