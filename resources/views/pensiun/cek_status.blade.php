<x-app-layout>
    @push('scripts')
        <style>
            .age-gradient-red {
                background: linear-gradient(to right, #fee2e2, #fef2f2, white);
            }

            .age-gradient-yellow {
                background: linear-gradient(to right, #fef9c3, #fefce8, white);
            }

            .age-gradient-green {
                background: linear-gradient(to right, #dcfce7, #f0fdf4, white);
            }

            /* Enhanced responsive utilities */
            @media (max-width: 640px) {
                .text-responsive {
                    font-size: 0.875rem;
                }

                .px-responsive {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }
            }

            /* Smooth transitions for breakpoint changes */
            .transition-layout {
                transition: all 0.3s ease-in-out;
            }

            /* Better mobile spacing */
            @media (max-width: 768px) {
                .mobile-spacing {
                    padding: 0.75rem;
                }
            }
        </style>
    @endpush

    <x-slot name="header">
        <div class="px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
                {{ __('Cek Status Pensiun') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-layout">
                <!-- Header Section - Enhanced Responsive -->
                <div
                    class="bg-gradient-to-r from-blue-50 to-blue-100 px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-1">
                        Daftar Urut Pegawai Berdasarkan Usia
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-600">
                        Menampilkan semua data pegawai aktif diurutkan dari usia tertua. Asumsi usia pensiun adalah 58
                        tahun.
                    </p>
                </div>

                <!-- Desktop Table View - Enhanced for tablets -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th
                                    class="px-4 xl:px-6 py-3 xl:py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    No.
                                </th>
                                <th
                                    class="px-4 xl:px-6 py-3 xl:py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider min-w-[200px]">
                                    Pegawai
                                </th>
                                <th
                                    class="px-4 xl:px-6 py-3 xl:py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Tanggal Lahir
                                </th>
                                <th
                                    class="px-4 xl:px-6 py-3 xl:py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Usia
                                </th>
                                <th
                                    class="px-4 xl:px-6 py-3 xl:py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    TMT Pensiun (Est)
                                </th>
                                <th
                                    class="px-4 xl:px-6 py-3 xl:py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    OPD
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($pegawais as $pegawai)
                                @php
                                    $usia = Carbon\Carbon::parse($pegawai->tanggal_lahir)->age;
                                    $tmtPensiun = Carbon\Carbon::parse($pegawai->tanggal_lahir)
                                        ->addYears(58)
                                        ->addMonth()
                                        ->startOfMonth();
                                    $sisaWaktu = now()->diffInMonths($tmtPensiun, false);
                                    $rowClass = '';
                                    if ($sisaWaktu <= 12) {
                                        $rowClass = 'age-gradient-red';
                                    } elseif ($sisaWaktu <= 36) {
                                        $rowClass = 'age-gradient-yellow';
                                    }
                                @endphp
                                <tr class="{{ $rowClass }} transition-layout">
                                    <td class="px-4 xl:px-6 py-3 xl:py-4 text-sm text-gray-600">
                                        {{ $loop->iteration + $pegawais->firstItem() - 1 }}
                                    </td>
                                    <td class="px-4 xl:px-6 py-3 xl:py-4">
                                        <div class="flex items-center space-x-3 xl:space-x-4">
                                            <div class="min-w-0 flex-1">
                                                <div
                                                    class="text-sm font-semibold text-gray-900 line-clamp-2 xl:line-clamp-1">
                                                    {{ $pegawai->nama_lengkap }}
                                                </div>
                                                <div class="text-xs text-gray-500 mt-0.5">
                                                    NIP: {{ $pegawai->user->nip ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 xl:px-6 py-3 xl:py-4 text-sm text-gray-800">
                                        {{ Carbon\Carbon::parse($pegawai->tanggal_lahir)->translatedFormat('d F Y') }}
                                    </td>
                                    <td
                                        class="px-4 xl:px-6 py-3 xl:py-4 text-sm font-bold {{ $usia >= 55 ? 'text-red-600' : 'text-gray-800' }}">
                                        {{ $usia }} tahun
                                    </td>
                                    <td class="px-4 xl:px-6 py-3 xl:py-4 text-sm text-gray-800">
                                        {{ $tmtPensiun->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="px-4 xl:px-6 py-3 xl:py-4 text-sm text-gray-800">
                                        <span class="line-clamp-2">{{ $pegawai->opd?->nama_opd ?? '-' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 xl:px-6 py-12 xl:py-20 text-center">
                                        <h3 class="text-lg font-medium text-gray-900">Belum ada data</h3>
                                        <p class="text-sm text-gray-500">Tidak ada data pegawai aktif untuk ditampilkan.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Tablet View - New responsive table for medium screens -->
                <div class="hidden md:block lg:hidden overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Pegawai
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Usia
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    TMT Pensiun
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($pegawais as $pegawai)
                                @php
                                    $usia = Carbon\Carbon::parse($pegawai->tanggal_lahir)->age;
                                    $tmtPensiun = Carbon\Carbon::parse($pegawai->tanggal_lahir)
                                        ->addYears(58)
                                        ->addMonth()
                                        ->startOfMonth();
                                    $sisaWaktu = now()->diffInMonths($tmtPensiun, false);
                                    $rowClass = '';
                                    if ($sisaWaktu <= 12) {
                                        $rowClass = 'age-gradient-red';
                                    } elseif ($sisaWaktu <= 36) {
                                        $rowClass = 'age-gradient-yellow';
                                    }
                                @endphp
                                <tr class="{{ $rowClass }}">
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900 line-clamp-1">
                                                {{ $pegawai->nama_lengkap }}
                                            </div>
                                            <div class="text-xs text-gray-500">NIP: {{ $pegawai->user->nip ?? 'N/A' }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ Carbon\Carbon::parse($pegawai->tanggal_lahir)->translatedFormat('d F Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500 line-clamp-1">
                                                {{ $pegawai->opd?->nama_opd ?? '-' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td
                                        class="px-4 py-3 text-sm font-bold {{ $usia >= 55 ? 'text-red-600' : 'text-gray-800' }}">
                                        {{ $usia }} tahun
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-800">
                                        {{ $tmtPensiun->translatedFormat('d F Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-12 text-center">
                                        <h3 class="text-lg font-medium text-gray-900">Belum ada data</h3>
                                        <p class="text-sm text-gray-500">Tidak ada data pegawai aktif untuk ditampilkan.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View - Enhanced -->
                <div class="md:hidden">
                    <div class="px-3 sm:px-4 py-4 space-y-3 sm:space-y-4">
                        @forelse ($pegawais as $pegawai)
                            @php
                                $usia = Carbon\Carbon::parse($pegawai->tanggal_lahir)->age;
                                $tmtPensiun = Carbon\Carbon::parse($pegawai->tanggal_lahir)
                                    ->addYears(58)
                                    ->addMonth()
                                    ->startOfMonth();
                                $sisaWaktu = now()->diffInMonths($tmtPensiun, false);
                                $cardClass = '';
                                if ($sisaWaktu <= 12) {
                                    $cardClass = 'bg-red-50 border-red-200';
                                } elseif ($sisaWaktu <= 36) {
                                    $cardClass = 'bg-amber-50 border-amber-200';
                                } else {
                                    $cardClass = 'bg-white border-gray-200';
                                }
                            @endphp
                            <div class="rounded-lg shadow-sm border p-3 sm:p-4 {{ $cardClass }} transition-layout">
                                <!-- Header Section -->
                                <div class="flex justify-between items-start gap-3">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm sm:text-base font-bold text-gray-900 line-clamp-2">
                                            {{ $pegawai->nama_lengkap }}
                                        </p>
                                        <p class="text-xs text-gray-600 mt-1">
                                            NIP: {{ $pegawai->user->nip ?? 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <p
                                            class="text-sm sm:text-base font-bold {{ $usia >= 55 ? 'text-red-600' : 'text-gray-800' }}">
                                            {{ $usia }} tahun
                                        </p>
                                        @if ($sisaWaktu <= 12)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-1">
                                                Segera Pensiun
                                            </span>
                                        @elseif($sisaWaktu <= 36)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 mt-1">
                                                Mendekati Pensiun
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Details Section -->
                                <div class="mt-3 sm:mt-4 border-t border-gray-100 pt-3 space-y-2 text-xs sm:text-sm">
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <span class="text-gray-500 font-medium block">Tgl. Lahir</span>
                                            <span class="text-gray-800 font-semibold text-xs sm:text-sm">
                                                {{ Carbon\Carbon::parse($pegawai->tanggal_lahir)->translatedFormat('d M Y') }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500 font-medium block">TMT Pensiun</span>
                                            <span class="text-gray-800 font-semibold text-xs sm:text-sm">
                                                {{ $tmtPensiun->translatedFormat('d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 font-medium block mb-1">OPD</span>
                                        <span class="text-gray-800 font-semibold text-xs sm:text-sm line-clamp-2">
                                            {{ $pegawai->opd?->nama_opd ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 sm:px-6 py-12 sm:py-20 text-center">
                                <div
                                    class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data</h3>
                                <p class="text-sm text-gray-500">Tidak ada data pegawai aktif untuk ditampilkan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pagination - Enhanced responsive -->
                @if ($pegawais->hasPages())
                    <div class="border-t border-gray-100 px-3 sm:px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div class="text-xs sm:text-sm text-gray-500">
                                Menampilkan {{ $pegawais->firstItem() }} sampai {{ $pegawais->lastItem() }}
                                dari {{ $pegawais->total() }} hasil
                            </div>
                            <div class="flex-1 flex justify-end">
                                {{ $pegawais->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
