<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengajuan Berkas TPP') }}
        </h2>
    </x-slot>

    <div class="py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Form Pengajuan Baru --}}
            @role('Admin|Pengelola')
                <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                    <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-xl">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            Buat Pengajuan Baru
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Pilih periode dan unit kerja untuk memulai pengajuan TPP</p>
                    </div>

                    <div class="p-6">
                        <form method="GET" action="{{ route('pengajuan-tpp.lanjutkan') }}" class="space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                {{-- Dropdown Bulan --}}
                                <div class="space-y-2">
                                    <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan
                                        Periode</label>
                                    <select name="bulan" id="bulan" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                        @foreach ($daftarBulan as $angka => $nama)
                                            <option value="{{ $angka }}">{{ $nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Dropdown Tahun --}}
                                <div class="space-y-2">
                                    <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun
                                        Periode</label>
                                    <select name="tahun" id="tahun" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                        @foreach ($daftarTahun as $tahun)
                                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Dropdown OPD --}}
                                <div class="space-y-2 sm:col-span-2 lg:col-span-1">
                                    <label for="opd_id" class="block text-sm font-medium text-gray-700">Unit Kerja
                                        (OPD)</label>
                                    @if (auth()->user()->hasRole('Admin'))
                                        <select name="opd_id" id="opd_id" required
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                            <option value="">-- Pilih OPD --</option>
                                            @foreach ($opds as $opd)
                                                <option value="{{ $opd->id }}">{{ $opd->nama_opd }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="text" readonly
                                            value="{{ auth()->user()->pegawai?->opd?->nama_opd ?? 'Anda tidak terikat pada OPD manapun' }}"
                                            class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-600 shadow-sm">
                                        @if (auth()->user()->pegawai?->opd_id)
                                            <input type="hidden" name="opd_id"
                                                value="{{ auth()->user()->pegawai->opd_id }}">
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                    <span>Lanjutkan</span>
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endrole

            {{-- Riwayat Pengajuan --}}
            <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 rounded-t-xl">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        Riwayat Pengajuan
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Lihat dan kelola semua pengajuan TPP yang telah dibuat</p>
                </div>

                <div class="p-6">
                    {{-- Filter Form --}}
                    <div class="bg-gray-50 rounded-xl p-4 mb-6">
                        <form method="GET" action="{{ route('pengajuan-tpp.index') }}">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                @role('Admin')
                                    <div class="space-y-2">
                                        <label for="filter_opd_id" class="block text-sm font-medium text-gray-700">Filter
                                            OPD</label>
                                        <select name="opd_id" id="filter_opd_id"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                            <option value="">-- Semua OPD --</option>
                                            @foreach ($opds as $opd)
                                                <option value="{{ $opd->id }}"
                                                    {{ request('opd_id') == $opd->id ? 'selected' : '' }}>
                                                    {{ $opd->nama_opd }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endrole

                                <div class="space-y-2">
                                    <label for="status" class="block text-sm font-medium text-gray-700">Filter
                                        Status</label>
                                    <select name="status" id="status"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                        <option value="">-- Semua Status --</option>
                                        @foreach ($daftarStatus as $status)
                                            <option value="{{ $status }}"
                                                {{ request('status') == $status ? 'selected' : '' }}>
                                                {{ Str::title(str_replace('_', ' ', $status)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex gap-2 sm:col-span-2 lg:col-span-1 lg:items-end">
                                    <button type="submit"
                                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors shadow-sm whitespace-nowrap">
                                        Filter
                                    </button>
                                    <a href="{{ route('pengajuan-tpp.index') }}"
                                        class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-center rounded-lg transition-colors shadow-sm whitespace-nowrap">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Content --}}
                    @if ($pengajuanTpps->count())
                        {{-- Desktop Table --}}
                        <div class="hidden lg:block overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @foreach (['Periode', 'OPD', 'Status', 'Tgl Dibuat', 'Aksi'] as $header)
                                            <th
                                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                {{ $header }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($pengajuanTpps as $pengajuan)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $daftarBulan[$pengajuan->periode_bulan] }}
                                                    {{ $pengajuan->periode_tahun }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 max-w-xs truncate"
                                                    title="{{ $pengajuan->opd->nama_opd }}">
                                                    {{ $pengajuan->opd->nama_opd }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <x-status-badge :status="$pengajuan->status" />
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $pengajuan->created_at->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <x-action-button :pengajuan="$pengajuan" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile Cards --}}
                        <div class="lg:hidden grid gap-4">
                            @foreach ($pengajuanTpps as $pengajuan)
                                <div
                                    class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                    <div class="p-4">
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900 text-sm">
                                                    {{ $daftarBulan[$pengajuan->periode_bulan] }}
                                                    {{ $pengajuan->periode_tahun }}
                                                </h4>
                                                <p class="text-xs text-gray-600 mt-1 truncate">
                                                    {{ $pengajuan->opd->nama_opd }}</p>
                                                <p class="text-xs text-gray-500 mt-2">
                                                    {{ $pengajuan->created_at->format('d M Y') }}</p>
                                            </div>
                                            <x-status-badge :status="$pengajuan->status" />
                                        </div>

                                        <div class="pt-3 border-t border-gray-200">
                                            <x-action-button :pengajuan="$pengajuan" :mobile="true" />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div
                                class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pengajuan</h3>
                            <p class="text-sm text-gray-500">Mulai dengan membuat pengajuan TPP baru untuk periode yang
                                diperlukan.</p>
                        </div>
                    @endif

                    {{-- Pagination --}}
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
