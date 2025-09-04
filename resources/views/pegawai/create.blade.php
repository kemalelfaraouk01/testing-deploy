<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Pegawai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">
                    {{-- Tambahkan enctype untuk upload file --}}
                    <form method="POST" action="{{ route('pegawai.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- === BAGIAN AKUN PENGGUNA === --}}
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Akun Sistem</h3>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <x-input-label for="user_id" :value="__('Pilih Akun User (Berdasarkan NIP & Nama)')" />
                                <select name="user_id" id="user_id"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    required>
                                    <option value="">-- Pilih User --</option>
                                    @forelse ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} -
                                            (NIP: {{ $user->nip }})
                                        </option>
                                    @empty
                                        <option value="" disabled>Semua user sudah memiliki profil pegawai.
                                        </option>
                                    @endforelse
                                </select>
                                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                            </div>
                        </div>

                        {{-- === BAGIAN DATA PRIBADI === --}}
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mt-8 mb-4">Data Pribadi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nama_lengkap" :value="__('Nama Lengkap (Sesuai Dokumen)')" />
                                <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text"
                                    name="nama_lengkap" :value="old('nama_lengkap')" required />
                                <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date"
                                    name="tanggal_lahir" :value="old('tanggal_lahir')" />
                            </div>
                            <div>
                                <x-input-label for="agama" :value="__('Agama')" />
                                <x-text-input id="agama" class="block mt-1 w-full" type="text" name="agama"
                                    :value="old('agama')" />
                            </div>
                            <div>
                                <x-input-label for="no_hp" :value="__('Nomor HP')" />
                                <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp"
                                    :value="old('no_hp')" />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="old('email')" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="alamat" :value="__('Alamat')" />
                                <textarea name="alamat" id="alamat" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">{{ old('alamat') }}</textarea>
                            </div>
                            <div>
                                <x-input-label for="foto" :value="__('Upload Foto (Opsional)')" />
                                <input type="file" name="foto" id="foto"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 mt-1" />
                                <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                            </div>
                        </div>

                        {{-- === BAGIAN DATA KEPEGAWAIAN === --}}
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mt-8 mb-4">Data Kepegawaian</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="jabatan_id" :value="__('Jabatan')" />
                                <select name="jabatan_id" id="jabatan_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach ($jabatans as $jabatan)
                                        <option value="{{ $jabatan->id }}"
                                            {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                                            {{ $jabatan->nama_jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('jabatan_id')" class="mt-2" />
                            </div>

                            {{-- Dropdown OPD (BARU) --}}
                            <div>
                                <x-input-label for="opd_id" :value="__('Unit Kerja (OPD)')" />
                                <select name="opd_id" id="opd_id"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">-- Pilih OPD --</option>
                                    @foreach ($opds as $opd)
                                        <option value="{{ $opd->id }}"
                                            {{ old('opd_id') == $opd->id ? 'selected' : '' }}>
                                            {{ $opd->nama_opd }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('opd_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="pangkat" :value="__('Pangkat')" />
                                <x-text-input id="pangkat" class="block mt-1 w-full" type="text" name="pangkat"
                                    :value="old('pangkat')" />
                            </div>
                            <div>
                                <x-input-label for="golongan" :value="__('Golongan')" />
                                <x-text-input id="golongan" class="block mt-1 w-full" type="text" name="golongan"
                                    :value="old('golongan')" />
                            </div>
                            <div>
                                <x-input-label for="unit_kerja" :value="__('Unit Kerja')" />
                                <x-text-input id="unit_kerja" class="block mt-1 w-full" type="text" name="unit_kerja"
                                    :value="old('unit_kerja')" />
                            </div>
                            <div>
                                <x-input-label for="status_kepegawaian" :value="__('Status Kepegawaian')" />
                                <x-text-input id="status_kepegawaian" class="block mt-1 w-full" type="text"
                                    name="status_kepegawaian" :value="old('status_kepegawaian')" placeholder="PNS, PPPK, Honorer" />
                            </div>
                            <div>
                                <x-input-label for="tmt_pns" :value="__('TMT PNS')" />
                                <x-text-input id="tmt_pns" class="block mt-1 w-full" type="date" name="tmt_pns"
                                    :value="old('tmt_pns')" />
                            </div>
                            <div>
                                <x-input-label for="nomor_sk_pns" :value="__('Nomor SK PNS')" />
                                <x-text-input id="nomor_sk_pns" class="block mt-1 w-full" type="text"
                                    name="nomor_sk_pns" :value="old('nomor_sk_pns')" />
                            </div>
                        </div>

                        {{-- Tambahkan input lainnya yang Anda butuhkan di sini --}}

                        <div class="flex items-center justify-end mt-8">
                            <a href="{{ route('pegawai.index') }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan Data Pegawai') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
