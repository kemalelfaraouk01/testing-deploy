<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Impor Data OPD dari Excel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                @if (session('import_errors'))
                    <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded-lg" role="alert">
                        <p class="font-bold">Impor Gagal! Ada beberapa kesalahan pada file Excel Anda:</p>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach (session('import_errors') as $failure)
                                <li>
                                    <strong>Baris {{ $failure->row() }}:</strong> {{ $failure->errors()[0] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-md">
                    <h4 class="font-bold text-blue-800">Petunjuk Format File Excel</h4>
                    <ul class="list-disc list-inside text-sm text-gray-700 mt-2 space-y-1">
                        <li>Pastikan baris pertama (header) berisi <strong>nama_opd</strong> dan
                            <strong>alamat</strong>.</li>
                        <li>Kolom <strong>nama_opd</strong> wajib diisi dan harus unik.</li>
                        <li>Kolom <strong>alamat</strong> bersifat opsional.</li>
                    </ul>
                </div>

                <form method="POST" action="{{ route('opd.import.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <x-input-label for="file" :value="__('Pilih File Excel (.xlsx, .xls)')" />
                        <input type="file" name="file" id="file"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required
                            accept=".xlsx, .xls" />
                        <x-input-error :messages="$errors->get('file')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6 space-x-4">
                        <a href="{{ route('opd.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                        <x-primary-button>
                            Impor Data OPD
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
