@props(['show' => false])

<div x-data="{ show: false, action: '', hash: '' }" x-show="show" @keydown.escape.window="show = false"
    x-on:open-delete-modal.window="show = true; action = event.detail.action; hash = event.detail.hash" style="display: none;"
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
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 18.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Konfirmasi Penghapusan</h3>
                <p class="mt-2 text-sm text-gray-600">
                    Apakah Anda yakin ingin menghapus semua notifikasi? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
        </div>
        <div class="flex flex-row-reverse space-x-2 space-x-reverse bg-gray-50 px-6 py-3">
            <form x-bind:action="action" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="hash" x-bind:value="hash">
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