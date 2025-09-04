<div id="main-sidebar"
    class="fixed inset-y-0 left-0 z-40 w-64 bg-gradient-to-b from-blue-800 to-blue-900 text-blue-50 flex flex-col transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:relative lg:inset-0 lg:sticky lg:top-0 lg:h-screen shadow-xl"
    :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">

    <div x-data="{
        openMenu: '{{ request()->routeIs('pengajuan-tpp.*') || request()->routeIs('verifikasi-tpp.*')
            ? 'tpp'
            : (request()->routeIs('users.*') || request()->routeIs('opd.*') || request()->routeIs('jabatan.*')
                ? 'settings'
                : (request()->routeIs('cuti.*') || request()->routeIs('verifikasi-cuti.*')
                    ? 'cuti'
                    : (request()->routeIs('satyalancana.*') || request()->routeIs('verifikasi-satyalancana.*')
                        ? 'penghargaan'
                        : (request()->routeIs('pensiun.*')
                            ? 'pensiun'
                            : '')))) }}'
    }">

        <!-- Header -->
        <div
            class="flex items-center justify-center h-20 bg-gradient-to-r from-blue-900 to-blue-800 px-6 border-b border-blue-700/50 flex-shrink-0">
            <a href="{{ route('dashboard') }}" class="text-center group">
                <h1 class="text-xl font-bold text-white group-hover:text-blue-200 transition-colors duration-200">SIMPEG
                    BKPSDM</h1>
                <p class="text-sm text-blue-200 mt-1 font-medium">Kota Bengkulu</p>
            </a>
        </div>

        <!-- Navigation -->
        <nav
            class="flex-1 px-4 py-6 space-y-2 overflow-y-auto scrollbar-thin scrollbar-thumb-blue-600 scrollbar-track-blue-800 min-h-0">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" @click="sidebarOpen = false"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/50 transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-blue-700 text-white font-semibold shadow-md' : 'hover:translate-x-1' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Data Pegawai -->
            @role('Admin|Pengelola|Kepala Bidang|Kepala OPD')
                <a href="{{ route('pegawai.index') }}" @click="sidebarOpen = false"
                    class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/50 transition-all duration-200 group {{ request()->routeIs('pegawai.*') ? 'bg-blue-700 text-white font-semibold shadow-md' : 'hover:translate-x-1' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                    <span>Data Pegawai</span>
                </a>
            @endrole

            <!-- Cuti Dropdown -->
            <div class="relative">
                <button @click="openMenu = (openMenu === 'cuti' ? '' : 'cuti')"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-blue-700/50 transition-all duration-200 group"
                    :class="{ 'bg-blue-700 shadow-md': openMenu === 'cuti' }">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>
                        <span class="font-medium">Cuti</span>
                    </span>
                    <svg class="h-4 w-4 transform transition-transform duration-300 ease-in-out"
                        :class="{ 'rotate-180': openMenu === 'cuti' }" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openMenu === 'cuti'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform -translate-y-2"
                    class="mt-2 ml-6 space-y-1 border-l-2 border-blue-600 pl-4">
                    <a href="{{ route('cuti.index') }}" @click="sidebarOpen = false"
                        class="block w-full px-4 py-2 rounded-md text-sm hover:bg-blue-600/50 transition-all duration-200 {{ request()->routeIs('cuti.*') ? 'bg-blue-600 text-white font-medium shadow-sm' : 'hover:translate-x-1' }}">
                        • Usulan Cuti</a>
                    @role('Admin|Verif Cuti Kabid|Verif Cuti KaOPD')
                        <a href="{{ route('verifikasi-cuti.index') }}" @click="sidebarOpen = false"
                            class="block w-full px-4 py-2 rounded-md text-sm hover:bg-blue-600/50 transition-all duration-200 {{ request()->routeIs('verifikasi-cuti.*') ? 'bg-blue-600 text-white font-medium shadow-sm' : 'hover:translate-x-1' }}">
                            • Verifikasi Cuti</a>
                    @endrole
                </div>
            </div>

            <!-- TPP Dropdown -->
            @role('Admin|Pengelola|Kepala Bidang|Verifikasi TPP')
                <div class="relative">
                    <button @click="openMenu = (openMenu === 'tpp' ? '' : 'tpp')"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-blue-700/50 transition-all duration-200 group"
                        :class="{ 'bg-blue-700 shadow-md': openMenu === 'tpp' }">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor"
                                class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12-3-3m0 0-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span class="font-medium">TPP</span>
                        </span>
                        <svg class="h-4 w-4 transform transition-transform duration-300 ease-in-out"
                            :class="{ 'rotate-180': openMenu === 'tpp' }" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="openMenu === 'tpp'" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform -translate-y-2"
                        class="mt-2 ml-6 space-y-1 border-l-2 border-blue-600 pl-4">
                        @role('Admin|Pengelola|Verifikasi TPP')
                            <a href="{{ route('pengajuan-tpp.index') }}" @click="sidebarOpen = false"
                                class="block w-full px-4 py-2 rounded-md text-sm hover:bg-blue-600/50 transition-all duration-200 {{ request()->routeIs('pengajuan-tpp.*') ? 'bg-blue-600 text-white font-medium shadow-sm' : 'hover:translate-x-1' }}">
                                • Riwayat Pengajuan</a>
                        @endrole
                        @role('Admin|Verifikasi TPP')
                            <a href="{{ route('verifikasi-tpp.index') }}" @click="sidebarOpen = false"
                                class="block w-full px-4 py-2 rounded-md text-sm hover:bg-blue-600/50 transition-all duration-200 {{ request()->routeIs('verifikasi-tpp.*') ? 'bg-blue-600 text-white font-medium shadow-sm' : 'hover:translate-x-1' }}">
                                • Verifikasi TPP</a>
                        @endrole
                    </div>
                </div>
            @endrole

            <!-- Satyalancana Dropdown -->

            <div class="relative">
                <button @click="openMenu = (openMenu === 'penghargaan' ? '' : 'penghargaan')"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-blue-700/50 transition-all duration-200 group"
                    :class="{ 'bg-blue-700 shadow-md': openMenu === 'penghargaan' }">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor"
                            class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                        </svg>
                        <span class="font-medium">Satyalancana</span>
                    </span>
                    <svg class="h-4 w-4 transform transition-transform duration-300 ease-in-out"
                        :class="{ 'rotate-180': openMenu === 'penghargaan' }" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openMenu === 'penghargaan'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform -translate-y-2"
                    class="mt-2 ml-6 space-y-1 border-l-2 border-blue-600 pl-4">

                    @role('Admin|Pengelola Satyalancana')
                        <a href="{{ route('satyalancana.index') }}" @click="sidebarOpen = false"
                            class="block w-full px-4 py-2 rounded-md text-sm hover:bg-blue-600/50 transition-all duration-200 {{ request()->routeIs('satyalancana.index') ? 'bg-blue-600 text-white font-medium shadow-sm' : 'hover:translate-x-1' }}">
                            • Usulan Satyalancana</a>
                    @endrole


                    @role('Admin|Pengelola Satyalancana')
                        <a href="{{ route('verifikasi-satyalancana.index') }}" @click="sidebarOpen = false"
                            class="block w-full px-4 py-2 rounded-md text-sm hover:bg-blue-600/50 transition-all duration-200 {{ request()->routeIs('verifikasi-satyalancana.*') ? 'bg-blue-600 text-white font-medium shadow-sm' : 'hover:translate-x-1' }}">
                            • Verifikasi Usulan</a>
                    @endrole

                    <a href="{{ route('satyalancana.my-proposals') }}" @click="sidebarOpen = false"
                        class="block w-full px-4 py-2 rounded-md text-sm hover:bg-blue-600/50 transition-all duration-200 {{ request()->routeIs('satyalancana.my-proposals') ? 'bg-blue-600 text-white font-medium shadow-sm' : 'hover:translate-x-1' }}">
                        • Status Usulan Saya</a>
                </div>
            </div>

            <!-- Pensiun Dropdown -->
            @role('Admin|Pengelola')
                <div class="relative">
                    <button @click="openMenu = (openMenu === 'pensiun' ? '' : 'pensiun')"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-blue-700/50 transition-all duration-200 group"
                        :class="{ 'bg-blue-700 shadow-md': openMenu === 'pensiun' }">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                            </svg>
                            <span class="font-medium">Pensiun</span>
                        </span>
                        <svg class="h-4 w-4 transform transition-transform duration-300 ease-in-out"
                            :class="{ 'rotate-180': openMenu === 'pensiun' }" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="openMenu === 'pensiun'" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform -translate-y-2"
                        class="mt-2 ml-6 space-y-1 border-l-2 border-blue-600 pl-4">
                        <a href="{{ route('pensiun.index') }}" @click="sidebarOpen = false"
                            class="block w-full px-4 py-2 rounded-md text-sm hover:bg-blue-600/50 transition-all duration-200 {{ request()->routeIs('pensiun.*') ? 'bg-blue-600 text-white font-medium shadow-sm' : 'hover:translate-x-1' }}">
                            • Usulan Pensiun</a>
                    </div>
                </div>
            @endrole

            <!-- Laporan -->
            @role('Admin|Kepala Bidang|Kepala OPD')
                <a href="{{ route('laporan.index') }}" @click="sidebarOpen = false"
                    class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-700/50 transition-all duration-200 group {{ request()->routeIs('laporan.*') ? 'bg-blue-700 text-white font-semibold shadow-md' : 'hover:translate-x-1' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                    </svg>
                    <span>Laporan</span>
                </a>
            @endrole

            <!-- Divider -->
            <div class="my-4">
                <hr class="border-blue-700/50">
            </div>

            <!-- Settings Dropdown -->
            @can('kelola pengaturan')
                <div class="relative">
                    <button @click="openMenu = openMenu === 'settings' ? '' : 'settings'"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-blue-700/50 transition-all duration-200 group"
                        :class="{ 'bg-blue-700 shadow-md': openMenu === 'settings' }">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.096 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="font-medium">Pengaturan</span>
                        </span>
                        <svg class="h-4 w-4 transform transition-transform duration-300 ease-in-out"
                            :class="{ 'rotate-180': openMenu === 'settings' }" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="openMenu === 'settings'" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform -translate-y-2"
                        class="mt-2 ml-6 space-y-1 border-l-2 border-blue-600 pl-4">
                        <a href="{{ route('opd.index') }}" @click="sidebarOpen = false"
                            class="block w-full px-4 py-2 rounded-md text-sm hover:bg-blue-600/50 transition-all duration-200 {{ request()->routeIs('opd.*') ? 'bg-blue-600 text-white font-medium shadow-sm' : 'hover:translate-x-1' }}">
                            • Data OPD</a>
                        <a href="{{ route('jabatan.index') }}" @click="sidebarOpen = false"
                            class="block w-full px-4 py-2 rounded-md text-sm hover:bg-blue-600/50 transition-all duration-200 {{ request()->routeIs('jabatan.*') ? 'bg-blue-600 text-white font-medium shadow-sm' : 'hover:translate-x-1' }}">
                            • Data Jabatan
                        </a>
                        <a href="{{ route('users.index') }}" @click="sidebarOpen = false"
                            class="block w-full px-4 py-2 rounded-md text-sm hover:bg-blue-600/50 transition-all duration-200 {{ request()->routeIs('users*') ? 'bg-blue-600 text-white font-medium shadow-sm' : 'hover:translate-x-1' }}">
                            • Manajemen User
                        </a>
                    </div>
                </div>
            @endcan
        </nav>
    </div>
</div>
