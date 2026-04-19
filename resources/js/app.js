/**
 * Envanter Yönetim Sistemi - Ana JS giriş dosyası
 *
 * CSS'i burada import ederek Vite'ın bundle etmesini sağlıyoruz.
 * İleride Chart.js, Alpine.js vb. burada import edilir.
 */

import '../css/app.css'

// Basit başlangıç kontrolü
console.log('%c Envanter Yönetim Sistemi ', 'background:#2563eb;color:white;padding:4px 8px;border-radius:4px;font-weight:bold')

// Flash mesajlarını 5 saniye sonra otomatik gizle
document.addEventListener('DOMContentLoaded', () => {
  const alerts = document.querySelectorAll('[data-auto-dismiss]')
  alerts.forEach((el) => {
    setTimeout(() => {
      el.style.transition = 'opacity 0.4s ease, transform 0.4s ease'
      el.style.opacity = '0'
      el.style.transform = 'translateY(-8px)'
      setTimeout(() => el.remove(), 400)
    }, 5000)
  })
})
