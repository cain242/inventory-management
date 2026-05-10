<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Zimmet Detayı</h1>
            <p class="text-sm text-slate-500 mt-1">Zimmet kaydı #<?= $assignment['id'] ?></p>
        </div>
        <div class="flex gap-2">
            <a href="/admin/assignments/print/<?= $assignment['id'] ?>" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
                🖨️ Yazdır
            </a>
            <a href="/admin/assignments" class="btn-secondary text-sm">← Listeye Dön</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Personel Bilgileri -->
        <div class="card">
            <h2 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 bg-brand-100 text-brand-700 rounded-lg flex items-center justify-center text-sm">👤</span>
                Personel Bilgileri
            </h2>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-sm text-slate-500">Personel Adı</span>
                    <span class="text-sm font-medium text-slate-900"><?= esc($assignment['staff_name'] ?? 'Bilinmiyor') ?></span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-sm text-slate-500">Onaylayan Admin</span>
                    <span class="text-sm font-medium text-slate-900"><?= esc($assignment['approver_name'] ?? '—') ?></span>
                </div>
            </div>
        </div>

        <!-- Cihaz Bilgileri -->
        <div class="card">
            <h2 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 bg-green-100 text-green-700 rounded-lg flex items-center justify-center text-sm">💻</span>
                Cihaz Bilgileri
            </h2>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-sm text-slate-500">Cihaz Adı</span>
                    <span class="text-sm font-medium text-slate-900"><?= esc($assignment['inventory_name'] ?? '—') ?></span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-sm text-slate-500">Marka</span>
                    <span class="text-sm font-medium text-slate-900"><?= esc($assignment['brand'] ?? '—') ?></span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-sm text-slate-500">Seri No</span>
                    <span class="text-sm font-mono text-slate-900"><?= esc($assignment['serial_no'] ?? '—') ?></span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-sm text-slate-500">Envanter Durumu</span>
                    <span class="badge-info"><?= esc($assignment['inventory_status'] ?? '—') ?></span>
                </div>
            </div>
        </div>

    </div>

    <!-- Zimmet Bilgileri -->
    <div class="card">
        <h2 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
            <span class="w-8 h-8 bg-amber-100 text-amber-700 rounded-lg flex items-center justify-center text-sm">📋</span>
            Zimmet Bilgileri
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-slate-50 rounded-lg p-4">
                <div class="text-xs text-slate-500 uppercase tracking-wider">Zimmet Tarihi</div>
                <div class="text-sm font-medium text-slate-900 mt-1">
                    <?= $assignment['assigned_at'] ? date('d.m.Y H:i', strtotime($assignment['assigned_at'])) : '—' ?>
                </div>
            </div>
            <div class="bg-slate-50 rounded-lg p-4">
                <div class="text-xs text-slate-500 uppercase tracking-wider">İade Tarihi</div>
                <div class="text-sm font-medium text-slate-900 mt-1">
                    <?= $assignment['returned_at'] ? date('d.m.Y H:i', strtotime($assignment['returned_at'])) : 'İade edilmedi' ?>
                </div>
            </div>
            <div class="bg-slate-50 rounded-lg p-4">
                <div class="text-xs text-slate-500 uppercase tracking-wider">Talep No</div>
                <div class="text-sm font-medium text-slate-900 mt-1">
                    #<?= $assignment['request_id'] ?? '—' ?>
                </div>
            </div>
        </div>
        <?php if (!empty($assignment['notes'])): ?>
            <div class="mt-4 bg-blue-50 border border-blue-100 rounded-lg p-4">
                <div class="text-xs text-blue-600 uppercase tracking-wider mb-1">Notlar</div>
                <p class="text-sm text-blue-900"><?= esc($assignment['notes']) ?></p>
            </div>
        <?php endif ?>
    </div>

</div>
<?= $this->endSection() ?>
