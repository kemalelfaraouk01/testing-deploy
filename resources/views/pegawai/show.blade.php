<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pegawai: {{ $pegawai->nama_lengkap }}
        </h2>
    </x-slot>

    <div x-data="{
        tab: 'pribadi',
        addRiwayatPangkatModalOpen: @error('pangkat', 'tambahRiwayatPangkat') true @else false @enderror,
        deleteRiwayatPangkatModalOpen: false,
        deleteRiwayatPangkatAction: '',
        addRiwayatJabatanModalOpen: @error('jabatan', 'tambahRiwayatJabatan') true @else false @enderror,
        deleteRiwayatJabatanModalOpen: false,
        deleteRiwayatJabatanAction: '',
        showMobileMenu: false
    }" class="py-6 sm:py-12">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Navigation Bar -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <a href="{{ route('pegawai.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                    @role('Admin')
                        <a href="{{ route('pegawai.edit', $pegawai->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Data
                        </a>
                    @endrole
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
                <!-- Profile Sidebar -->
                <div class="xl:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-6">
                        <div class="text-center">
                            <div class="relative inline-block">
                                <img class="h-32 w-32 rounded-full object-cover ring-4 ring-blue-100 shadow-lg"
                                    src="{{ $pegawai->foto ? asset('storage/' . $pegawai->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($pegawai->nama_lengkap) . '&color=7F9CF5&background=EBF4FF' }}"
                                    alt="Foto Profil">
                                <div
                                    class="absolute bottom-0 right-0 h-8 w-8 bg-green-400 rounded-full ring-2 ring-white">
                                </div>
                            </div>
                            <h3 class="mt-4 text-xl font-bold text-gray-900">{{ $pegawai->nama_lengkap }}</h3>
                            <p class="text-sm text-gray-600 mt-1">NIP: {{ $pegawai->user->nip }}</p>
                            <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                                <p class="text-sm font-semibold text-blue-800">
                                    {{ $pegawai->jabatan->nama_jabatan ?? 'Jabatan Belum Diatur' }}
                                </p>
                                <p class="text-xs text-blue-600 mt-1">{{ $pegawai->opd->nama_opd ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="xl:col-span-3">
                    <!-- Tab Navigation -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                        <div class="border-b border-gray-200 px-6 py-4">
                            <!-- Desktop Tabs -->
                            <nav class="hidden sm:flex space-x-8" aria-label="Tabs">
                                <button @click="tab = 'pribadi'"
                                    :class="tab === 'pribadi' ? 'border-blue-500 text-blue-600 bg-blue-50' :
                                        'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                                    class="whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm rounded-t-lg transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Data Diri
                                </button>
                                <button @click="tab = 'riwayat'"
                                    :class="tab === 'riwayat' ? 'border-blue-500 text-blue-600 bg-blue-50' :
                                        'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                                    class="whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm rounded-t-lg transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                    Riwayat Pangkat
                                </button>
                                <button @click="tab = 'riwayat_jabatan'"
                                    :class="tab === 'riwayat_jabatan' ? 'border-blue-500 text-blue-600 bg-blue-50' :
                                        'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                                    class="whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm rounded-t-lg transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6" />
                                    </svg>
                                    Riwayat Jabatan
                                </button>
                            </nav>

                            <!-- Mobile Tab Selector -->
                            <div class="sm:hidden">
                                <select @change="tab = $event.target.value" :value="tab"
                                    class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="pribadi">Data Diri</option>
                                    <option value="riwayat">Riwayat Pangkat</option>
                                    <option value="riwayat_jabatan">Riwayat Jabatan</option>
                                </select>
                            </div>
                        </div>

                        <!-- Tab Content -->
                        <div class="p-6">
                            <!-- Data Diri Tab -->
                            <div x-show="tab === 'pribadi'" class="space-y-6">
                                <!-- Data Pribadi -->
                                @include('pegawai.partials.data-pribadi')

                                <!-- Data Kepegawaian -->
                                @include('pegawai.partials.data-kepegawaian')

                                <!-- Data Pendidikan -->
                                @include('pegawai.partials.pendidikan-terakhir')

                                <!-- Data Lainnya -->
                                @include('pegawai.partials.data-lainnya')
                            </div>

                            <!-- Riwayat Pangkat Tab -->
                            <div x-show="tab === 'riwayat'">
                                @include('pegawai.partials.riwayat-pangkat')
                            </div>

                            <!-- Riwayat Jabatan Tab -->
                            <div x-show="tab === 'riwayat_jabatan'">
                                @include('pegawai.partials.riwayat-jabatan')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals -->
        <!-- Modal Delete Riwayat Pangkat -->
        <div x-show="deleteRiwayatPangkatModalOpen" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click="deleteRiwayatPangkatModalOpen = false" class="fixed inset-0 bg-black/50"></div>
            <div x-show="deleteRiwayatPangkatModalOpen" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative w-full max-w-lg bg-white rounded-xl shadow-xl p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-red-100 rounded-full mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Hapus</h3>
                        <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus data riwayat pangkat ini?
                        </p>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mb-6">Tindakan ini tidak dapat dibatalkan dan akan menghapus data
                    secara permanen.</p>
                <form :action="deleteRiwayatPangkatAction" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex flex-col-reverse sm:flex-row gap-3">
                        <button @click="deleteRiwayatPangkatModalOpen = false" type="button"
                            class="w-full sm:w-auto px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition-colors duration-200">
                            Batal
                        </button>
                        <button type="submit"
                            class="w-full sm:w-auto px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Delete Riwayat Jabatan -->
        <div x-show="deleteRiwayatJabatanModalOpen" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click="deleteRiwayatJabatanModalOpen = false" class="fixed inset-0 bg-black/50"></div>
            <div x-show="deleteRiwayatJabatanModalOpen" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative w-full max-w-lg bg-white rounded-xl shadow-xl p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-red-100 rounded-full mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Hapus Riwayat Jabatan</h3>
                        <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus data riwayat jabatan ini?
                        </p>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mb-6">Tindakan ini tidak dapat dibatalkan dan akan menghapus data
                    secara permanen.</p>
                <form :action="deleteRiwayatJabatanAction" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex flex-col-reverse sm:flex-row gap-3">
                        <button @click="deleteRiwayatJabatanModalOpen = false" type="button"
                            class="w-full sm:w-auto px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition-colors duration-200">
                            Batal
                        </button>
                        <button type="submit"
                            class="w-full sm:w-auto px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
