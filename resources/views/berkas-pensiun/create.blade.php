<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lengkapi Berkas Persyaratan Pensiun') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Catatan Perbaikan --}}
                    @if ($pensiun->status == 'Perlu Perbaikan' && $pensiun->catatan_perbaikan)
                        <div class="mb-6 p-4 bg-yellow-50 border-l-4 border-yellow-400">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.21 3.03-1.742 3.03H4.42c-1.532 0-2.492-1.696-1.742-3.03l5.58-9.92zM10 13a1 1 0 110-2 1 1 0 010 2zm-1-8a1 1 0 00-1 1v3a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-bold text-yellow-800">Perhatian: Usulan Anda perlu perbaikan.</p>
                                    <p class="mt-1 text-sm text-yellow-700">Catatan dari operator: "{{ $pensiun->catatan_perbaikan }}"</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <h3 class="text-lg font-bold mb-4">Usulan Pensiun untuk: {{ $pensiun->pegawai->nama_lengkap }}</h3>

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('berkas-pensiun.store', $pensiun->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="hash" value="{{ request()->get('hash') }}">

                        <div class="space-y-6">
                            @foreach ($berkasFields as $field => $label)
                                <div>
                                    <label for="{{ $field }}" class="block text-sm font-medium text-gray-700">
                                        {{ $label }}
                                        @if($field !== 'berkas_lainnya')
                                            <span class="text-red-500">*</span>
                                        @endif
                                    </label>
                                    <div class="mt-1">
                                        <input type="file" name="{{ $field }}" id="{{ $field }}" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                                    </div>
                                    @if ($pensiun->$field)
                                        <div class="mt-2 text-sm text-gray-500">
                                            File saat ini: <a href="{{ Storage::url($pensiun->$field) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Berkas</a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Simpan dan Kirim Berkas
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
