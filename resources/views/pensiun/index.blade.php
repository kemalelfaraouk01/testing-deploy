<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pensiun') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Button Tambah --}}
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('pensiun.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            <span class="hidden sm:inline">Tambah Usulan Pensiun</span>
                            <span class="sm:hidden">Tambah</span>
                        </a>
                    </div>

                    {{-- Desktop Table View --}}
                    <div class="hidden md:block">
                        <div class="overflow-x-auto">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nama Pegawai</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tanggal Pensiun</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Jenis</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status</th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Aksi</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($dataPensiun as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $item->pegawai->nama_lengkap ?? '[Nama tidak ada]' }}</div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $item->pegawai->user->nip ?? '[NIP tidak ada]' }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($item->tanggal_pensiun)->isoFormat('D MMMM YYYY') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $item->jenis_pensiun }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if ($item->status == 'Diusulkan') bg-yellow-100 text-yellow-800 @endif
                                                    @if ($item->status == 'Diproses') bg-blue-100 text-blue-800 @endif
                                                    @if ($item->status == 'Selesai') bg-green-100 text-green-800 @endif">
                                                        {{ $item->status }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <div class="flex items-center justify-end space-x-2">
                                                        <a href="{{ route('pensiun.edit', $item->id) }}"
                                                            class="inline-flex items-center justify-center w-10 h-10 text-indigo-600 transition-colors duration-150 rounded-full hover:text-indigo-900 hover:bg-indigo-50"
                                                            title="Edit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                                viewBox="0 0 20 20" fill="currentColor">
                                                                <path
                                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                                <path fill-rule="evenodd"
                                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </a>
                                                        {{-- ▼▼▼ TOMBOL HAPUS BARU (DESKTOP) ▼▼▼ --}}
                                                        <button type="button"
                                                            x-on:click="$dispatch('open-delete-modal', { action: '{{ route('pensiun.destroy', $item->id) }}' })"
                                                            class="inline-flex items-center justify-center w-10 h-10 text-red-600 transition-colors duration-150 rounded-full hover:text-red-900 hover:bg-red-50"
                                                            title="Hapus">
                                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                                    Belum ada data usulan pensiun.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Mobile Card View --}}
                    <div class="grid grid-cols-1 gap-4 md:hidden">
                        @forelse ($dataPensiun as $item)
                            <div class="p-4 bg-white border rounded-lg shadow">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            {{ $item->pegawai->nama_lengkap ?? '[Nama tidak ada]' }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $item->pegawai->user->nip ?? '[NIP tidak ada]' }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('pensiun.edit', $item->id) }}"
                                            class="inline-flex items-center justify-center w-10 h-10 text-indigo-600 transition-colors duration-150 rounded-full hover:text-indigo-900 hover:bg-indigo-50"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        {{-- ▼▼▼ TOMBOL HAPUS BARU (MOBILE) ▼▼▼ --}}
                                        <button type="button"
                                            x-on:click="$dispatch('open-delete-modal', { action: '{{ route('pensiun.destroy', $item->id) }}' })"
                                            class="inline-flex items-center justify-center w-10 h-10 text-red-600 transition-colors duration-150 rounded-full hover:text-red-900 hover:bg-red-50"
                                            title="Hapus">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="flex items-center justify-between text-sm text-gray-600">
                                        <span>Tanggal Pensiun:</span>
                                        <span>{{ \Carbon\Carbon::parse($item->tanggal_pensiun)->isoFormat('D MMM YYYY') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between mt-2 text-sm text-gray-600">
                                        <span>Status:</span>
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if ($item->status == 'Diusulkan') bg-yellow-100 text-yellow-800 @endif
                                        @if ($item->status == 'Diproses') bg-blue-100 text-blue-800 @endif
                                        @if ($item->status == 'Selesai') bg-green-100 text-green-800 @endif">
                                            {{ $item->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-2">Belum ada data usulan pensiun.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $dataPensiun->links() }}
                    </div>

                    {{-- ▼▼▼ PANGGIL KOMPONEN MODAL DI SINI ▼▼▼ --}}
                    <x-confirm-delete-modal title="Konfirmasi Hapus Data">
                        Apakah Anda yakin ingin menghapus data usulan pensiun ini? Tindakan ini tidak dapat diurungkan.
                    </x-confirm-delete-modal>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
