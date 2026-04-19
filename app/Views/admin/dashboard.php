<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Yönetici Paneli</h1>
            <p class="text-sm text-slate-500 mt-1">
                Hoş geldin, <?= esc($currentUser->username) ?>!
            </p>
        </div>
        <span class="badge-info">Hafta 1 — Çekirdek Yapı</span>
    </div>

    <!-- İstatistik kartları - Hafta 5'te gerçek veri bağlanacak -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card">
            <div class="text-sm text-slate-500">Toplam Envanter</div>
            <div class="text-3xl font-bold text-slate-900 mt-2"><?= $stats['total_inventory'] ?></div>
            <div class="text-xs text-slate-400 mt-1">Hafta 2 tamamlanınca dolacak</div>
        </div>
        <div class="card">
            <div class="text-sm text-slate-500">Bekleyen Talepler</div>
            <div class="text-3xl font-bold text-amber-600 mt-2"><?= $stats['pending_requests'] ?></div>
            <div class="text-xs text-slate-400 mt-1">Hafta 3 tamamlanınca dolacak</div>
        </div>
        <div class="card">
            <div class="text-sm text-slate-500">Aktif Zimmetler</div>
            <div class="text-3xl font-bold text-brand-600 mt-2"><?= $stats['active_assignments'] ?></div>
            <div class="text-xs text-slate-400 mt-1">Hafta 4 tamamlanınca dolacak</div>
        </div>
        <div class="card">
            <div class="text-sm text-slate-500">Toplam Kullanıcı</div>
            <div class="text-3xl font-bold text-slate-900 mt-2"><?= $stats['total_users'] ?></div>
            <div class="text-xs text-slate-400 mt-1">Shield'den gelir</div>
        </div>
    </div>

    <!-- Modül durumu -->
    <div class="card">
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Proje Durumu</h2>
        <div class="space-y-3">
            <div class="flex items-center justify-between py-2 border-b border-slate-100">
                <div>
                    <div class="font-medium text-slate-900">Hafta 1 — Çekirdek Yapı</div>
                    <div class="text-xs text-slate-500">CodeIgniter + Shield + Tailwind kurulumu</div>
                </div>
                <span class="badge-success">Tamamlandı</span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-slate-100">
                <div>
                    <div class="font-medium text-slate-900">Hafta 2 — Envanter Modülü</div>
                    <div class="text-xs text-slate-500">Kategori ve ürün CRUD, görsel yükleme</div>
                </div>
                <span class="badge bg-slate-100 text-slate-700">Bekliyor</span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-slate-100">
                <div>
                    <div class="font-medium text-slate-900">Hafta 3 — Talep Modülü</div>
                    <div class="text-xs text-slate-500">Personel talep formu ve validasyon</div>
                </div>
                <span class="badge bg-slate-100 text-slate-700">Bekliyor</span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-slate-100">
                <div>
                    <div class="font-medium text-slate-900">Hafta 4 — Onay ve Zimmet</div>
                    <div class="text-xs text-slate-500">Admin onay paneli ve zimmetleme</div>
                </div>
                <span class="badge bg-slate-100 text-slate-700">Bekliyor</span>
            </div>
            <div class="flex items-center justify-between py-2">
                <div>
                    <div class="font-medium text-slate-900">Hafta 5 — Raporlama ve API</div>
                    <div class="text-xs text-slate-500">Dashboard grafiği, Chart.js, JSON API</div>
                </div>
                <span class="badge bg-slate-100 text-slate-700">Bekliyor</span>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
