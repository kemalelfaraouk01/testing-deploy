@if (session('success'))
    <div x-data="{ show: true, message: '{{ session('success') }}' }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" style="display: none;"
        class="fixed top-5 right-5 z-50 w-full max-w-sm rounded-lg bg-white shadow-lg pointer-events-auto ring-1 ring-black ring-opacity-5">
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                        <style>
                            .checkmark-circle {
                                stroke-dasharray: 100;
                                stroke-dashoffset: 100;
                                animation: draw-circle 0.5s ease-out forwards;
                            }

                            .checkmark-check {
                                stroke-dasharray: 50;
                                stroke-dashoffset: 50;
                                animation: draw-check 0.4s 0.5s ease-out forwards;
                            }

                            @keyframes draw-circle {
                                to {
                                    stroke-dashoffset: 0;
                                }
                            }

                            @keyframes draw-check {
                                to {
                                    stroke-dashoffset: 0;
                                }
                            }
                        </style>
                        <circle class="checkmark-circle" cx="16" cy="16" r="15" fill="none"
                            stroke="#4CAF50" stroke-width="2" />
                        <path class="checkmark-check" fill="none" stroke="#4CAF50" stroke-width="3"
                            stroke-linecap="round" stroke-linejoin="round" d="M9 16l5 5 9-9" />
                    </svg>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-semibold text-gray-900">
                        Berhasil!
                    </p>
                    <p class="mt-1 text-sm text-gray-600" x-text="message"></p>
                </div>
                <div class="ml-4 flex flex-shrink-0">
                    <button @click="show = false"
                        class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="sr-only">Tutup</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path
                                d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
