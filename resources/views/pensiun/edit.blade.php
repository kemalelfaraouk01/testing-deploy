<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Detail Usulan Pensiun') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8 space-y-6">

            <!-- Card 1: Informasi Pegawai -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Pegawai</h3>
                    <div class="mt-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Nama Lengkap</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $pensiun->pegawai->nama_lengkap ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">NIP</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $pensiun->pegawai->user->nip ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Jabatan</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $pensiun->pegawai->jabatan ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Detail Usulan -->
            <div class="bg-white shadow-sm rounded-lg">
                <form action="{{ route('pensiun.update', $pensiun->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="hash" value="{{ $pensiun->getRouteHash() }}">
                    <div class="p-6 space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Detail Usulan</h3>
                        
                        <div>
                            <x-input-label for="tanggal_pensiun" :value="__('Tanggal Pensiun')" />
                            <x-text-input id="tanggal_pensiun" class="block w-full mt-1" type="date" name="tanggal_pensiun" :value="old('tanggal_pensiun', $pensiun->tanggal_pensiun)" required />
                            <x-input-error :messages="$errors->get('tanggal_pensiun')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="jenis_pensiun" :value="__('Jenis Pensiun')" />
                            <select id="jenis_pensiun" name="jenis_pensiun" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="BUP" @selected(old('jenis_pensiun', $pensiun->jenis_pensiun) == 'BUP')>Batas Usia Pensiun (BUP)</option>
                                <option value="Janda/Duda" @selected(old('jenis_pensiun', $pensiun->jenis_pensiun) == 'Janda/Duda')>Janda/Duda</option>
                                <option value="Atas Permintaan Sendiri" @selected(old('jenis_pensiun', $pensiun->jenis_pensiun) == 'Atas Permintaan Sendiri')>Atas Permintaan Sendiri</option>
                                <option value="Lainnya" @selected(old('jenis_pensiun', $pensiun->jenis_pensiun) == 'Lainnya')>Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status Proses')" />
                            <select id="status" name="status" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach (['Menunggu Berkas', 'Berkas Lengkap', 'Perlu Perbaikan', 'Diproses', 'Selesai'] as $status)
                                    <option value="{{ $status }}" @selected(old('status', $pensiun->status) == $status)>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 flex justify-end">
                        <x-primary-button>{{ __('Update Detail Usulan') }}</x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Card 3: Berkas & Aksi -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Berkas Persyaratan</h3>
                    @if ($pensiun->status == 'Menunggu Berkas')
                        <p class="mt-4 text-sm text-center text-gray-500 bg-gray-50 p-8 rounded-lg">Menunggu kandidat untuk mengunggah berkas persyaratan.</p>
                    @else
                        <div class="mt-4 space-y-3">
                            @foreach ($berkasFields as $field => $label)
                                <div class="flex items-center justify-between p-3 border rounded-lg">
                                    <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                                    @if ($pensiun->$field)
                                        <a href="{{ Storage::url($pensiun->$field) }}" target="_blank" class="inline-flex items-center px-3 py-1 text-sm font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                            Lihat
                                        </a>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold text-gray-500 bg-gray-100 rounded-full">Belum diunggah</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if ($pensiun->status == 'Berkas Lengkap')
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end items-center space-x-3">
                    <!-- Tombol Minta Perbaikan -->
                    <div x-data="{ open: false }">
                        <button type="button" @click="open = true" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600">
                            Minta Perbaikan
                        </button>
                        <!-- Modal -->
                        <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-50">
                            <div @click.away="open = false" class="w-full max-w-lg p-6 mx-4 bg-white rounded-lg shadow-xl">
                                <h3 class="text-lg font-medium text-gray-900">Catatan Perbaikan</h3>
                                <form action="{{ route('pensiun.request-correction', $pensiun->id) }}" method="POST" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="hash" value="{{ $pensiun->getRouteHash() }}">
                                    <div>
                                        <textarea id="catatan_perbaikan" name="catatan_perbaikan" rows="4" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Tuliskan alasan atau berkas apa yang perlu diperbaiki..." required></textarea>
                                    </div>
                                    <div class="mt-4 flex justify-end space-x-2">
                                        <button type="button" @click="open = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">Batal</button>
                                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700">Kirim Permintaan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Tombol Setujui -->
                    <form action="{{ route('pensiun.approve', $pensiun->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="hash" value="{{ $pensiun->getRouteHash() }}">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                            Setujui Usulan
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <div class="text-center mt-6">
                 <a href="{{ route('pensiun.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    &larr; Kembali ke Daftar Usulan
                </a>
            </div>
        </div>
    </div>
</x-app-layout>