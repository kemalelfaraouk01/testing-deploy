<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data OPD') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('opd.update', $opd->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="kode_opd" :value="__('Kode OPD')" />
                                {{-- PERUBAHAN DI SINI: Input dibuat disabled --}}
                                <x-text-input id="kode_opd" class="block mt-1 w-full bg-gray-100" type="text"
                                    name="kode_opd" :value="$opd->kode_opd" disabled />
                            </div>
                            <div>
                                <x-input-label for="nama_opd" :value="__('Nama OPD')" />
                                <x-text-input id="nama_opd" class="block mt-1 w-full" type="text" name="nama_opd"
                                    :value="old('nama_opd', $opd->nama_opd)" required />
                                <x-input-error :messages="$errors->get('nama_opd')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <textarea id="alamat" name="alamat"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('alamat', $opd->alamat) }}</textarea>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('opd.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
