@props(['title', 'action'])

<div x-data="{ show: false }" x-show="show" @keydown.escape.window="show = false"
    x-on:open-delete-modal.window="show = true; $refs.form.action = event.detail.action" style="display: none;"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
    <div @click="show = false" class="fixed inset-0 bg-black/50" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"></div>

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
                    <svg class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $title }}
                    </h3>
                    <div class="mt-2 text-sm text-gray-500">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-row-reverse space-x-2 space-x-reverse bg-gray-50 px-6 py-3">
            <form x-ref="form" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:text-sm">
                    Ya, Hapus Data
                </button>
            </form>
            <button @click="show = false" type="button"
                class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:text-sm">
                Batal
            </button>
        </div>
    </div>
</div>
