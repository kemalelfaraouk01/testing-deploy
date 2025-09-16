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
        </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cek Status Pensiun Berdasarkan Usia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-5 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900">Daftar Urut Pegawai Berdasarkan Usia</h3>
                    <p class="text-sm text-gray-600 mt-1">Menampilkan semua data pegawai aktif diurutkan dari usia
                        tertua. Asumsi usia pensiun adalah 58 tahun.</p>
                </div>

                <!-- Desktop Table View -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No.</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pegawai</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Lahir</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Usia</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">TMT Pensiun (Est)</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">OPD</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($pegawais as $pegawai)
                                @php
                                    $usia = Carbon\Carbon::parse($pegawai->tanggal_lahir)->age;
                                    $tmtPensiun = Carbon\Carbon::parse($pegawai->tanggal_lahir)->addYears(58)->addMonth()->startOfMonth();
                                    $sisaWaktu = now()->diffInMonths($tmtPensiun, false);
                                    $rowClass = '';
                                    if ($sisaWaktu <= 12) { $rowClass = 'age-gradient-red'; }
                                    elseif ($sisaWaktu <= 36) { $rowClass = 'age-gradient-yellow'; }
                                @endphp
                                <tr class="{{ $rowClass }}">
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $loop->iteration + $pegawais->firstItem() - 1 }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="min-w-0 flex-1">
                                                <div class="text-sm font-semibold text-gray-900 line-clamp-1">{{ $pegawai->nama_lengkap }}</div>
                                                <div class="text-xs text-gray-500">NIP: {{ $pegawai->user->nip ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ Carbon\Carbon::parse($pegawai->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                                    <td class="px-6 py-4 text-sm font-bold {{ $usia >= 55 ? 'text-red-600' : 'text-gray-800' }}">{{ $usia }} tahun</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $tmtPensiun->translatedFormat('d F Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $pegawai->opd?->nama_opd ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center">
                                        <h3 class="text-lg font-medium text-gray-900">Belum ada data</h3>
                                        <p class="text-sm text-gray-500">Tidak ada data pegawai aktif untuk ditampilkan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="lg:hidden">
                    <div class="px-4 py-4 space-y-4">
                        @forelse ($pegawais as $pegawai)
                            @php
                                $usia = Carbon\Carbon::parse($pegawai->tanggal_lahir)->age;
                                $tmtPensiun = Carbon\Carbon::parse($pegawai->tanggal_lahir)->addYears(58)->addMonth()->startOfMonth();
                                $sisaWaktu = now()->diffInMonths($tmtPensiun, false);
                                $cardClass = '';
                                if ($sisaWaktu <= 12) { $cardClass = 'bg-red-50 border-red-200'; }
                                elseif ($sisaWaktu <= 36) { $cardClass = 'bg-amber-50 border-amber-200'; }
                                else { $cardClass = 'bg-white border-gray-200'; }
                            @endphp
                            <div class="rounded-lg shadow-sm border p-4 {{ $cardClass }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-base font-bold text-gray-900">{{ $pegawai->nama_lengkap }}</p>
                                        <p class="text-xs text-gray-600">NIP: {{ $pegawai->user->nip ?? 'N/A' }}</p>
                                    </div>
                                    <div class="text-right flex-shrink-0 ml-4">
                                        <p class="text-sm font-bold {{ $usia >= 55 ? 'text-red-600' : 'text-gray-800' }}">{{ $usia }} tahun</p>
                                    </div>
                                </div>
                                <div class="mt-4 border-t pt-3 space-y-2 text-xs">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500 font-medium">Tgl. Lahir</span>
                                        <span class="text-gray-800 font-semibold">{{ Carbon\Carbon::parse($pegawai->tanggal_lahir)->translatedFormat('d F Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500 font-medium">TMT Pensiun (Est)</span>
                                        <span class="text-gray-800 font-semibold">{{ $tmtPensiun->translatedFormat('d F Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500 font-medium">OPD</span>
                                        <span class="text-gray-800 font-semibold text-right">{{ $pegawai->opd?->nama_opd ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-20 text-center">
                                <h3 class="text-lg font-medium text-gray-900">Belum ada data</h3>
                                <p class="text-sm text-gray-500">Tidak ada data pegawai aktif untuk ditampilkan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mt-8">
                {{ $pegawais->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
