<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pengajuan TPP') }}
        </h2>
    </x-slot>

<<<<<<< HEAD
    <div class="py-6 lg:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 rounded-t-xl">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        Daftar Pengajuan TPP Menunggu Verifikasi
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Berikut adalah semua pengajuan yang memerlukan tindakan Anda.</p>
=======
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
                                    <td class="py-3 px-4">{{ $pengajuan->opd?->nama_opd ?? '[OPD tidak ditemukan]' }}</td>
                                    <td class="py-3 px-4">{{ $pengajuan->created_at->translatedFormat('d M Y, H:i') }}
                                    </td>
                                    <td class="text-center py-3 px-4">
                                        <a href="{{ route('verifikasi-tpp.show', ['pengajuanTpp' => $pengajuan->id, 'hash' => $pengajuan->getRouteHash()]) }}"
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
>>>>>>> 82e007e84e5692e3a77758ea4a1d8379eb8fc049
                </div>

                <div class="p-6">
                    @if ($pengajuanTpps->count())
                        <!-- Desktop Table View -->
                        <div class="hidden lg:block overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Periode</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">OPD</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl. Diajukan</th>
                                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($pengajuanTpps as $pengajuan)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-gray-900">{{ $daftarBulan[$pengajuan->periode_bulan] }} {{ $pengajuan->periode_tahun }}</div>
                                                <div class="text-xs text-gray-500">#{{ $pengajuan->nomor_pengajuan ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $pengajuan->opd?->nama_opd ?? '' }}">{{ $pengajuan->opd?->nama_opd ?? '[OPD tidak ditemukan]' }}</div>
                                                <div class="text-xs text-gray-500">Oleh: {{ $pengajuan->user?->name ?? 'Sistem' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $pengajuan->created_at->translatedFormat('d M Y, H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <a href="{{ route('verifikasi-tpp.show', ['pengajuanTpp' => $pengajuan->id, 'hash' => $pengajuan->getRouteHash()]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 transition-all">
                                                    Verifikasi
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

<<<<<<< HEAD
                        <!-- Mobile Card View -->
                        <div class="lg:hidden grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach ($pengajuanTpps as $pengajuan)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 flex flex-col">
                                    <div class="p-5 flex-grow">
                                        <div class="flex justify-between items-start">
                                            <p class="text-xs font-semibold text-gray-500">#{{ $pengajuan->nomor_pengajuan ?? 'N/A' }}</p>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Menunggu Verifikasi
                                            </span>
                                        </div>
                                        <h4 class="font-bold text-gray-900 text-md mt-2">
                                            {{ $daftarBulan[$pengajuan->periode_bulan] }} {{ $pengajuan->periode_tahun }}
                                        </h4>
                                        <p class="text-sm text-gray-600 mt-1 break-words">{{ $pengajuan->opd?->nama_opd ?? '[OPD tidak ditemukan]' }}</p>
                                        <p class="text-xs text-gray-500 mt-2">Diajukan oleh: {{ $pengajuan->user?->name ?? 'Sistem' }}</p>
                                    </div>
                                    <div class="px-5 py-3 bg-gray-50 rounded-b-lg border-t border-gray-200">
                                        <a href="{{ route('verifikasi-tpp.show', ['pengajuanTpp' => $pengajuan->id, 'hash' => $pengajuan->getRouteHash()]) }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all">
                                            Verifikasi Sekarang
                                        </a>
                                    </div>
=======
                                <!-- OPD -->
                                <div class="mb-3">
                                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium mb-1">OPD
                                        Pengaju</p>
                                    <p class="text-sm text-gray-900">{{ $pengajuan->opd?->nama_opd ?? '[OPD tidak ditemukan]' }}</p>
>>>>>>> 82e007e84e5692e3a77758ea4a1d8379eb8fc049
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-9 h-9 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Semua Berkas Sudah Diverifikasi</h3>
                            <p class="text-sm text-gray-500">Tidak ada pengajuan TPP yang menunggu tindakan Anda saat ini. Kerja bagus!</p>
                        </div>
                    @endif

<<<<<<< HEAD
                    @if ($pengajuanTpps->hasPages())
                        <div class="mt-8 flex justify-center">
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-2">
                                {{ $pengajuanTpps->links() }}
=======
                                <!-- Tanggal -->
                                <div class="mb-4">
                                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium mb-1">Tanggal
                                        Diajukan</p>
                                    <p class="text-sm text-gray-900">
                                        {{ $pengajuan->created_at->translatedFormat('d M Y, H:i') }}</p>
                                </div>

                                <!-- Action Button -->
                                <div class="pt-3 border-t border-gray-100">
                                    <a href="{{ route('verifikasi-tpp.show', ['pengajuanTpp' => $pengajuan->id, 'hash' => $pengajuan->getRouteHash()]) }}"
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
>>>>>>> 82e007e84e5692e3a77758ea4a1d8379eb8fc049
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
