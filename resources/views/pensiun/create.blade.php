<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Usulan Pensiun Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- ▼▼▼ PERBAIKAN DI SINI: Menggunakan $pegawaiRekomendasi ▼▼▼ --}}
                    @if ($pegawaiRekomendasi->isEmpty())
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                            <p class="font-bold">Informasi</p>
                            <p>Saat ini tidak ada pegawai aktif yang memenuhi kriteria usia pensiun (58 tahun atau
                                lebih).</p>
                        </div>
                    @else
                        <form action="{{ route('pensiun.store') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="pegawai_id" :value="__('Pilih Pegawai (Direkomendasikan berdasarkan Usia)')" />
                                    <select id="pegawai_id" name="pegawai_id"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">-- Pilih Pegawai --</option>

                                        {{-- ▼▼▼ PERBAIKAN DI SINI: Menggunakan $pegawaiRekomendasi ▼▼▼ --}}
                                        @foreach ($pegawaiRekomendasi as $pegawai)
                                            <option value="{{ $pegawai->id }}">
                                                {{ $pegawai->nama_lengkap }} (Usia:
                                                {{ \Carbon\Carbon::parse($pegawai->tanggal_lahir)->age }} tahun)
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('pegawai_id')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="tanggal_pensiun" :value="__('Tanggal Pensiun')" />
                                    {{-- Kode ini sudah benar. Format tampilan akan menyesuaikan browser pengguna --}}
                                    <x-text-input id="tanggal_pensiun" class="block mt-1 w-full" type="date"
                                        name="tanggal_pensiun" :value="old('tanggal_pensiun')" required />
                                    <x-input-error :messages="$errors->get('tanggal_pensiun')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="jenis_pensiun" :value="__('Jenis Pensiun')" />
                                    <select id="jenis_pensiun" name="jenis_pensiun"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="BUP">Batas Usia Pensiun (BUP)</option>
                                        <option value="Janda/Duda">Janda/Duda</option>
                                        <option value="Atas Permintaan Sendiri">Atas Permintaan Sendiri</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('jenis_pensiun')" class="mt-2" />
                                </div>
                            </div>

                            <div class="mt-4">
                                <x-primary-button>
                                    {{ __('Simpan Usulan') }}
                                </x-primary-button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
