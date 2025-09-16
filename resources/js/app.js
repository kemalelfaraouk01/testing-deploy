import './bootstrap';

import Alpine from 'alpinejs';
import.meta.glob([
    '../images/**',
]);

// Import Turbo
import * as Turbo from '@hotwired/turbo';

// Definisikan komponen Alpine untuk notifikasi
Alpine.data('notificationBell', () => ({
    notifications: [],
    unreadCount: 0,
    showNotificationDeleteModal: false,
    csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

    init(initialNotifications, initialUnreadCount) {
        this.notifications = initialNotifications;
        this.unreadCount = initialUnreadCount;

        window.addEventListener('notifications-cleared', () => {
            this.notifications = [];
            this.unreadCount = 0;
        });
    },

    timeAgo(dateString) {
        const date = new Date(dateString);
        const seconds = Math.floor((new Date() - date) / 1000);
        let interval = seconds / 31536000;
        if (interval > 1) return Math.floor(interval) + " tahun lalu";
        interval = seconds / 2592000;
        if (interval > 1) return Math.floor(interval) + " bulan lalu";
        interval = seconds / 86400;
        if (interval > 1) return Math.floor(interval) + " hari lalu";
        interval = seconds / 3600;
        if (interval > 1) return Math.floor(interval) + " jam lalu";
        interval = seconds / 60;
        if (interval > 1) return Math.floor(interval) + " menit lalu";
        return "Baru saja";
    },

    async markAsRead(notificationId, targetUrl) {
        const notification = this.notifications.find(n => n.id === notificationId);
        if (notification && !notification.read_at) {
            try {
                await fetch(`/notifications/${notificationId}/read`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': this.csrfToken }
                });
                notification.read_at = new Date().toISOString();
                this.unreadCount--;
            } catch (error) {
                // Gagal dalam diam, tetap navigasi
            } finally {
                Turbo.visit(targetUrl);
            }
        } else {
            Turbo.visit(targetUrl);
        }
    },

    markAllAsRead() {
        fetch('/notifications/mark-all-as-read', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': this.csrfToken }
        }).then(response => {
            if (response.ok) {
                this.notifications.forEach(n => {
                    if (!n.read_at) {
                        n.read_at = new Date().toISOString();
                    }
                });
                this.unreadCount = 0;
            }
        });
    },
}));

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
