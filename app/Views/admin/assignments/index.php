<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Zimmet Kayıtları</h1>
            <p class="text-sm text-slate-500 mt-1">Personele zimmetlenen cihazların listesi</p>
        </div>
        <span class="badge-info">Hafta 4 — Zimmet Yönetimi</span>
    </div>

    <div class="card p-0 overflow-hidden border border-slate-200 rounded-lg shadow-sm">
        <div class="overflow-y-auto max-h-[calc(100vh-250px)]">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 z-10 bg-slate-50 text-xs uppercase text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold">#</th>
                        <th class="px-4 py-3 font-semibold">Personel</th>
                        <th class="px-4 py-3 font-semibold">Cihaz</th>
                        <th class="px-4 py-3 font-semibold">Marka</th>
                        <th class="px-4 py-3 font-semibold">Seri No</th>
                        <th class="px-4 py-3 font-semibold">Zimmet Tarihi</th>
                        <th class="px-4 py-3 font-semibold text-right">İşlem</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    <?php if (empty($assignments)): ?>
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl mb-2">📦</span>
                                    <p>Henüz zimmet kaydı bulunamadı.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($assignments as $assignment): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 text-sm font-mono text-slate-500"><?= $assignment['id'] ?></td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-brand-100 text-brand-700 rounded-full flex items-center justify-center text-xs font-bold">
                                            <?= strtoupper(substr($assignment['staff_name'] ?? '?', 0, 1)) ?>
                                        </div>
                                        <span class="font-medium text-slate-900"><?= esc($assignment['staff_name'] ?? 'Bilinmiyor') ?></span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-slate-900"><?= esc($assignment['inventory_name'] ?? '—') ?></div>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-600">
                                    <?= esc($assignment['brand'] ?? '—') ?>
                                </td>
                                <td class="px-4 py-3 text-sm font-mono text-slate-600">
                                    <?= esc($assignment['serial_no'] ?? '—') ?>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-500">
                                    <?= $assignment['assigned_at'] ? date('d.m.Y H:i', strtotime($assignment['assigned_at'])) : '—' ?>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="/admin/assignments/<?= $assignment['id'] ?>"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium bg-brand-50 text-brand-700 hover:bg-brand-100 transition-colors">
                                            🔍 Detay
                                        </a>
                                        <a href="/admin/assignments/print/<?= $assignment['id'] ?>"
                                           target="_blank"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
                                            🖨️ Yazdır
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
