<!-- sidebar.blade.php -->
<div id="main-sidebar"
    class="fixed inset-y-0 left-0 z-40 w-64 bg-gray-900 text-slate-300 flex flex-col transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:relative lg:inset-0 lg:sticky lg:top-0 lg:h-screen border-r border-slate-700"
    :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">

    @php
        $initialOpenMenu = '';
        if (request()->routeIs('pengajuan-tpp.*', 'verifikasi-tpp.*')) {
            $initialOpenMenu = 'tpp';
        } elseif (request()->routeIs('users.*', 'opd.*', 'jabatan.*')) {
            $initialOpenMenu = 'settings';
        } elseif (request()->routeIs('cuti.*', 'verifikasi-cuti.*')) {
            $initialOpenMenu = 'cuti';
        } elseif (request()->routeIs('satyalancana.*', 'verifikasi-satyalancana.*')) {
            $initialOpenMenu = 'penghargaan';
        } elseif (request()->routeIs('pensiun.*')) {
            $initialOpenMenu = 'pensiun';
        }
    @endphp

    <div x-data="{ openMenu: localStorage.getItem('sidebarOpenMenu') || '{{ $initialOpenMenu }}' }" x-init="$watch('openMenu', value => localStorage.setItem('sidebarOpenMenu', value))" class="flex flex-col flex-1">

        <!-- Header -->
        <div class="flex items-center justify-between h-20 px-4  flex-shrink-0 bg-slate-900">
            <a href="{{ route('dashboard') }}" class="flex items-center group">
                <img src="{{ asset('images/logo-bkpsdm.png') }}" alt="Logo BKPSDM" class="h-10 w-auto mr-3">
                <div>
                    <h1
                        class="text-lg font-bold text-white group-hover:text-blue-400 transition-colors duration-200 leading-tight">
                        Si YANTI</h1>
                    <p class="text-xs text-slate-400 mt-0.5 font-medium">Kota Bengkulu</p>
                </div>
            </a>
        </div>

        <!-- Navigation -->
        <nav
            class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto scrollbar-thin scrollbar-thumb-slate-600 scrollbar-track-slate-800 min-h-0">

            @php
                function getLinkClasses($routeName)
                {
                    $activeClasses = 'bg-blue-600 text-white font-semibold shadow-lg';
                    $inactiveClasses = 'text-slate-300 hover:bg-slate-700 hover:text-white';
                    return request()->routeIs($routeName) ? $activeClasses : $inactiveClasses;
                }
                function getSubLinkClasses($routeName)
                {
                    $activeClasses = 'bg-slate-600 text-white font-medium';
                    $inactiveClasses = 'text-slate-400 hover:bg-slate-700 hover:text-white';
                    return request()->routeIs($routeName) ? $activeClasses : $inactiveClasses;
                }
            @endphp

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" @click="sidebarOpen = false"
                class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 group {{ getLinkClasses('dashboard') }}">
                <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-white' : '' }}"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Data Pegawai -->
            @role('Admin|Operator TPP|Kepala Bidang|Kepala OPD')
                <a href="{{ route('pegawai.index') }}" @click="sidebarOpen = false"
                    class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 group {{ getLinkClasses('pegawai.*') }}">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white transition-colors duration-200 {{ request()->routeIs('pegawai.*') ? 'text-white' : '' }}"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                    <span>Data Pegawai</span>
                </a>
            @endrole

            <!-- Cuti Dropdown -->
            <div class="relative">
                <button @click="openMenu = (openMenu === 'cuti' ? '' : 'cuti')"
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-all duration-200 group">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white transition-colors duration-200"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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
                <div x-show="openMenu === 'cuti'" x-transition
                    class="mt-2 ml-4 pl-4 border-l border-slate-600 space-y-1">
                    <a href="{{ route('cuti.index') }}" @click="sidebarOpen = false"
                        class="block w-full px-4 py-2 rounded-md text-sm transition-all duration-200 {{ getSubLinkClasses('cuti.*') }}">
                        Usulan Cuti</a>
                    @role('Admin|Verif Cuti Kabid|Verif Cuti KaOPD')
                        <a href="{{ route('verifikasi-cuti.index') }}" @click="sidebarOpen = false"
                            class="block w-full px-4 py-2 rounded-md text-sm transition-all duration-200 {{ getSubLinkClasses('verifikasi-cuti.*') }}">
                            Verifikasi Cuti</a>
                    @endrole
                </div>
            </div>

            <!-- TPP Dropdown -->
            @role('Admin|Operator TPP|Kepala Bidang|Verifikasi TPP')
                <div class="relative">
                    <button @click="openMenu = (openMenu === 'tpp' ? '' : 'tpp')"
                        class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-all duration-200 group">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white transition-colors duration-200"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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
                    <div x-show="openMenu === 'tpp'" x-transition
                        class="mt-2 ml-4 pl-4 border-l border-slate-600 space-y-1">
                        @role('Admin|Operator TPP|Verifikasi TPP')
                            <a href="{{ route('pengajuan-tpp.index') }}" @click="sidebarOpen = false"
                                class="block w-full px-4 py-2 rounded-md text-sm transition-all duration-200 {{ getSubLinkClasses('pengajuan-tpp.*') }}">
                                Riwayat Pengajuan</a>
                        @endrole
                        @role('Admin|Verifikasi TPP')
                            <a href="{{ route('verifikasi-tpp.index') }}" @click="sidebarOpen = false"
                                class="block w-full px-4 py-2 rounded-md text-sm transition-all duration-200 {{ getSubLinkClasses('verifikasi-tpp.*') }}">
                                Verifikasi TPP</a>
                        @endrole
                    </div>
                </div>
            @endrole

            <!-- Satyalancana Dropdown -->
            <div class="relative">
                <button @click="openMenu = (openMenu === 'penghargaan' ? '' : 'penghargaan')"
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-all duration-200 group">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white transition-colors duration-200"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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
                <div x-show="openMenu === 'penghargaan'" x-transition
                    class="mt-2 ml-4 pl-4 border-l border-slate-600 space-y-1">
                    @role('Admin|Pengelola Satyalancana')
                        <a href="{{ route('satyalancana.index') }}" @click="sidebarOpen = false"
                            class="block w-full px-4 py-2 rounded-md text-sm transition-all duration-200 {{ getSubLinkClasses('satyalancana.index') }}">
                            Usulan Satyalancana</a>
                    @endrole
                    @role('Admin|Pengelola Satyalancana')
                        <a href="{{ route('verifikasi-satyalancana.index') }}" @click="sidebarOpen = false"
                            class="block w-full px-4 py-2 rounded-md text-sm transition-all duration-200 {{ getSubLinkClasses('verifikasi-satyalancana.*') }}">
                            Verifikasi Usulan</a>
                    @endrole
                    <a href="{{ route('satyalancana.my-proposals') }}" @click="sidebarOpen = false"
                        class="block w-full px-4 py-2 rounded-md text-sm transition-all duration-200 {{ getSubLinkClasses('satyalancana.my-proposals') }}">
                        Status Usulan Saya</a>
                </div>
            </div>

            <!-- Pensiun Dropdown -->
            @role('Admin|Pengelola Pensiun')
                <div class="relative">
                    <button @click="openMenu = (openMenu === 'pensiun' ? '' : 'pensiun')"
                        class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-all duration-200 group">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white transition-colors duration-200"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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
                    <div x-show="openMenu === 'pensiun'" x-transition
                        class="mt-2 ml-4 pl-4 border-l border-slate-600 space-y-1">
                        <a href="{{ route('pensiun.index') }}" @click="sidebarOpen = false"
                            class="block w-full px-4 py-2 rounded-md text-sm transition-all duration-200 {{ getSubLinkClasses('pensiun.index') }}">
                            Usulan Pensiun</a>
                        <a href="{{ route('pensiun.cek-status') }}" @click="sidebarOpen = false"
                            class="block w-full px-4 py-2 rounded-md text-sm transition-all duration-200 {{ getSubLinkClasses('pensiun.cek-status') }}">
                            Cek Status Pensiun</a>
                    </div>
                </div>
            @endrole

            <!-- Laporan -->
            @role('Admin|Kepala Bidang|Kepala OPD')
                <a href="{{ route('laporan.index') }}" @click="sidebarOpen = false"
                    class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 group {{ getLinkClasses('laporan.*') }}">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white transition-colors duration-200 {{ request()->routeIs('laporan.*') ? 'text-white' : '' }}"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                    </svg>
                    <span>Laporan</span>
                </a>
            @endrole

            <!-- Divider -->
            <div class="pt-4 pb-2 px-4">
                <hr class="border-slate-700">
            </div>

            <!-- Settings Dropdown -->
            @can('kelola pengaturan')
                <div class="relative">
                    <button @click="openMenu = openMenu === 'settings' ? '' : 'settings'"
                        class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-all duration-200 group">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-white transition-colors duration-200"
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

                    <div x-show="openMenu === 'settings'" x-transition
                        class="mt-2 ml-4 pl-4 border-l border-slate-600 space-y-1">
                        <a href="{{ route('opd.index') }}" @click="sidebarOpen = false"
                            class="block w-full px-4 py-2 rounded-md text-sm transition-all duration-200 {{ getSubLinkClasses('opd.*') }}">
                            Data OPD</a>
                        <a href="{{ route('jabatan.index') }}" @click="sidebarOpen = false"
                            class="block w-full px-4 py-2 rounded-md text-sm transition-all duration-200 {{ getSubLinkClasses('jabatan.*') }}">
                            Data Jabatan
                        </a>
                        <a href="{{ route('users.index') }}" @click="sidebarOpen = false"
                            class="block w-full px-4 py-2 rounded-md text-sm transition-all duration-200 {{ getSubLinkClasses('users.*') }}">
                            Manajemen User
                        </a>
                    </div>
                </div>
            @endcan
        </nav>

        <!-- User Profile -->
        <div class="mt-auto p-4 border-t border-slate-700 bg-slate-900">
            <a href="{{ route('profile.edit') }}" class="flex items-center group">
                <img class="h-10 w-10 rounded-full object-cover"
                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=fff"
                    alt="User Avatar">
                <div class="ml-3">
                    <p class="text-sm font-semibold text-white group-hover:text-blue-400">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-400">Lihat Profil</p>
                </div>
            </a>
        </div>
    </div>
</div>
