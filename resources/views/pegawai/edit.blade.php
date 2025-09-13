<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Data Pegawai: {{ $pegawai->nama_lengkap }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('pegawai.update', $pegawai->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Info Akun (tidak bisa diubah) --}}
                        <div class="p-4 bg-gray-100 rounded-lg mb-6">
                            <h3 class="font-bold text-gray-800">Akun Sistem Terhubung</h3>
                            <p class="text-sm text-gray-600">Nama Akun: {{ $pegawai->user->name }}</p>
                            <p class="text-sm text-gray-600">NIP: {{ $pegawai->user->nip }}</p>
                        </div>

                        {{-- === BAGIAN DATA PRIBADI === --}}
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mt-8 mb-4">Data Pribadi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nama_lengkap" :value="__('Nama Lengkap (Sesuai Dokumen)')" />
                                <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text"
                                    name="nama_lengkap" :value="old('nama_lengkap', $pegawai->nama_lengkap)" required />
                            </div>
                            <div>
                                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                    <option value="L"
                                        {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="P"
                                        {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date"
                                    name="tanggal_lahir" :value="old('tanggal_lahir', $pegawai->tanggal_lahir)" />
                            </div>
                            <div>
                                <x-input-label for="agama" :value="__('Agama')" />
                                <x-text-input id="agama" class="block mt-1 w-full" type="text" name="agama"
                                    :value="old('agama', $pegawai->agama)" />
                            </div>
                            <div>
                                <x-input-label for="no_hp" :value="__('Nomor HP')" />
                                <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp"
                                    :value="old('no_hp', $pegawai->no_hp)" />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="old('email', $pegawai->email)" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="alamat" :value="__('Alamat')" />
                                <textarea name="alamat" id="alamat" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">{{ old('alamat', $pegawai->alamat) }}</textarea>
                            </div>
                            <div>
                                <x-input-label for="foto" :value="__('Ganti Foto (Opsional)')" />
                                <input type="file" name="foto" id="foto"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 mt-1" />
                                @if ($pegawai->foto)
                                    <p class="text-xs text-gray-500 mt-2">Foto saat ini:</p>
                                    <img src="{{ asset('storage/' . $pegawai->foto) }}" alt="Foto saat ini"
                                        class="mt-1 h-20 w-20 object-cover rounded-md">
                                @endif
                            </div>
                        </div>

                        {{-- === BAGIAN DATA KEPEGAWAIAN === --}}
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mt-8 mb-4">Data Kepegawaian</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="opd_id" :value="__('Unit Kerja (OPD)')" />
                                <select name="opd_id" id="opd_id"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                    <option value="">-- Pilih OPD --</option>
                                    @foreach ($opds as $opd)
                                        <option value="{{ $opd->id }}"
                                            {{ old('opd_id', $pegawai->opd_id) == $opd->id ? 'selected' : '' }}>
                                            {{ $opd->nama_opd }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="jabatan" :value="__('Jabatan')" />
                                <x-text-input id="jabatan" class="block mt-1 w-full" type="text" name="jabatan"
                                    :value="old('jabatan', $pegawai->jabatan)" />
                                <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="pangkat" :value="__('Pangkat')" />
                                <x-text-input id="pangkat" class="block mt-1 w-full" type="text" name="pangkat"
                                    :value="old('pangkat', $pegawai->pangkat)" />
                            </div>
                            <div>
                                <x-input-label for="golongan" :value="__('Golongan')" />
                                <x-text-input id="golongan" class="block mt-1 w-full" type="text" name="golongan"
                                    :value="old('golongan', $pegawai->golongan)" />
                            </div>
                            <div>
                                <x-input-label for="status_kepegawaian" :value="__('Status Kepegawaian')" />
                                <select name="status_kepegawaian" id="status_kepegawaian"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">-- Pilih Status --</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}"
                                            {{ old('status_kepegawaian', $pegawai->status_kepegawaian) == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('status_kepegawaian')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tmt_pns" :value="__('TMT PNS')" />
                                <x-text-input id="tmt_pns" class="block mt-1 w-full" type="date" name="tmt_pns"
                                    :value="old('tmt_pns', $pegawai->tmt_pns)" />
                            </div>
                            <div>
                                <x-input-label for="tmt_jabatan" :value="__('TMT jabatan')" />
                                <x-text-input id="tmt_jabatan" class="block mt-1 w-full" type="date"
                                    name="tmt_jabatan" :value="old('tmt_jabatan', $pegawai->tmt_jabatan)" />
                            </div>
                            <div>
                                <x-input-label for="nomor_sk_pns" :value="__('Nomor SK PNS')" />
                                <x-text-input id="nomor_sk_pns" class="block mt-1 w-full" type="text"
                                    name="nomor_sk_pns" :value="old('nomor_sk_pns', $pegawai->nomor_sk_pns)" />
                            </div>
                        </div>

                        {{-- Tambahkan input lainnya yang Anda butuhkan di sini dengan pola yang sama --}}

                        <div class="flex items-center justify-end mt-8">
                            <a href="{{ route('pegawai.index') }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button>
                                {{ __('Perbarui Data') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
