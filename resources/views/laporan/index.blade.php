<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            {{ __('Laporan Kepegawaian') }}
        </h2>
    </x-slot>
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 sm:p-6">
                <h3 class="text-base sm:text-lg font-bold text-gray-800 border-b pb-2 mb-4">Pilih Laporan</h3>
                <div class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-1 md:grid-cols-2 sm:gap-6">

                    {{-- ========================================================== --}}
                    {{-- BAGIAN YANG DISESUAIKAN: Kartu Laporan DUK --}}
                    {{-- ========================================================== --}}
                    <div class="p-4 sm:p-6 border rounded-lg shadow-sm">
                        <form method="GET" action="{{ route('laporan.duk.cetak') }}" target="_blank">
                            <h4 class="font-bold text-gray-900 text-sm sm:text-base">Daftar Urut Kepangkatan (DUK)</h4>
                            <p class="text-xs sm:text-sm text-gray-600 mt-1 leading-relaxed">
                                Membuat daftar urut pegawai berdasarkan kepangkatan untuk OPD tertentu.
                            </p>

                            <div class="mt-3 sm:mt-4">
                                <x-input-label for="opd_id" value="Pilih OPD" class="text-sm font-medium" />
                                @role('Admin')
                                    {{-- Jika Admin, tampilkan dropdown untuk memilih --}}
                                    <select name="opd_id" id="opd_id"
                                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 text-sm py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                        <option value="">-- Pilih OPD --</option>
                                        @foreach ($opds as $opd)
                                            <option value="{{ $opd->id }}">{{ $opd->nama_opd }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    {{-- Jika bukan Admin, tampilkan OPD-nya saja --}}
                                    <input type="text"
                                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 bg-gray-100 text-sm py-2 px-3"
                                        value="{{ $userOpd->nama_opd ?? 'Tidak terikat OPD' }}" disabled>
                                    <input type="hidden" name="opd_id" value="{{ $userOpd->id ?? '' }}">
                                @endrole
                            </div>

                            <div class="mt-3 sm:mt-4">
                                <x-input-label for="type" value="Pilih Format" class="text-sm font-medium" />
                                <select name="type" id="type"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 text-sm py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="pdf">PDF</option>
                                    {{-- Opsi Excel bisa ditambahkan di sini nanti --}}
                                </select>
                            </div>

                            <div class="mt-4 sm:mt-4">
                                <x-primary-button type="submit" class="w-full sm:w-auto text-sm py-2 px-4">
                                    Generate Laporan
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    {{-- Kartu Laporan Rekapitulasi Jabatan --}}
                    <div class="p-4 sm:p-6 border rounded-lg shadow-sm">
                        <form method="GET" action="{{ route('laporan.rekapitulasi.jabatan') }}" target="_blank">
                            <h4 class="font-bold text-gray-900 text-sm sm:text-base">Rekapitulasi Jabatan & Gender</h4>
                            <p class="text-xs sm:text-sm text-gray-600 mt-1 leading-relaxed">
                                Membuat rekapitulasi jumlah pegawai per gender dan jabatan struktural (eselon) untuk OPD
                                tertentu.
                            </p>

                            <div class="mt-3 sm:mt-4">
                                <x-input-label for="rekap_opd_id" value="Pilih OPD" class="text-sm font-medium" />
                                @role('Admin')
                                    <select name="opd_id" id="rekap_opd_id"
                                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 text-sm py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                        <option value="">-- Pilih OPD --</option>
                                        @foreach ($opds as $opd)
                                            <option value="{{ $opd->id }}">{{ $opd->nama_opd }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text"
                                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 bg-gray-100 text-sm py-2 px-3"
                                        value="{{ $userOpd->nama_opd ?? 'N/A' }}" disabled>
                                    <input type="hidden" name="opd_id" value="{{ $userOpd->id ?? '' }}">
                                @endrole
                            </div>

                            <div class="mt-4 sm:mt-4">
                                <x-primary-button type="submit" class="w-full sm:w-auto text-sm py-2 px-4">
                                    Cetak PDF
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    {{-- ========================================================== --}}
                    {{-- BAGIAN BARU: Kartu Laporan Pensiun --}}
                    {{-- ========================================================== --}}
                    <div class="p-4 sm:p-6 border rounded-lg shadow-sm">
                        <form method="GET" action="{{ route('laporan.pensiun.cetak') }}" target="_blank">
                            <h4 class="font-bold text-gray-900 text-sm sm:text-base">Laporan Pegawai Akan Pensiun</h4>
                            <p class="text-xs sm:text-sm text-gray-600 mt-1 leading-relaxed">
                                Membuat daftar pegawai yang akan memasuki masa pensiun berdasarkan rentang waktu.
                            </p>

                            <div class="mt-3 sm:mt-4">
                                <x-input-label for="rentang_waktu" value="Pilih Rentang Waktu"
                                    class="text-sm font-medium" />
                                <select name="rentang_waktu" id="rentang_waktu"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 text-sm py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="1">Dalam 1 Tahun ke Depan</option>
                                    <option value="2">Dalam 2 Tahun ke Depan</option>
                                    <option value="5">Dalam 5 Tahun ke Depan</option>
                                </select>
                            </div>

                            <div class="mt-4 sm:mt-4">
                                <x-primary-button type="submit" class="w-full sm:w-auto text-sm py-2 px-4">
                                    Cetak PDF
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    {{-- Kartu untuk laporan lain bisa ditambahkan di sini --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
