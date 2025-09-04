{{-- BAGIAN DATA PRIBADI --}}
<div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
    <div class="flex items-center mb-4">
        <div class="p-2 bg-blue-100 rounded-lg mr-3">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
        <h4 class="text-lg font-semibold text-gray-900">Data Pribadi</h4>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">Jenis Kelamin</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">Agama</dt>
            <dd class="text-sm text-gray-900 font-medium">{{ $pegawai->agama ?? '-' }}
            </dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">Tanggal Lahir</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
            </dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">Status Perkawinan</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->status_perkawinan ?? '-' }}</dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">No. HP</dt>
            <dd class="text-sm text-gray-900 font-medium">{{ $pegawai->no_hp ?? '-' }}
            </dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">Email</dt>
            <dd class="text-sm text-gray-900 font-medium">{{ $pegawai->email ?? '-' }}
            </dd>
        </div>
        <div class="md:col-span-2 space-y-1">
            <dt class="text-sm font-medium text-gray-600">Alamat</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->alamat ?? '-' }}</dd>
        </div>
    </div>
</div>
