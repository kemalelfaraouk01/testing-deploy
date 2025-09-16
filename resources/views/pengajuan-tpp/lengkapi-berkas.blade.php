<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lengkapi Berkas Pengajuan TPP
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-6">

            <!-- Card Panduan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-xl">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Panduan Upload Berkas TPP</h3>
                            <p class="text-sm text-gray-600">Periode: <span class="font-bold">{{ $namaBulan }}
                                    {{ $pengajuanTpp->periode_tahun }}</span> untuk <span
                                    class="font-bold">{{ $opd->nama_opd }}</span></p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <h4 class="text-sm font-semibold text-gray-900 flex items-center">
                                <svg class="w-4 h-4 text-orange-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 18.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                                Persyaratan File
                            </h4>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li class="flex items-start"><span
                                        class="inline-block w-1.5 h-1.5 bg-blue-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>Format
                                    file: PDF</li>
                                <li class="flex items-start"><span
                                        class="inline-block w-1.5 h-1.5 bg-blue-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>Maksimal
                                    ukuran file: 1MB per file</li>
                                <li class="flex items-start"><span
                                        class="inline-block w-1.5 h-1.5 bg-blue-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>File
                                    harus dapat dibaca dengan jelas</li>
                            </ul>
                        </div>
                        <div class="space-y-3">
                            <h4 class="text-sm font-semibold text-gray-900 flex items-center">
                                <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Cara Upload
                            </h4>
                            <ol class="space-y-2 text-sm text-gray-600">
                                <li class="flex items-start"><span
                                        class="inline-flex items-center justify-center w-5 h-5 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mr-2 mt-0.5 flex-shrink-0">1</span>Klik
                                    "Pilih File" untuk setiap jenis berkas</li>
                                <li class="flex items-start"><span
                                        class="inline-flex items-center justify-center w-5 h-5 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mr-2 mt-0.5 flex-shrink-0">2</span>Pastikan
                                    semua berkas telah dipilih</li>
                                <li class="flex items-start"><span
                                        class="inline-flex items-center justify-center w-5 h-5 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mr-2 mt-0.5 flex-shrink-0">3</span>Klik
                                    "Kirim Pengajuan"</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Upload -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-xl">
                    <h3 class="text-lg font-semibold text-gray-900">Formulir Upload Berkas</h3>
                </div>

                <form method="POST" action="{{ route('pengajuan-tpp.submit-berkas', $pengajuanTpp->id) }}"
                    enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        @php
                            $berkas_tpp = [
                                [
                                    'name' => 'berkas_tpp',
                                    'label' => 'Daftar TPP',
                                    'desc' => 'Daftar Tambahan Penghasilan Pegawai.',
                                    'required' => true,
                                ],
                                [
                                    'name' => 'berkas_spj',
                                    'label' => 'Surat Keterangan SPJ-TU Nihil dari BKPAD',
                                    'desc' => 'Surat Keterangan SPJ-TU Nihil.',
                                    'required' => true,
                                ],
                                [
                                    'name' => 'berkas_pernyataan',
                                    'label' => 'Surat Pernyataan Tanggung Jawab Mutlak OPD',
                                    'desc' => 'Surat Pernyataan Tanggung Jawab Mutlak.',
                                    'required' => true,
                                ],
                                [
                                    'name' => 'berkas_pengantar',
                                    'label' => 'surat Pengantar dari Atasan OPD Yang Bersangkutan',
                                    'desc' => 'Surat pengantar resmi dari OPD.',
                                    'required' => true,
                                ],
                            ];
                        @endphp

                        @foreach ($berkas_tpp as $index => $file)
                            <div x-data="{ fileSelected: {{ $pengajuanTpp->{$file['name']} ? 'true' : 'false' }}, fileName: '{{ $pengajuanTpp->{$file['name']} ? basename($pengajuanTpp->{$file['name']}) : '' }}' }" class="relative group">
                                <div
                                    class="p-5 border-2 border-dashed border-gray-200 rounded-lg hover:border-blue-300 transition-all">
                                    <div class="flex items-start space-x-3 mb-4">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-gray-900">{{ $index + 1 }}.
                                                {{ $file['label'] }}</h4>
                                            <p class="text-xs text-gray-500 mt-1">{{ $file['desc'] }}</p>
                                        </div>
                                    </div>

                                    <div class="relative">
                                        <input x-ref="fileInput{{ $index }}"
                                            @change="fileSelected = true; fileName = $event.target.files[0]?.name || ''"
                                            type="file" name="{{ $file['name'] }}" id="{{ $file['name'] }}"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                            accept=".pdf">
                                        <div
                                            class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg bg-white">
                                            <div class="flex items-center space-x-2 text-sm">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 13h6m-2-2v4" />
                                                </svg>
                                                <span class="text-gray-600 font-medium"
                                                    x-text="fileName ? 'Ganti File' : 'Pilih File'">Pilih File</span>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($pengajuanTpp->{$file['name']})
                                        <div class="mt-2 text-xs text-gray-600">
                                            <a href="{{ Storage::url($pengajuanTpp->{$file['name']}) }}"
                                                target="_blank"
                                                class="inline-flex items-center space-x-1 text-blue-600 hover:underline">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                <span>Lihat file yang sudah diunggah</span>
                                            </a>
                                        </div>
                                    @endif

                                    <div x-show="fileSelected && fileName" x-transition
                                        class="mt-3 flex items-center justify-between bg-green-50 border border-green-200 rounded-md p-2">
                                        <div class="flex items-center space-x-2 min-w-0">
                                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span x-text="fileName"
                                                class="text-xs text-green-700 font-medium truncate"></span>
                                        </div>
                                        <button
                                            @click.prevent="$refs.fileInput{{ $index }}.value = null; fileSelected = false; fileName = '{{ $pengajuanTpp->{$file['name']} ? basename($pengajuanTpp->{$file['name']}) : '' }}'"
                                            type="button"
                                            class="flex-shrink-0 text-gray-500 hover:text-red-600 p-1 rounded-full hover:bg-red-100 transition-colors">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    <x-input-error :messages="$errors->get($file['name'])" class="mt-2" />
                                </div>
                            </div>
                        @endforeach
                    </div>

                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('pengajuan-tpp.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Simpan sebagai Draft & Kembali
                            </a>
                            <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ __('Kirim Pengajuan') }}
                            </x-primary-button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
