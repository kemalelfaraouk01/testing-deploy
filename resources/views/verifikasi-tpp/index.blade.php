<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pengajuan TPP') }}
        </h2>
    </x-slot>

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

                    @if ($pengajuanTpps->hasPages())
                        <div class="mt-8 flex justify-center">
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-2">
                                {{ $pengajuanTpps->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>