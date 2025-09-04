import './bootstrap';

import Alpine from 'alpinejs';
import.meta.glob([
    '../images/**',
]);

// Import Turbo
import * as Turbo from '@hotwired/turbo';

// Jadikan Alpine bisa diakses secara global
window.Alpine = Alpine;

// Jalankan Alpine untuk pertama kali saat halaman dimuat
document.addEventListener('DOMContentLoaded', () => {
    Alpine.start();
});

// Atur agar Alpine di-reset dan dijalankan kembali setiap kali Turbo selesai menukar halaman
document.addEventListener('turbo:render', () => {
    if (typeof window.Alpine.destroyTree === 'function') {
        window.Alpine.destroyTree(document.body);
    }
    window.Alpine.start();
});

