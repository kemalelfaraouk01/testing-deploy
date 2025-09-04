@if (session('error'))
    <div x-data="{ show: true, message: '{{ session('error') }}' }" x-show="show" x-on:keydown.escape.window="show = false" style="display: none;"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
        <div @click="show = false" class="fixed inset-0 bg-black/50" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
        </div>

        <div class="relative w-full max-w-md overflow-hidden rounded-lg bg-white shadow-xl transform transition-all"
            x-show="show" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="p-6">
                <div class="flex space-x-4">
                    <div
                        class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:h-10 sm:w-10">
                        {{-- Ikon Peringatan --}}
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-medium text-gray-900">
                            Terjadi Kesalahan
                        </h3>
                        <div class="mt-2 text-sm text-gray-500" x-text="message">
                            {{-- Pesan error akan ditampilkan di sini --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-row-reverse bg-gray-50 px-6 py-3">
                <button @click="show = false" type="button"
                    class="inline-flex justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:text-sm">
                    Mengerti
                </button>
            </div>
        </div>
    </div>
@endif
