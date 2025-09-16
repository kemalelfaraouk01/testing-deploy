<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Arsip Pegawai Pensiun') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Tombol Kembali --}}
            <div class="mb-6">
                <a href="{{ route('pegawai.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Data Pegawai Aktif
                </a>
            </div>

            {{-- Form Filter --}}
            <div class="mb-6 bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                <form method="GET" action="{{ route('pegawai.pensiun') }}">
                    <div class="flex flex-col sm:flex-row items-end gap-4">
                        <div class="w-full sm:flex-1">
                            <label for="search_nama" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama Pegawai Pensiun</label>
                            <input type="text" name="search_nama" id="search_nama" placeholder="Ketik nama pegawai..."
                                value="{{ $searchNama ?? '' }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cari
                            </button>
                            <a href="{{ route('pegawai.pensiun') }}"
                                class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-5 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900">Daftar Pegawai Pensiun</h3>
                    <p class="text-sm text-gray-600 mt-1">Menampilkan semua data pegawai yang telah memasuki masa purna tugas.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pegawai</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jabatan Terakhir</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pangkat Terakhir</th>
<<<<<<< HEAD
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis Pensiun</th>
=======
>>>>>>> 82e007e84e5692e3a77758ea4a1d8379eb8fc049
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($pegawais as $pegawai)
                                <tr class="hover:bg-blue-50 transition-colors group">
                                    <td class="px-6 py-6">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-bold text-gray-500">{{ substr($pegawai->nama_lengkap, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="text-sm font-semibold text-gray-900 line-clamp-1">{{ $pegawai->nama_lengkap }}</div>
                                                <div class="text-xs text-gray-500">NIP: {{ $pegawai->user->nip ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 text-sm text-gray-800">{{ $pegawai->jabatan ?? '-' }}</td>
                                    <td class="px-6 py-6 text-sm text-gray-800">{{ $pegawai->pangkat ?? '-' }}</td>
<<<<<<< HEAD
                                    <td class="px-6 py-6 text-sm text-gray-800">{{ $pegawai->pensiun?->jenis_pensiun ?? '-' }}</td>
=======
>>>>>>> 82e007e84e5692e3a77758ea4a1d8379eb8fc049
                                    <td class="px-6 py-6">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border bg-red-100 text-red-800 border-red-200">
                                            <div class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2"></div>
                                            <span>{{ $pegawai->status_kepegawaian }}</span>
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
<<<<<<< HEAD
                                    <td colspan="5" class="px-6 py-20 text-center">
=======
                                    <td colspan="4" class="px-6 py-20 text-center">
>>>>>>> 82e007e84e5692e3a77758ea4a1d8379eb8fc049
                                        <h3 class="text-lg font-medium text-gray-900">Belum ada data</h3>
                                        <p class="text-sm text-gray-500">Tidak ada data pegawai pensiun untuk ditampilkan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8">
                {{ $pegawais->links() }}
            </div>
        </div>
    </div>
</x-app-layout>