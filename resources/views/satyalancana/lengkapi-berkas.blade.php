<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lengkapi Berkas Usulan Satyalancana
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Card Panduan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div
                    class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-xl">
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
                            <h3 class="text-lg font-semibold text-gray-900">Panduan Upload Berkas</h3>
                            <p class="text-sm text-gray-600">Baca panduan berikut sebelum mengupload berkas Satyalancana</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Persyaratan File -->
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
                                <li class="flex items-start">
                                    <span
                                        class="inline-block w-1.5 h-1.5 bg-blue-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                    Format file: PDF, JPG, PNG
                                </li>
                                <li class="flex items-start">
                                    <span
                                        class="inline-block w-1.5 h-1.5 bg-blue-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                    Maksimal ukuran file: 1MB per file
                                </li>
                                <li class="flex items-start">
                                    <span
                                        class="inline-block w-1.5 h-1.5 bg-blue-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                    File harus dapat dibaca dengan jelas
                                </li>
                            </ul>
                        </div>

                        <!-- Langkah Upload -->
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
                                <li class="flex items-start">
                                    <span
                                        class="inline-flex items-center justify-center w-5 h-5 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mr-2 mt-0.5 flex-shrink-0">1</span>
                                    Klik "Pilih File" untuk setiap jenis berkas
                                </li>
                                <li class="flex items-start">
                                    <span
                                        class="inline-flex items-center justify-center w-5 h-5 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mr-2 mt-0.5 flex-shrink-0">2</span>
                                    Pilih file dari komputer Anda
                                </li>
                                <li class="flex items-start">
                                    <span
                                        class="inline-flex items-center justify-center w-5 h-5 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mr-2 mt-0.5 flex-shrink-0">3</span>
                                    Pastikan semua berkas wajib telah dipilih
                                </li>
                                <li class="flex items-start">
                                    <span
                                        class="inline-flex items-center justify-center w-5 h-5 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mr-2 mt-0.5 flex-shrink-0">4</span>
                                    Klik "Kirim Semua Berkas"
                                </li>
                            </ol>
                        </div>
                    </div>

                    @if ($satyalancana->status == 'perlu_perbaikan' && $satyalancana->keterangan)
                        <!-- Catatan Perbaikan -->
                        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 18.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                                <div>
                                    <h5 class="text-sm font-medium text-yellow-800">Catatan Perbaikan dari Verifikator</h5>
                                    <p class="text-sm text-yellow-700 mt-1">
                                        "{{ $satyalancana->keterangan }}"
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Form Upload -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <!-- Header Section -->
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-xl">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Pengajuan untuk {{ $satyalancana->pegawai->nama_lengkap }}
                            </h3>
                            <p class="text-sm text-gray-600">
                                Satyalancana Karya Satya {{ $satyalancana->masa_kerja }} Tahun
                            </p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('satyalancana.berkas.update', $satyalancana->id) }}" enctype="multipart/form-data"
                    class="p-6">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">Terjadi Kesalahan!</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-4">
                        @php
                        $berkas = [
                            ['name' => 'file_drh', 'label' => 'Daftar Riwayat Hidup (DRH)', 'desc' => 'File dalam format PDF, JPG, atau PNG', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'required' => true],
                            ['name' => 'file_sk_cpns', 'label' => 'SK CPNS (Legalisir)', 'desc' => 'SK Calon Pegawai Negeri Sipil', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'required' => true],
                            ['name' => 'file_sk_pangkat_terakhir', 'label' => 'SK Pangkat Terakhir (Legalisir)', 'desc' => 'Surat Keputusan Pangkat terakhir', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'required' => true],
                            ['name' => 'file_sk_jabatan_terakhir', 'label' => 'SK Jabatan Terakhir (Legalisir)', 'desc' => 'Surat Keputusan Jabatan terakhir', 'icon' => 'M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'required' => true],
                            ['name' => 'file_surat_pernyataan_disiplin', 'label' => 'Surat Pernyataan Hukuman Disiplin', 'desc' => 'Tidak pernah dijatuhi hukuman disiplin', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'required' => true],
                            ['name' => 'file_skp', 'label' => 'SKP / Penilaian Kinerja', 'desc' => 'Sasaran Kinerja Pegawai 2 tahun terakhir', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'required' => true],
                            ['name' => 'file_sptjm', 'label' => 'SPTJM (Opsional)', 'desc' => 'Surat Pernyataan Tanggung Jawab Mutlak', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'required' => false],
                            ['name' => 'file_piagam_sebelumnya', 'label' => 'Piagam SLKS Sebelumnya (Opsional)', 'desc' => 'Jika pernah menerima penghargaan sebelumnya', 'icon' => 'M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'required' => false],
                        ];
                        @endphp

                        @foreach ($berkas as $index => $file)
                            <div x-data="{ fileSelected: {{ $satyalancana->{$file['name']} ? 'true' : 'false' }}, fileName: '{{ $satyalancana->{$file['name']} ? basename($satyalancana->{$file['name']}) : '' }}' }" class="relative group">
                                <div
                                    class="p-5 border-2 border-dashed border-gray-200 rounded-lg hover:border-blue-300 transition-all">
                                    <div class="flex items-start space-x-3 mb-4">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="{{ $file['icon'] }}" />
                                                </svg>
                                            </div>
                                        </div>
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
                                                                                accept=".pdf,.jpg,.png">
                                                                            <div
                                                                                class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg bg-white">
                                                                                <div class="flex items-center space-x-2 text-sm">
                                                                                    <svg class="w-5 h-5 text-gray-400" fill="none"
                                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                                            stroke-width="2"
                                                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 13h6m-2-2v4" />
                                                                                    </svg>
                                                                                    <span class="text-gray-600 font-medium" x-text="fileName ? 'Ganti File' : 'Pilih File'">Pilih File</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    
                                                                        @if ($satyalancana->{$file['name']})
                                                                        <div class="mt-2 text-xs text-gray-600">
                                                                            <a href="{{ Storage::url($satyalancana->{$file['name']}) }}" target="_blank" class="inline-flex items-center space-x-1 text-blue-600 hover:underline">
                                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
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
                                                                                @click.prevent="$refs.fileInput{{ $index }}.value = null; fileSelected = false; fileName = '{{ $satyalancana->{$file['name']} ? basename($satyalancana->{$file['name']}) : '' }}'"
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

                    <div
                        class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-8 border-t border-gray-100 mt-8">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 shadow-sm">
                            Kirim Semua Berkas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>