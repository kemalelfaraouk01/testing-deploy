<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Tabel Data User</h3>
                        <a href="{{ route('users.create') }}"
                            class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah User
                        </a>
                    </div>

                    {{-- Form Pencarian --}}
                    <form action="{{ route('users.index') }}" method="GET" class="mb-4">
                        <div class="flex items-center">
                            <input type="text" name="search" placeholder="Cari nama atau NIP..."
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full sm:w-1/3"
                                value="{{ request('search') }}">
                            <button type="submit"
                                class="ml-2 inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                Cari
                            </button>
                        </div>
                    </form>

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto bg-white rounded-lg shadow-sm border">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    {{-- ▼▼▼ 1. KOLOM "NO" DITAMBAHKAN DI SINI ▼▼▼ --}}
                                    <th
                                        class="sticky left-0 bg-gray-50 z-10 px-3 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-r border-gray-200 min-w-[60px]">
                                        No
                                    </th>
                                    <th
                                        class="px-3 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-r border-gray-200">
                                        ID
                                    </th>
                                    <th
                                        class="sticky left-[60px] bg-gray-50 z-10 px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-r border-gray-200 min-w-[200px]">
                                        Nama
                                    </th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider min-w-[150px]">
                                        NIP
                                    </th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider min-w-[200px]">
                                        Peran (Role)
                                    </th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider min-w-[120px]">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($users as $index => $user)
                                    <tr class="hover:bg-gray-50">
                                        {{-- ▼▼▼ 2. DATA NOMOR DITAMBAHKAN DI SINI ▼▼▼ --}}
                                        <td
                                            class="sticky left-0 bg-white hover:bg-gray-50 z-10 px-3 py-4 text-sm text-gray-900 border-r border-gray-200">
                                            {{ $users->firstItem() + $index }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-900 border-r border-gray-200">
                                            {{ $user->id }}
                                        </td>
                                        <td
                                            class="sticky left-[60px] bg-white hover:bg-gray-50 z-10 px-4 py-4 border-r border-gray-200">
                                            <div class="text-sm font-semibold text-gray-900">
                                                {{ $user->name }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-900">
                                            {{ $user->nip }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-900">
                                            @if (!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $roleName)
                                                    <span
                                                        class="bg-blue-200 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $roleName }}</span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-sm font-medium">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 text-xs font-medium bg-indigo-50 hover:bg-indigo-100 px-2 py-1 rounded transition-colors text-center">Edit</a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    class="inline-block"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 text-xs font-medium bg-red-50 hover:bg-red-100 px-2 py-1 rounded transition-colors">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        {{-- ▼▼▼ 3. COLSPAN DISESUAIKAN MENJADI 5 ▼▼▼ --}}
                                        <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                            <p class="text-lg font-medium text-gray-900 mb-1">Tidak ada data user</p>
                                            <p class="text-sm text-gray-500">Data user belum tersedia untuk ditampilkan.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2 text-xs text-gray-500 flex items-center justify-center sm:hidden">
                        Geser tabel untuk melihat kolom lainnya
                    </div>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
