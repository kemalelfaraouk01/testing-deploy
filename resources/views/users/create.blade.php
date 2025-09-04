<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah User Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="nip" :value="__('NIP')" />
                            <x-text-input id="nip" class="block mt-1 w-full" type="text" name="nip"
                                :value="old('nip')" required />
                            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                name="password_confirmation" required />
                        </div>

                        {{-- ▼▼▼ INI BAGIAN YANG DIPERBARUI DARI DROPDOWN MENJADI CHECKBOX ▼▼▼ --}}
                        <div class="mt-4">
                            <x-input-label for="roles" :value="__('Peran (Role) - Bisa pilih lebih dari satu')" />
                            <div
                                class="mt-2 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 p-4 border rounded-md">
                                @foreach ($roles as $role)
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                            {{ is_array(old('roles')) && in_array($role->name, old('roles')) ? ' checked' : '' }}>
                                        <span class="text-sm font-medium text-gray-700">{{ $role->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                        </div>
                        {{-- ▲▲▲ BATAS AKHIR PERUBAHAN ▲▲▲ --}}

                        <div class="mt-4">
                            <x-input-label for="opd_id" :value="__('Asal OPD (Opsional)')" />
                            <select name="opd_id" id="opd_id"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                <option value="">-- Tidak terikat OPD --</option>
                                @foreach ($opds as $opd)
                                    <option value="{{ $opd->id }}"
                                        @if (old('opd_id') == $opd->id) selected @endif>
                                        {{ $opd->nama_opd }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
