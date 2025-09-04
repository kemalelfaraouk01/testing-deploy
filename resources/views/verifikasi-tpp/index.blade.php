<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pengajuan TPP') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-base sm:text-lg font-bold text-gray-800 border-b pb-2 mb-4">
                    Daftar Pengajuan Masuk
                </h3>

                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr>
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Periode</th>
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">OPD Pengaju</th>
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Tgl Diajukan</th>
                                <th class="text-center py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($pengajuanTpps as $pengajuan)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4">{{ $daftarBulan[$pengajuan->periode_bulan] }}
                                        {{ $pengajuan->periode_tahun }}</td>
                                    <td class="py-3 px-4">{{ $pengajuan->opd->nama_opd }}</td>
                                    <td class="py-3 px-4">{{ $pengajuan->created_at->translatedFormat('d M Y, H:i') }}
                                    </td>
                                    <td class="text-center py-3 px-4">
                                        <a href="{{ route('verifikasi-tpp.show', $pengajuan->id) }}"
                                            class="inline-flex items-center px-3 py-1 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-blue-600 transition-colors duration-200">
                                            Lihat & Proses Berkas
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-gray-500">
                                        Tidak ada pengajuan yang perlu diverifikasi saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden space-y-4">
                    @forelse ($pengajuanTpps as $pengajuan)
                        <div
                            class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="p-4">
                                <!-- Header dengan periode -->
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-semibold text-gray-900">
                                        {{ $daftarBulan[$pengajuan->periode_bulan] }} {{ $pengajuan->periode_tahun }}
                                    </h4>
                                    <span
                                        class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                        Menunggu Verifikasi
                                    </span>
                                </div>

                                <!-- OPD -->
                                <div class="mb-3">
                                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium mb-1">OPD
                                        Pengaju</p>
                                    <p class="text-sm text-gray-900">{{ $pengajuan->opd->nama_opd }}</p>
                                </div>

                                <!-- Tanggal -->
                                <div class="mb-4">
                                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium mb-1">Tanggal
                                        Diajukan</p>
                                    <p class="text-sm text-gray-900">
                                        {{ $pengajuan->created_at->translatedFormat('d M Y, H:i') }}</p>
                                </div>

                                <!-- Action Button -->
                                <div class="pt-3 border-t border-gray-100">
                                    <a href="{{ route('verifikasi-tpp.show', $pengajuan->id) }}"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-sm text-white uppercase hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        Lihat & Proses Berkas
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Empty State untuk Mobile -->
                        <div class="text-center py-12">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <p class="text-gray-500 text-sm">
                                Tidak ada pengajuan yang perlu diverifikasi saat ini.
                            </p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($pengajuanTpps->hasPages())
                    <div class="mt-6 border-t border-gray-200 pt-4">
                        {{ $pengajuanTpps->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
