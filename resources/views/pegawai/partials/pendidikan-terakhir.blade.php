<div class="bg-gradient-to-r from-purple-50 to-violet-50 rounded-xl p-6 border border-purple-100">
    <div class="flex items-center mb-4">
        <div class="p-2 bg-purple-100 rounded-lg mr-3">
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
        </div>
        <h4 class="text-lg font-semibold text-gray-900">Pendidikan Terakhir</h4>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">Jenjang</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->pendidikan_terakhir ?? '-' }}</dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">Tahun Lulus</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->tahun_lulus ?? '-' }}</dd>
        </div>
        <div class="md:col-span-2 space-y-1">
            <dt class="text-sm font-medium text-gray-600">Jurusan</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->jurusan ?? '-' }}</dd>
        </div>
        <div class="md:col-span-2 space-y-1">
            <dt class="text-sm font-medium text-gray-600">Asal Sekolah / Universitas
            </dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->asal_sekolah ?? '-' }}</dd>
        </div>
    </div>
</div>
