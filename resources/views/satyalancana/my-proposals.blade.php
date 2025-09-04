<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                {{ __('Status Usulan Satyalancana Saya') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="p-4 sm:p-6 lg:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-base sm:text-lg font-bold text-gray-800 border-b pb-2 mb-4">Riwayat Usulan</h3>

                {{-- Mobile Card View --}}
                <div class="block sm:hidden space-y-4">
                    @forelse ($usulans as $usulan)
                        <div class="bg-gray-50 rounded-lg p-4 border">
                            <div class="space-y-3">
                                {{-- Header Card --}}
                                <div class="flex justify-between items-start">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-900 text-sm">
                                            Satyalancana Karya Satya {{ $usulan->masa_kerja }} Tahun
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Tahun {{ $usulan->tahun_pengusulan }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Status Badge --}}
                                <div>
                                    @if ($usulan->status == 'menunggu_kelengkapan_berkas')
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-3 h-3 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Menunggu Berkas Anda
                                        </span>
                                        {{-- ▼▼▼ KODE BARU UNTUK STATUS PERLU PERBAIKAN ▼▼▼ --}}
                                    @elseif ($usulan->status == 'perlu_perbaikan')
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            <svg class="w-3 h-3 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Perlu Perbaikan
                                        </span>
                                        {{-- ▲▲▲ BATAS AKHIR KODE BARU ▲▲▲ --}}
                                    @elseif($usulan->status == 'berkas_lengkap')
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                fill="currentColor" class="w-3 h-3 mr-2">
                                                <path
                                                    d="M2.87 2.298a.75.75 0 0 0-.812 1.021L3.39 6.624a1 1 0 0 0 .928.626H8.25a.75.75 0 0 1 0 1.5H4.318a1 1 0 0 0-.927.626l-1.333 3.305a.75.75 0 0 0 .811 1.022 24.89 24.89 0 0 0 11.668-5.115.75.75 0 0 0 0-1.175A24.89 24.89 0 0 0 2.869 2.298Z" />
                                            </svg>
                                            Berkas Terkirim (Diverifikasi)
                                        </span>
                                    @elseif($usulan->status == 'disetujui')
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                fill="currentColor" class="w-3 h-3 mr-2">
                                                <path fill-rule="evenodd"
                                                    d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Disetujui
                                        </span>
                                    @elseif($usulan->status == 'ditolak')
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                fill="currentColor" class="w-3 h-3 mr-2">
                                                <path
                                                    d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z" />
                                            </svg>
                                            Ditolak
                                        </span>
                                    @endif
                                </div>

                                {{-- Action Button --}}
                                <div class="pt-2 border-t">
                                    {{-- ▼▼▼ UBAH LOGIKA TOMBOL AKSI ▼▼▼ --}}
                                    @if (in_array($usulan->status, ['menunggu_kelengkapan_berkas', 'perlu_perbaikan']))
                                        <a href="{{ route('satyalancana.berkas.show', $usulan->id) }}"
                                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition duration-150">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            @if ($usulan->status == 'perlu_perbaikan')
                                                Perbaiki Berkas
                                            @else
                                                Lengkapi Berkas
                                            @endif
                                        </a>
                                    @elseif($usulan->status == 'ditolak')
                                        <button x-data
                                            @click="$dispatch('open-modal', { content: '{{ $usulan->keterangan }}' })"
                                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition duration-150">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            Lihat Alasan Penolakan
                                        </button>
                                    @else
                                        <div class="text-center text-sm text-gray-500 py-2">
                                            Tidak ada aksi yang tersedia
                                        </div>
                                    @endif
                                    {{-- ▲▲▲ BATAS AKHIR PERUBAHAN ▲▲▲ --}}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <p class="text-gray-500 text-sm">
                                Anda belum pernah diusulkan untuk penghargaan Satyalancana.
                            </p>
                        </div>
                    @endforelse
                </div>

                {{-- Desktop Table View --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr>
                                <th class="text-left py-3 px-4 font-semibold text-sm">Penghargaan</th>
                                <th class="text-left py-3 px-4 font-semibold text-sm">Tahun Usulan</th>
                                <th class="text-left py-3 px-4 font-semibold text-sm">Status</th>
                                <th class="text-center py-3 px-4 font-semibold text-sm">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($usulans as $usulan)
                                <tr class="border-b hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="font-medium text-gray-900">
                                            Satyalancana Karya Satya {{ $usulan->masa_kerja }} Tahun
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">{{ $usulan->tahun_pengusulan }}</td>
                                    <td class="py-4 px-4">
                                        @if ($usulan->status == 'menunggu_kelengkapan_berkas')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span class="hidden lg:inline">Menunggu Berkas Anda</span>
                                                <span class="lg:hidden">Menunggu</span>
                                            </span>
                                            {{-- ▼▼▼ KODE BARU UNTUK STATUS PERLU PERBAIKAN ▼▼▼ --}}
                                        @elseif ($usulan->status == 'perlu_perbaikan')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span class="hidden lg:inline">Perlu Perbaikan</span>
                                                <span class="lg:hidden">Perbaiki</span>
                                            </span>
                                            {{-- ▲▲▲ BATAS AKHIR KODE BARU ▲▲▲ --}}
                                        @elseif($usulan->status == 'berkas_lengkap')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                    fill="currentColor" class="w-3 h-3 mr-1">
                                                    <path
                                                        d="M2.87 2.298a.75.75 0 0 0-.812 1.021L3.39 6.624a1 1 0 0 0 .928.626H8.25a.75.75 0 0 1 0 1.5H4.318a1 1 0 0 0-.927.626l-1.333 3.305a.75.75 0 0 0 .811 1.022 24.89 24.89 0 0 0 11.668-5.115.75.75 0 0 0 0-1.175A24.89 24.89 0 0 0 2.869 2.298Z" />
                                                </svg>
                                                <span class="hidden lg:inline">Berkas Terkirim (Diverifikasi)</span>
                                                <span class="lg:hidden">Terkirim</span>
                                            </span>
                                        @elseif($usulan->status == 'disetujui')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                    fill="currentColor" class="w-3 h-3 mr-1">
                                                    <path fill-rule="evenodd"
                                                        d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Disetujui
                                            </span>
                                        @elseif($usulan->status == 'ditolak')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                    fill="currentColor" class="w-3 h-3 mr-1">
                                                    <path
                                                        d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z" />
                                                </svg>
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center py-4 px-4">
                                        {{-- ▼▼▼ UBAH LOGIKA TOMBOL AKSI ▼▼▼ --}}
                                        @if (in_array($usulan->status, ['menunggu_kelengkapan_berkas', 'perlu_perbaikan']))
                                            <a href="{{ route('satyalancana.berkas.show', $usulan->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition duration-150">
                                                @if ($usulan->status == 'perlu_perbaikan')
                                                    Perbaiki Berkas
                                                @else
                                                    Lengkapi Berkas
                                                @endif
                                            </a>
                                        @elseif($usulan->status == 'ditolak')
                                            <button x-data
                                                @click="$dispatch('open-modal', { content: '{{ $usulan->keterangan }}' })"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition duration-150">
                                                Lihat Alasan
                                            </button>
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                        {{-- ▲▲▲ BATAS AKHIR PERUBAHAN ▲▲▲ --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-12">
                                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <p class="text-gray-500">
                                            Anda belum pernah diusulkan untuk penghargaan Satyalancana.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($usulans->hasPages())
                    <div class="mt-6">
                        {{ $usulans->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal untuk menampilkan alasan penolakan --}}
    <div x-data="{ open: false, content: '' }" @open-modal.window="open = true; content = event.detail.content" x-show="open"
        style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">

        {{-- Backdrop --}}
        <div @click="open = false" class="fixed inset-0 bg-black/50 transition-opacity"></div>

        {{-- Modal Content --}}
        <div class="relative w-full max-w-lg bg-white rounded-lg shadow-xl">
            {{-- Header --}}
            <div class="flex items-center justify-between p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Alasan Penolakan</h3>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-6">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm text-red-800 whitespace-pre-wrap" x-text="content"></p>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex justify-end p-6 border-t bg-gray-50 rounded-b-lg">
                <x-secondary-button @click="open = false" class="px-6">
                    Tutup
                </x-secondary-button>
            </div>
        </div>
    </div>
</x-app-layout>
