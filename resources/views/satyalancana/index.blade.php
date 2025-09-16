<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                {{ __('Usulan Penghargaan Satyalancana') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Menampilkan Pesan Feedback --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                    class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded-lg shadow-md" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div>
                            <p class="font-bold">Berhasil!</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md" role="alert">
                    <p class="font-bold">Terjadi Kesalahan</p>
                    <p>{{ $errors->first() }}</p>
                </div>
            @endif



            {{-- Tab Interface --}}
            <div x-data="{ 
                tab: 'xxx', 
                get totalX() { return {{ count($eligible['x']) }}; },
                get totalXX() { return {{ count($eligible['xx']) }}; },
                get totalXXX() { return {{ count($eligible['xxx']) }}; }
            }" class="bg-white rounded-2xl shadow-lg overflow-hidden">
                
                {{-- Tab Headers --}}
                <div class="border-b border-gray-200">
                    <div class="-mb-px flex px-4 sm:px-6" aria-label="Tabs">
                        <button @click="tab = 'xxx'"
                            :class="tab === 'xxx' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                            30 Tahun
                            <span :class="tab === 'xxx' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600'" class="ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium" x-text="totalXXX"></span>
                        </button>
                        <button @click="tab = 'xx'"
                            :class="tab === 'xx' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm ml-8 flex items-center">
                            20 Tahun
                            <span :class="tab === 'xx' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600'" class="ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium" x-text="totalXX"></span>
                        </button>
                        <button @click="tab = 'x'"
                            :class="tab === 'x' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm ml-8 flex items-center">
                            10 Tahun
                            <span :class="tab === 'x' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600'" class="ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium" x-text="totalX"></span>
                        </button>
                    </div>
                </div>

                @foreach (['xxx' => 30, 'xx' => 20, 'x' => 10] as $key => $masa_kerja)
                    <div x-show="tab === '{{ $key }}'" class="p-6">
                        @if (empty($eligible[$key]))
                            <div class="text-center py-16">
                                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak Ada Kandidat</h3>
                                <p class="mt-1 text-sm text-gray-500">Tidak ada pegawai yang memenuhi syarat untuk kategori ini.</p>
                            </div>
                        @else
                            <form action="{{ route('satyalancana.store') }}" method="POST" x-data="{ selectAll: false, selectedCount: 0 }">
                                @csrf
                                <input type="hidden" name="masa_kerja" value="{{ $masa_kerja }}">

                                <div class="flex justify-end mb-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="selectAll-{{ $key }}" x-model="selectAll" 
                                               @click="selectedCount = $event.target.checked ? {{ count($eligible[$key]) }} : 0; document.querySelectorAll('.pegawai-checkbox-{{ $key }}').forEach(cb => { cb.checked = $event.target.checked });"
                                            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="selectAll-{{ $key }}" class="ml-2 block text-sm text-gray-900">Pilih Semua</label>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($eligible[$key] as $item)
                                        <label
                                            class="relative flex items-start p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition-colors has-[:checked]:bg-blue-50 has-[:checked]:border-blue-300">
                                            <input type="checkbox" name="pegawai_ids[]" value="{{ $item['pegawai']->id }}"
                                                   @change="selectedCount += $event.target.checked ? 1 : -1"
                                                class="peer pegawai-checkbox-{{ $key }} h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1 flex-shrink-0">
                                            <div class="ml-3 flex-1 min-w-0">
                                                <p class="font-semibold text-gray-900 text-sm">{{ $item['pegawai']->nama_lengkap }}</p>
                                                <p class="text-xs text-gray-500">NIP: {{ $item['pegawai']->user->nip ?? 'N/A' }}</p>
                                                <div class="mt-2 text-xs text-gray-600 space-y-1">
                                                    <p class="flex items-center"><svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg> {{ Str::limit($item['pegawai']->opd->nama_opd ?? 'N/A', 30) }}</p>
                                                    <p class="flex items-center"><svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Masa Kerja: {{ floor($item['masaKerja']) }} Tahun</p>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                <div class="mt-6 pt-6 border-t bg-gray-50 -m-6 px-6 pb-6 rounded-b-2xl">
                                    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                                        <div class="w-full sm:w-auto">
                                            <label for="periode-{{ $key }}" class="block text-sm font-medium text-gray-700">Periode Usulan</label>
                                            <select id="periode-{{ $key }}" name="periode" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                                @foreach ($daftarPeriode as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <x-primary-button type="submit" class="w-full sm:w-auto justify-center" x-bind:disabled="selectedCount === 0">
                                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M3.105 2.289a.75.75 0 00-.826.95l1.414 4.925A1.5 1.5 0 005.135 9.25h6.115a.75.75 0 010 1.5H5.135a1.5 1.5 0 00-1.442 1.086L2.28 16.761a.75.75 0 00.95.826l16-5.333a.75.75 0 000-1.418l-16-5.333z" /></svg>
                                            <span>Usulkan</span>
                                            <span x-show="selectedCount > 0" x-text="selectedCount" class="ml-1.5 font-bold"></span>
                                            <span x-show="selectedCount > 0" class="ml-1">Kandidat</span>
                                        </x-primary-button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>