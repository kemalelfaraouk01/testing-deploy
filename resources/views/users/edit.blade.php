<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User: ') }} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $user->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="nip" :value="__('NIP')" />
                            <x-text-input id="nip" class="block mt-1 w-full" type="text" name="nip"
                                :value="old('nip', $user->nip)" required />
                            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password Baru (Opsional)')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                name="password_confirmation" />
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
                                            {{-- Cek apakah user sudah memiliki peran ini --}} {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                        <span class="text-sm font-medium text-gray-700">{{ $role->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                        </div>
                        {{-- ▲▲▲ BATAS AKHIR PERUBAHAN ▲▲▲ --}}

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <x-primary-button class="ml-4">
                                {{ __('Perbarui') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
