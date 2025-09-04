<div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
    <div class="flex items-center mb-4">
        <div class="p-2 bg-green-100 rounded-lg mr-3">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6" />
            </svg>
        </div>
        <h4 class="text-lg font-semibold text-gray-900">Data Kepegawaian</h4>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2 space-y-1">
            <dt class="text-sm font-medium text-gray-600">Unit Kerja (OPD)</dt>
            <dd class="text-sm text-gray-900 font-semibold">
                {{ $pegawai->opd->nama_opd ?? '-' }}</dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">Status Kepegawaian</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->status_kepegawaian ?? '-' }}</dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">Jenis Kepegawaian</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->jenis_kepegawaian ?? '-' }}</dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">Pangkat</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->pangkat ?? '-' }}</dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">Golongan</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->golongan ?? '-' }}</dd>
        </div>
        <div class="md:col-span-2 space-y-1">
            <dt class="text-sm font-medium text-gray-600">Unit Kerja</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->unit_kerja ?? '-' }}</dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">TMT CPNS</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->tmt_cpns ? \Carbon\Carbon::parse($pegawai->tmt_cpns)->translatedFormat('d F Y') : '-' }}
            </dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">Nomor SK CPNS</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->nomor_sk_cpns ?? '-' }}</dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">TMT PNS</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->tmt_pns ? \Carbon\Carbon::parse($pegawai->tmt_pns)->translatedFormat('d F Y') : '-' }}
            </dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">Nomor SK PNS</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->nomor_sk_pns ?? '-' }}</dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">TMT Jabatan</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->tmt_jabatan ? \Carbon\Carbon::parse($pegawai->tmt_jabatan)->translatedFormat('d F Y') : '-' }}
            </dd>
        </div>
    </div>
</div>
