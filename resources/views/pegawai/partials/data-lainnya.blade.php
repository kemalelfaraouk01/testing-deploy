<div class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl p-6 border border-orange-100">
    <div class="flex items-center mb-4">
        <div class="p-2 bg-orange-100 rounded-lg mr-3">
            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <h4 class="text-lg font-semibold text-gray-900">Data Lainnya</h4>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">NPWP</dt>
            <dd class="text-sm text-gray-900 font-medium">{{ $pegawai->npwp ?? '-' }}
            </dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">BPJS Kesehatan</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->bpjs_kesehatan ?? '-' }}</dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">BPJS Ketenagakerjaan</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->bpjs_ketenagakerjaan ?? '-' }}</dd>
        </div>
        <div class="space-y-1">
            <dt class="text-sm font-medium text-gray-600">Nama Bank</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->nama_bank ?? '-' }}</dd>
        </div>
        <div class="md:col-span-2 space-y-1">
            <dt class="text-sm font-medium text-gray-600">Nomor Rekening</dt>
            <dd class="text-sm text-gray-900 font-medium">
                {{ $pegawai->rekening_bank ?? '-' }}</dd>
        </div>
    </div>
</div>
