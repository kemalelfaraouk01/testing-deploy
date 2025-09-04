<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pengajuan Cuti') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                {{-- Sisa Cuti Info - Responsive Card --}}
                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-800 mb-1">Sisa Cuti Tahunan Anda</p>
                            <p class="text-2xl sm:text-3xl font-bold text-blue-700">{{ $totalSisaCuti ?? 12 }} Hari</p>
                        </div>
                        <div class="mt-3 sm:mt-0">
                            <svg class="w-8 h-8 sm:w-12 sm:h-12 text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a2 2 0 012 2v1a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2h3z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('cuti.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-6">

                        <!-- Jenis Cuti -->
                        <div>
                            <x-input-label for="jenis_cuti" :value="__('Jenis Cuti')"
                                class="text-sm font-medium text-gray-700" />
                            <select name="jenis_cuti" id="jenis_cuti"
                                class="block mt-2 w-full rounded-lg shadow-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base"
                                required>
                                <option value="">Pilih Jenis Cuti</option>
                                <option value="Cuti Tahunan"
                                    {{ old('jenis_cuti') == 'Cuti Tahunan' ? 'selected' : '' }}>
                                    Cuti Tahunan
                                </option>
                                <option value="Cuti Sakit" {{ old('jenis_cuti') == 'Cuti Sakit' ? 'selected' : '' }}>
                                    Cuti Sakit
                                </option>
                                <option value="Cuti Alasan Penting"
                                    {{ old('jenis_cuti') == 'Cuti Alasan Penting' ? 'selected' : '' }}>
                                    Cuti Alasan Penting
                                </option>
                                <option value="Cuti Melahirkan"
                                    {{ old('jenis_cuti') == 'Cuti Melahirkan' ? 'selected' : '' }}>
                                    Cuti Melahirkan
                                </option>
                                <option value="Cuti di Luar Tanggungan Negara"
                                    {{ old('jenis_cuti') == 'Cuti di Luar Tanggungan Negara' ? 'selected' : '' }}>
                                    Cuti di Luar Tanggungan Negara
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('jenis_cuti')" class="mt-2" />
                        </div>

                        <!-- Tanggal Range - Responsive Grid -->
                        <div class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-4">
                            <div>
                                <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')"
                                    class="text-sm font-medium text-gray-700" />
                                <x-text-input id="tanggal_mulai"
                                    class="block mt-2 w-full text-sm sm:text-base rounded-lg" type="date"
                                    name="tanggal_mulai" :value="old('tanggal_mulai')" required />
                                <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai')"
                                    class="text-sm font-medium text-gray-700" />
                                <x-text-input id="tanggal_selesai"
                                    class="block mt-2 w-full text-sm sm:text-base rounded-lg" type="date"
                                    name="tanggal_selesai" :value="old('tanggal_selesai')" required />
                                <x-input-error :messages="$errors->get('tanggal_selesai')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div>
                            <x-input-label for="keterangan" :value="__('Keterangan / Alasan Cuti')"
                                class="text-sm font-medium text-gray-700" />
                            <textarea name="keterangan" id="keterangan" rows="4"
                                class="block mt-2 w-full rounded-lg shadow-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base resize-none"
                                placeholder="Jelaskan alasan pengajuan cuti Anda...">{{ old('keterangan') }}</textarea>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>

                        <!-- File Upload - Mobile Optimized -->
                        <div>
                            <x-input-label for="file_lampiran" :value="__('Lampiran (Opsional)')"
                                class="text-sm font-medium text-gray-700" />
                            <div class="mt-2">
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                                    <input type="file" name="file_lampiran" id="file_lampiran"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:outline-none"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" />
                                </div>
                                <p class="mt-2 text-xs text-gray-500">
                                    Format yang didukung: PDF, DOC, DOCX, JPG, PNG (Max: 2MB)
                                </p>
                            </div>
                            <x-input-error :messages="$errors->get('file_lampiran')" class="mt-2" />
                        </div>

                        <!-- Duration Calculator Info -->
                        <div id="duration-info" class="hidden p-3 bg-gray-50 border border-gray-200 rounded-lg">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm text-gray-600">
                                    <span class="font-medium">Durasi cuti:</span>
                                    <span id="duration-days" class="font-bold text-blue-600">0 hari</span>
                                </span>
                            </div>
                        </div>

                    </div>

                    <!-- Action Buttons - Mobile Optimized -->
                    <div
                        class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end mt-8 space-y-3 space-y-reverse sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('cuti.index') }}"
                            class="w-full sm:w-auto text-center px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Batal
                        </a>
                        <x-primary-button class="w-full sm:w-auto justify-center px-6 py-2.5 text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Kirim Pengajuan
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Duration Calculator
        function calculateDuration() {
            const startDate = document.getElementById('tanggal_mulai').value;
            const endDate = document.getElementById('tanggal_selesai').value;
            const durationInfo = document.getElementById('duration-info');
            const durationDays = document.getElementById('duration-days');

            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);

                if (end >= start) {
                    const timeDiff = end.getTime() - start.getTime();
                    const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;

                    durationDays.textContent = `${dayDiff} hari`;
                    durationInfo.classList.remove('hidden');
                } else {
                    durationInfo.classList.add('hidden');
                }
            } else {
                durationInfo.classList.add('hidden');
            }
        }

        // Event listeners
        document.getElementById('tanggal_mulai').addEventListener('change', calculateDuration);
        document.getElementById('tanggal_selesai').addEventListener('change', calculateDuration);

        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tanggal_mulai').setAttribute('min', today);
        document.getElementById('tanggal_selesai').setAttribute('min', today);

        // Update end date minimum when start date changes
        document.getElementById('tanggal_mulai').addEventListener('change', function() {
            document.getElementById('tanggal_selesai').setAttribute('min', this.value);
        });
    </script>

</x-app-layout>
