<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight truncate">
            {{ __('Riwayat Pengajuan Cuti Anda') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <a href="{{ route('cuti.create') }}"
                    class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 mb-6 transition-colors duration-200">
                    + Ajukan Cuti Baru
                </a>

                <div class="hidden md:block overflow-x-auto bg-white rounded-lg shadow-sm border">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Jenis Cuti
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Keterangan / Alasan Ditolak
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($cutis as $cuti)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 text-sm font-medium text-gray-900">
                                        {{ $cuti->jenis_cuti }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-900">
                                        <div class="flex flex-col">
                                            <span class="font-medium">
                                                {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->translatedFormat('d M Y') }}
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                s/d
                                                {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->translatedFormat('d M Y') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm">
                                        @if ($cuti->status == 'diajukan')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Diajukan ke Kepala Bidang
                                            </span>
                                        @elseif($cuti->status == 'disetujui_kabid')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Disetujui Kabid (Menunggu Kepala OPD)
                                            </span>
                                        @elseif($cuti->status == 'disetujui_kaopd')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Usulan Disetujui
                                            </span>
                                        @elseif($cuti->status == 'ditolak')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                    fill="currentColor" class="size-3 mr-1">
                                                    <path fill-rule="evenodd"
                                                        d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm2.78-4.22a.75.75 0 0 1-1.06 0L8 9.06l-1.72 1.72a.75.75 0 1 1-1.06-1.06L6.94 8 5.22 6.28a.75.75 0 0 1 1.06-1.06L8 6.94l1.72-1.72a.75.75 0 1 1 1.06 1.06L9.06 8l1.72 1.72a.75.75 0 0 1 0 1.06Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Usulan Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-sm">
                                        {{-- PERBAIKAN DI SINI --}}
                                        @if ($cuti->status == 'ditolak')
                                            <span
                                                class="font-medium text-red-600">{{ $cuti->keterangan_penolakan }}</span>
                                        @else
                                            <span class="text-gray-900">{{ $cuti->keterangan ?: '-' }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a2 2 0 012 2v1a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2h3z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 12v7m-4-4l4 4 4-4" />
                                            </svg>
                                            <p class="text-lg font-medium text-gray-900 mb-1">Belum ada pengajuan cuti
                                            </p>
                                            <p class="text-sm text-gray-500">Anda belum memiliki riwayat pengajuan cuti.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden space-y-4">
                    @forelse ($cutis as $cuti)
                        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 text-sm mb-1">{{ $cuti->jenis_cuti }}</h3>
                                    <p class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->translatedFormat('d M Y') }}
                                        - {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->translatedFormat('d M Y') }}
                                    </p>
                                </div>
                                <div class="ml-2">
                                    @if ($cuti->status == 'diajukan')
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Diajukan
                                        </span>
                                    @elseif($cuti->status == 'disetujui_kabid')
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Menunggu Ka OPD
                                        </span>
                                    @elseif($cuti->status == 'disetujui_kaopd')
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Disetujui
                                        </span>
                                    @elseif($cuti->status == 'ditolak')
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                fill="currentColor" class="size-3 mr-1">
                                                <path fill-rule="evenodd"
                                                    d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm2.78-4.22a.75.75 0 0 1-1.06 0L8 9.06l-1.72 1.72a.75.75 0 1 1-1.06-1.06L6.94 8 5.22 6.28a.75.75 0 0 1 1.06-1.06L8 6.94l1.72-1.72a.75.75 0 1 1 1.06 1.06L9.06 8l1.72 1.72a.75.75 0 0 1 0 1.06Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Ditolak
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- PERBAIKAN DI SINI --}}
                            @if ($cuti->keterangan || $cuti->keterangan_penolakan)
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <p
                                        class="text-xs mb-1 {{ $cuti->status == 'ditolak' ? 'text-red-500' : 'text-gray-500' }}">
                                        {{ $cuti->status == 'ditolak' ? 'Alasan Ditolak:' : 'Keterangan:' }}
                                    </p>
                                    <p
                                        class="text-sm font-medium {{ $cuti->status == 'ditolak' ? 'text-red-600' : 'text-gray-900' }}">
                                        @if ($cuti->status == 'ditolak')
                                            {{ $cuti->keterangan_penolakan }}
                                        @else
                                            {{ $cuti->keterangan ?: '-' }}
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a2 2 0 012 2v1a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2h3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 12v7m-4-4l4 4 4-4" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pengajuan cuti</h3>
                            <p class="text-sm text-gray-500 mb-6">Anda belum memiliki riwayat pengajuan cuti.</p>
                            <a href="{{ route('cuti.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition-colors duration-200">
                                Ajukan Cuti Sekarang
                            </a>
                        </div>
                    @endforelse
                </div>

                @if ($cutis->hasPages())
                    <div class="mt-6">
                        {{ $cutis->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .overflow-x-auto {
            scroll-behavior: smooth;
        }

        @media (max-width: 768px) {
            .container-padding {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        /* Smooth transitions for better UX */
        .transition-colors {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }

        /* Enhanced hover effects for mobile touch */
        @media (hover: hover) {
            .hover\:bg-gray-50:hover {
                background-color: #f9fafb;
            }
        }

        /* Better touch targets for mobile */
        @media (max-width: 768px) {
            .touch-target {
                min-height: 44px;
                min-width: 44px;
            }
        }
    </style>

</x-app-layout>
