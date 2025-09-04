@props(['pengajuan', 'mobile' => false])

@if ($pengajuan->status == 'perlu_perbaikan')
    <a href="{{ route('pengajuan-tpp.edit', ['pengajuanTpp' => $pengajuan->id, 'hash' => $pengajuan->getRouteHash()]) }}"
        class="inline-flex items-center justify-center {{ $mobile ? 'w-full px-4 py-2' : 'px-3 py-1.5' }} text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 rounded-lg transition-colors shadow-sm">
        <svg class="w-4 h-4 {{ $mobile ? 'mr-2' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        Perbaiki
    </a>
@else
    <a href="{{ route('pengajuan-tpp.show', ['pengajuanTpp' => $pengajuan->id, 'hash' => $pengajuan->getRouteHash()]) }}"
        class="inline-flex items-center justify-center {{ $mobile ? 'w-full px-4 py-2' : 'px-3 py-1.5' }} text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors shadow-sm">
        <svg class="w-4 h-4 {{ $mobile ? 'mr-2' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
        Detail
    </a>
@endif
