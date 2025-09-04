<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                {{ __('Lengkapi Berkas Usulan Satyalancana') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if ($satyalancana->status == 'perlu_perbaikan' && $satyalancana->keterangan)
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded-lg" role="alert">
                    <p class="font-bold">Catatan Perbaikan dari Verifikator:</p>
                    <p>{{ $satyalancana->keterangan }}</p>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">

                    {{-- Informasi Pengajuan --}}
                    <div class="mb-6 pb-4 border-b">
                        <h3 class="text-lg font-bold text-gray-800">Pengajuan untuk
                            {{ $satyalancana->pegawai->nama_lengkap }}</h3>
                        <p class="text-sm text-gray-600">Anda telah dinominasikan untuk menerima penghargaan
                            Satyalancana
                            Karya Satya **{{ $satyalancana->masa_kerja }} Tahun**. Harap unggah semua dokumen yang
                            diperlukan di bawah ini.</p>
                    </div>

                    <form method="POST" action="{{ route('satyalancana.berkas.update', $satyalancana->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Bagian Upload Berkas --}}
                        <div class="space-y-6">
                            {{-- Input File 1: DRH --}}
                            <div x-data="{ fileSelected: false }">
                                <x-input-label for="file_drh" value="1. Daftar Riwayat Hidup (DRH)" />
                                <div class="mt-1 flex items-center space-x-4">
                                    <input @change="fileSelected = true" type="file" name="file_drh" id="file_drh"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                        required />
                                    <div x-show="fileSelected" x-transition>
                                        <svg class="h-8 w-8 text-green-500" viewBox="0 0 32 32"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <style>
                                                .checkmark-circle {
                                                    stroke-dasharray: 100;
                                                    stroke-dashoffset: 100;
                                                    animation: draw-circle .5s ease-out forwards
                                                }

                                                .checkmark-check {
                                                    stroke-dasharray: 50;
                                                    stroke-dashoffset: 50;
                                                    animation: draw-check .4s .5s ease-out forwards
                                                }

                                                @keyframes draw-circle {
                                                    to {
                                                        stroke-dashoffset: 0
                                                    }
                                                }

                                                @keyframes draw-check {
                                                    to {
                                                        stroke-dashoffset: 0
                                                    }
                                                }
                                            </style>
                                            <circle class="checkmark-circle" cx="16" cy="16" r="15"
                                                fill="none" stroke="currentColor" stroke-width="2" />
                                            <path class="checkmark-check" fill="none" stroke="currentColor"
                                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 16l5 5 9-9" />
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('file_drh')" class="mt-2" />
                            </div>

                            {{-- Input File 2: SK CPNS --}}
                            <div x-data="{ fileSelected: false }">
                                <x-input-label for="file_sk_cpns" value="2. SK CPNS (Legalisir)" />
                                <div class="mt-1 flex items-center space-x-4">
                                    <input @change="fileSelected = true" type="file" name="file_sk_cpns"
                                        id="file_sk_cpns"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                        required />
                                    <div x-show="fileSelected" x-transition>
                                        <svg class="h-8 w-8 text-green-500" viewBox="0 0 32 32"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <style>
                                                .checkmark-circle {
                                                    stroke-dasharray: 100;
                                                    stroke-dashoffset: 100;
                                                    animation: draw-circle .5s ease-out forwards
                                                }

                                                .checkmark-check {
                                                    stroke-dasharray: 50;
                                                    stroke-dashoffset: 50;
                                                    animation: draw-check .4s .5s ease-out forwards
                                                }

                                                @keyframes draw-circle {
                                                    to {
                                                        stroke-dashoffset: 0
                                                    }
                                                }

                                                @keyframes draw-check {
                                                    to {
                                                        stroke-dashoffset: 0
                                                    }
                                                }
                                            </style>
                                            <circle class="checkmark-circle" cx="16" cy="16" r="15"
                                                fill="none" stroke="currentColor" stroke-width="2" />
                                            <path class="checkmark-check" fill="none" stroke="currentColor"
                                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 16l5 5 9-9" />
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('file_sk_cpns')" class="mt-2" />
                            </div>

                            {{-- Input File 3: SK Pangkat Terakhir --}}
                            <div x-data="{ fileSelected: false }">
                                <x-input-label for="file_sk_pangkat_terakhir"
                                    value="3. SK Pangkat Terakhir (Legalisir)" />
                                <div class="mt-1 flex items-center space-x-4">
                                    <input @change="fileSelected = true" type="file" name="file_sk_pangkat_terakhir"
                                        id="file_sk_pangkat_terakhir"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                        required />
                                    <div x-show="fileSelected" x-transition>
                                        <svg class="h-8 w-8 text-green-500" viewBox="0 0 32 32"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <style>
                                                .checkmark-circle {
                                                    stroke-dasharray: 100;
                                                    stroke-dashoffset: 100;
                                                    animation: draw-circle .5s ease-out forwards
                                                }

                                                .checkmark-check {
                                                    stroke-dasharray: 50;
                                                    stroke-dashoffset: 50;
                                                    animation: draw-check .4s .5s ease-out forwards
                                                }

                                                @keyframes draw-circle {
                                                    to {
                                                        stroke-dashoffset: 0
                                                    }
                                                }

                                                @keyframes draw-check {
                                                    to {
                                                        stroke-dashoffset: 0
                                                    }
                                                }
                                            </style>
                                            <circle class="checkmark-circle" cx="16" cy="16" r="15"
                                                fill="none" stroke="currentColor" stroke-width="2" />
                                            <path class="checkmark-check" fill="none" stroke="currentColor"
                                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 16l5 5 9-9" />
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('file_sk_pangkat_terakhir')" class="mt-2" />
                            </div>

                            {{-- Input File 4: SK Jabatan Terakhir --}}
                            <div x-data="{ fileSelected: false }">
                                <x-input-label for="file_sk_jabatan_terakhir"
                                    value="4. SK Jabatan Terakhir (Legalisir)" />
                                <div class="mt-1 flex items-center space-x-4">
                                    <input @change="fileSelected = true" type="file"
                                        name="file_sk_jabatan_terakhir" id="file_sk_jabatan_terakhir"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                        required />
                                    <div x-show="fileSelected" x-transition>
                                        <svg class="h-8 w-8 text-green-500" viewBox="0 0 32 32"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <style>
                                                .checkmark-circle {
                                                    stroke-dasharray: 100;
                                                    stroke-dashoffset: 100;
                                                    animation: draw-circle .5s ease-out forwards
                                                }

                                                .checkmark-check {
                                                    stroke-dasharray: 50;
                                                    stroke-dashoffset: 50;
                                                    animation: draw-check .4s .5s ease-out forwards
                                                }

                                                @keyframes draw-circle {
                                                    to {
                                                        stroke-dashoffset: 0
                                                    }
                                                }

                                                @keyframes draw-check {
                                                    to {
                                                        stroke-dashoffset: 0
                                                    }
                                                }
                                            </style>
                                            <circle class="checkmark-circle" cx="16" cy="16" r="15"
                                                fill="none" stroke="currentColor" stroke-width="2" />
                                            <path class="checkmark-check" fill="none" stroke="currentColor"
                                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 16l5 5 9-9" />
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('file_sk_jabatan_terakhir')" class="mt-2" />
                            </div>

                            {{-- Input File 5: Surat Pernyataan Disiplin --}}
                            <div x-data="{ fileSelected: false }">
                                <x-input-label for="file_surat_pernyataan_disiplin"
                                    value="5. Surat Pernyataan Tidak Pernah Dijatuhi Hukuman Disiplin" />
                                <div class="mt-1 flex items-center space-x-4">
                                    <input @change="fileSelected = true" type="file"
                                        name="file_surat_pernyataan_disiplin" id="file_surat_pernyataan_disiplin"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                        required />
                                    <div x-show="fileSelected" x-transition>
                                        <svg class="h-8 w-8 text-green-500" viewBox="0 0 32 32"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <style>
                                                .checkmark-circle {
                                                    stroke-dasharray: 100;
                                                    stroke-dashoffset: 100;
                                                    animation: draw-circle .5s ease-out forwards
                                                }

                                                .checkmark-check {
                                                    stroke-dasharray: 50;
                                                    stroke-dashoffset: 50;
                                                    animation: draw-check .4s .5s ease-out forwards
                                                }

                                                @keyframes draw-circle {
                                                    to {
                                                        stroke-dashoffset: 0
                                                    }
                                                }

                                                @keyframes draw-check {
                                                    to {
                                                        stroke-dashoffset: 0
                                                    }
                                                }
                                            </style>
                                            <circle class="checkmark-circle" cx="16" cy="16" r="15"
                                                fill="none" stroke="currentColor" stroke-width="2" />
                                            <path class="checkmark-check" fill="none" stroke="currentColor"
                                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 16l5 5 9-9" />
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('file_surat_pernyataan_disiplin')" class="mt-2" />
                            </div>

                            {{-- Input File 6: SKP --}}
                            <div x-data="{ fileSelected: false }">
                                <x-input-label for="file_skp" value="6. SKP / Penilaian Kinerja" />
                                <div class="mt-1 flex items-center space-x-4">
                                    <input @change="fileSelected = true" type="file" name="file_skp"
                                        id="file_skp"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                        required />
                                    <div x-show="fileSelected" x-transition>
                                        <svg class="h-8 w-8 text-green-500" viewBox="0 0 32 32"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <style>
                                                .checkmark-circle {
                                                    stroke-dasharray: 100;
                                                    stroke-dashoffset: 100;
                                                    animation: draw-circle .5s ease-out forwards
                                                }

                                                .checkmark-check {
                                                    stroke-dasharray: 50;
                                                    stroke-dashoffset: 50;
                                                    animation: draw-check .4s .5s ease-out forwards
                                                }

                                                @keyframes draw-circle {
                                                    to {
                                                        stroke-dashoffset: 0
                                                    }
                                                }

                                                @keyframes draw-check {
                                                    to {
                                                        stroke-dashoffset: 0
                                                    }
                                                }
                                            </style>
                                            <circle class="checkmark-circle" cx="16" cy="16" r="15"
                                                fill="none" stroke="currentColor" stroke-width="2" />
                                            <path class="checkmark-check" fill="none" stroke="currentColor"
                                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 16l5 5 9-9" />
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('file_skp')" class="mt-2" />
                            </div>

                            {{-- Input File 7: SPTJM --}}
                            <div x-data="{ fileSelected: false }">
                                <x-input-label for="file_sptjm" value="7. SPTJM (Opsional)" />
                                <div class="mt-1 flex items-center space-x-4">
                                    <input @change="fileSelected = true" type="file" name="file_sptjm"
                                        id="file_sptjm"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                    <div x-show="fileSelected" x-transition>
                                        <svg class="h-8 w-8 text-green-500" viewBox="0 0 32 32"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <style>
                                                .checkmark-circle {
                                                    stroke-dasharray: 100;
                                                    stroke-dashoffset: 100;
                                                    animation: draw-circle .5s ease-out forwards
                                                }

                                                .checkmark-check {
                                                    stroke-dasharray: 50;
                                                    stroke-dashoffset: 50;
                                                    animation: draw-check .4s .5s ease-out forwards
                                                }

                                                @keyframes draw-circle {
                                                    to {
                                                        stroke-dashoffset: 0
                                                    }
                                                }

                                                @keyframes draw-check {
                                                    to {
                                                        stroke-dashoffset: 0
                                                    }
                                                }
                                            </style>
                                            <circle class="checkmark-circle" cx="16" cy="16" r="15"
                                                fill="none" stroke="currentColor" stroke-width="2" />
                                            <path class="checkmark-check" fill="none" stroke="currentColor"
                                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 16l5 5 9-9" />
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('file_sptjm')" class="mt-2" />
                            </div>

                            {{-- Input File 8: Piagam Sebelumnya --}}
                            <div x-data="{ fileSelected: false }">
                                <x-input-label for="file_piagam_sebelumnya"
                                    value="8. Piagam SLKS Sebelumnya (Opsional)" />
                                <div class="mt-1 flex items-center space-x-4">
                                    <input @change="fileSelected = true" type="file" name="file_piagam_sebelumnya"
                                        id="file_piagam_sebelumnya"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                    <div x-show="fileSelected" x-transition>
                                        <svg class="h-8 w-8 text-green-500" viewBox="0 0 32 32"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <style>
                                                .checkmark-circle {
                                                    stroke-dasharray: 100;
                                                    stroke-dashoffset: 100;
                                                    animation: draw-circle .5s ease-out forwards
                                                }

                                                .checkmark-check {
                                                    stroke-dasharray: 50;
                                                    stroke-dashoffset: 50;
                                                    animation: draw-check .4s .5s ease-out forwards
                                                }

                                                @keyframes draw-circle {
                                                    to {
                                                        stroke-dashoffset: 0
                                                    }
                                                }

                                                @keyframes draw-check {
                                                    to {
                                                        stroke-dashoffset: 0
                                                    }
                                                }
                                            </style>
                                            <circle class="checkmark-circle" cx="16" cy="16" r="15"
                                                fill="none" stroke="currentColor" stroke-width="2" />
                                            <path class="checkmark-check" fill="none" stroke="currentColor"
                                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 16l5 5 9-9" />
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('file_piagam_sebelumnya')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-4">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Nanti
                                Saja</a>
                            <x-primary-button>
                                Kirim Semua Berkas
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
