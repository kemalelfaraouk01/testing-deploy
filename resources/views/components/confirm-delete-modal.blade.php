@props(['show' => false])

<div x-show="{{ $show }}" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div @click.away="{{ $show }} = false" class="fixed inset-0 bg-black/60"></div>
    <div class="relative w-full max-w-md mx-auto overflow-hidden rounded-2xl bg-white shadow-xl transform transition-all">
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
        <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
            <button @click="{{ $show }} = false" type="button" class="mt-2 sm:mt-0 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm">
                Batal
            </button>
            <form action="{{ route('notifications.clearAll') }}" method="POST" class="w-full sm:w-auto">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                    Ya, Hapus Semua
                </button>
            </form>
        </div>
    </div>
</div>