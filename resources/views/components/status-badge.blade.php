@props(['status'])

@php
    $statusConfig = [
        'diajukan' => ['bg-blue-100', 'text-blue-800', 'border-blue-200'],
        'disetujui' => ['bg-green-100', 'text-green-800', 'border-green-200'],
        'ditolak' => ['bg-red-100', 'text-red-800', 'border-red-200'],
        'perlu_perbaikan' => ['bg-yellow-100', 'text-yellow-800', 'border-yellow-200'],
    ];
    $config = $statusConfig[$status] ?? ['bg-gray-100', 'text-gray-800', 'border-gray-200'];
@endphp

<span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full border {{ implode(' ', $config) }}">
    {{ Str::title(str_replace('_', ' ', $status)) }}
</span>
