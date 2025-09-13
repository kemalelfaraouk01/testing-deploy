<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Usulan Pensiun') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header Aksi: Tombol Tambah dan Search --}}
            <div class="flex justify-between items-center mb-6 px-4 sm:px-0">
                <h3 class="text-lg font-medium text-gray-700">Daftar Usulan</h3>
                <a href="{{ route('pensiun.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Usulan
                </a>
            </div>

            {{-- Daftar Usulan Pensiun --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">
                    @forelse ($dataPensiun as $item)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 p-4">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                
                                {{-- Info Pegawai --}}
                                <div class="flex-1 mb-4 sm:mb-0">
                                    <p class="text-lg font-bold text-gray-800">{{ $item->pegawai->nama_lengkap ?? '[Nama tidak ada]' }}</p>
                                    <p class="text-sm text-gray-500">NIP: {{ $item->pegawai->user->nip ?? '[NIP tidak ada]' }}</p>
                                    <p class="text-sm text-gray-500">Jenis Pensiun: {{ $item->jenis_pensiun }}</p>
                                </div>

                                {{-- Info Status dan Tanggal --}}
                                <div class="flex-shrink-0 sm:text-right">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if ($item->status == 'Menunggu Berkas') bg-blue-100 text-blue-800 @endif
                                        @if ($item->status == 'Berkas Lengkap') bg-indigo-100 text-indigo-800 @endif
                                        @if ($item->status == 'Perlu Perbaikan') bg-red-100 text-red-800 @endif
                                        @if ($item->status == 'Diproses') bg-yellow-100 text-yellow-800 @endif
                                        @if ($item->status == 'Selesai') bg-green-100 text-green-800 @endif
                                    ">
                                        {{ $item->status }}
                                    </span>
                                    <p class="text-sm text-gray-500 mt-2">Tgl. Pensiun: <span class="font-medium">{{ \Carbon\Carbon::parse($item->tanggal_pensiun)->isoFormat('D MMM YYYY') }}</span></p>
                                    <p class="text-xs text-gray-400 mt-1">Diajukan: {{ $item->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            {{-- Aksi --}}
                            <div class="border-t border-gray-200 mt-4 pt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('pensiun.edit', ['pensiun' => $item->id, 'hash' => $item->getRouteHash()]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300">
                                        Lihat Detail
                                    </a>
                                    @role('Admin')
                                        @if ($item->status == 'Berkas Lengkap')
                                            <form action="{{ route('pensiun.approve', ['pensiun' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="hash" value="{{ $item->getRouteHash() }}">
                                                <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300">
                                                    Setujui
                                                </button>
                                            </form>
                                        @endif
                                    @endrole
                                </div>

                                {{-- Dropdown Aksi Lainnya --}}
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('pensiun.edit', ['pensiun' => $item->id, 'hash' => $item->getRouteHash()])">
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L14.732 3.732z" />
                                                </svg>
                                                Edit
                                            </div>
                                        </x-dropdown-link>
                                        <button x-on:click.prevent="$dispatch('open-delete-modal', { action: '{{ route('pensiun.destroy', ['pensiun' => $item->id]) }}', hash: '{{ $item->getRouteHash() }}' })" class="block w-full px-4 py-2 text-left text-sm leading-5 text-red-700 hover:bg-red-100 focus:outline-none focus:bg-red-100 transition duration-150 ease-in-out">
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </div>
                                        </button>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada usulan pensiun</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai buat usulan pensiun baru.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($dataPensiun->hasPages())
                    <div class="p-6 border-t border-gray-200">
                        {{ $dataPensiun->links() }}
                    </div>
                @endif
            </div>

            <x-confirm-delete-modal title="Konfirmasi Hapus Data">
                Apakah Anda yakin ingin menghapus data usulan pensiun ini? Tindakan ini tidak dapat diurungkan.
            </x-confirm-delete-modal>

        </div>
    </div>
</x-app-layout>