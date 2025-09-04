<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight px-2 sm:px-0">
            <span class="block sm:inline">Perbaikan Berkas TPP:</span>
            <span
                class="block sm:inline mt-1 sm:mt-0 text-base sm:text-xl font-medium sm:font-semibold text-gray-600 sm:text-gray-800">
                {{ $pengajuanTpp->opd->nama_opd }}
            </span>
        </h2>
    </x-slot>

    <div class="py-3 sm:py-6 px-3 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto space-y-4 sm:space-y-6">

            {{-- Catatan Verifikator --}}
            <div
                class="bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 rounded-lg sm:rounded-xl p-3 sm:p-6 shadow-sm">
                <div class="flex items-start gap-2 sm:gap-3">
                    <div
                        class="flex-shrink-0 w-5 h-5 sm:w-6 sm:h-6 bg-amber-100 rounded-full flex items-center justify-center mt-0.5">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-amber-800 mb-1 sm:mb-2">Catatan dari Verifikator</h3>
                        <p class="text-xs sm:text-sm text-amber-700 leading-relaxed">{{ $pengajuanTpp->keterangan }}</p>
                    </div>
                </div>
            </div>

            {{-- Form Container --}}
            <div class="bg-white rounded-lg sm:rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div
                    class="bg-gradient-to-r from-blue-50 to-indigo-50 px-3 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Unggah Berkas Perbaikan</h3>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1 leading-relaxed">
                        Unggah ulang hanya berkas yang perlu diperbaiki. Biarkan kosong jika tidak ada perubahan.
                    </p>
                </div>

                <form method="POST"
                    action="{{ route('pengajuan-tpp.update', ['pengajuanTpp' => $pengajuanTpp->id, 'hash' => request()->hash]) }}"
                    enctype="multipart/form-data" class="p-3 sm:p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4 sm:space-y-6">
                        @php
                            $fileInputs = [
                                [
                                    'name' => 'berkas_tpp',
                                    'label' => '1. Daftar TPP (PDF/Excel)',
                                    'icon' => 'document-text',
                                ],
                                [
                                    'name' => 'berkas_spj',
                                    'label' => '2. Surat Keterangan SPJ-TU Nihil (PDF/Excel)',
                                    'icon' => 'document-text',
                                ],
                                [
                                    'name' => 'berkas_pernyataan',
                                    'label' => '3. Surat Pernyataan Mutlak Kepala OPD (PDF/Excel)',
                                    'icon' => 'document-text',
                                ],
                                [
                                    'name' => 'berkas_pengantar',
                                    'label' => '4. Surat Pengantar dari Atasan (PDF/Excel)',
                                    'icon' => 'document-text',
                                ],
                            ];
                        @endphp

                        @foreach ($fileInputs as $input)
                            <div class="relative">
                                <div class="flex items-start gap-2 sm:gap-3 mb-2 sm:mb-3">
                                    <div
                                        class="flex-shrink-0 w-6 h-6 sm:w-8 sm:h-8 bg-blue-100 rounded-md sm:rounded-lg flex items-center justify-center mt-0.5">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 text-blue-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            @if ($input['icon'] === 'document-text')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            @elseif($input['icon'] === 'document-check')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            @elseif($input['icon'] === 'document-duplicate')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            @endif
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <x-input-label for="{{ $input['name'] }}" :value="$input['label']"
                                            class="text-xs sm:text-sm font-medium text-gray-900 leading-relaxed" />
                                    </div>
                                </div>

                                <div class="relative ml-8 sm:ml-0">
                                    <input type="file" name="{{ $input['name'] }}[]" id="{{ $input['name'] }}"
                                        multiple
                                        class="block w-full text-xs sm:text-sm text-gray-600 
                                               file:mr-2 sm:file:mr-4 
                                               file:py-2 sm:file:py-3 
                                               file:px-3 sm:file:px-4 
                                               file:rounded-md sm:file:rounded-lg 
                                               file:border-0 
                                               file:text-xs sm:file:text-sm 
                                               file:font-medium 
                                               file:bg-blue-50 
                                               file:text-blue-700 
                                               hover:file:bg-blue-100 
                                               border border-gray-300 
                                               rounded-md sm:rounded-lg 
                                               focus:ring-2 focus:ring-blue-500 focus:border-transparent 
                                               transition-all duration-200
                                               py-2 sm:py-0">
                                </div>

                                <div class="ml-8 sm:ml-0">
                                    <x-input-error :messages="$errors->get($input['name'])" class="mt-1 sm:mt-2" />
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Submit Button --}}
                    <div class="mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:justify-end">
                            <x-primary-button
                                class="w-full sm:w-auto justify-center sm:justify-start
                   px-3 sm:px-6 py-2 sm:py-2.5
                   transition-all duration-200 
                   shadow-lg hover:shadow-xl 
                   transform hover:-translate-y-0.5
                   text-sm">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                <span class="truncate">Kirim Ulang Berkas Perbaikan</span>
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
