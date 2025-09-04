<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pengajuan Cuti') }}
        </h2>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Daftar Pengajuan Masuk</h3>

                <!-- Desktop Table View - Hidden on Mobile -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr>
                                <th class="text-left py-3 px-4">Nama Pegawai</th>
                                <th class="text-left py-3 px-4">Jenis Cuti</th>
                                <th class="text-left py-3 px-4">Tanggal</th>
                                <th class="text-left py-3 px-4">Keterangan</th>
                                <th class="text-center py-3 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($cutis as $cuti)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4">{{ $cuti->pegawai->nama_lengkap }}</td>
                                    <td class="py-3 px-4">{{ $cuti->jenis_cuti }}</td>
                                    <td class="py-3 px-4">
                                        {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->translatedFormat('d M Y') }}
                                        -
                                        {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="py-3 px-4 text-sm">{{ Str::limit($cuti->keterangan, 50) }}</td>
                                    <td class="text-center py-3 px-4">
                                        <a href="{{ route('verifikasi-cuti.show', $cuti->id) }}"
                                            class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs font-bold rounded-md hover:bg-blue-600">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Tidak ada pengajuan cuti yang perlu
                                        diverifikasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View - Visible on Mobile Only -->
                <div class="md:hidden space-y-4">
                    @forelse ($cutis as $cuti)
                        <div
                            class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
                            <!-- Header dengan nama dan jenis cuti -->
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800 text-sm">{{ $cuti->pegawai->nama_lengkap }}
                                    </h4>
                                    <span
                                        class="inline-block mt-1 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                        {{ $cuti->jenis_cuti }}
                                    </span>
                                </div>
                            </div>

                            <!-- Info tanggal -->
                            <div class="mb-3">
                                <div class="flex items-center text-sm text-gray-600 mb-1">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="font-medium">Periode:</span>
                                </div>
                                <div class="text-sm text-gray-800 ml-6">
                                    {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->translatedFormat('d M Y') }}
                                    -
                                    {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->translatedFormat('d M Y') }}
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="mb-4">
                                <div class="flex items-center text-sm text-gray-600 mb-1">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <span class="font-medium">Keterangan:</span>
                                </div>
                                <p class="text-sm text-gray-800 ml-6">{{ Str::limit($cuti->keterangan, 80) }}</p>
                            </div>

                            <!-- Tombol aksi -->
                            <div class="flex justify-end pt-3 border-t border-gray-100">
                                <a href="{{ route('verifikasi-cuti.show', $cuti->id) }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <p class="text-gray-500">Tidak ada pengajuan cuti yang perlu diverifikasi.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-6">{{ $cutis->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
