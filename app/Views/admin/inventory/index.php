<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Envanter Listesi</h1>
            <p class="text-sm text-slate-500 mt-1">Sistemdeki tüm donanım ve varlıkları takip et</p>
        </div>
        <a href="/admin/inventory/create" class="btn-primary">+ Yeni Ürün</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="card bg-emerald-50 border-emerald-200 text-emerald-800 p-4 rounded-md border">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="card bg-rose-50 border-rose-200 text-rose-800 p-4 rounded-md border">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif ?>

    <div class="card p-0 overflow-hidden border border-slate-200 rounded-lg shadow-sm">
        <div class="overflow-y-auto max-h-[calc(100vh-250px)]">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 z-10 bg-slate-50 text-xs uppercase text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Ürün / Marka</th>
                        <th class="px-4 py-3 font-semibold">Kategori</th>
                        <th class="px-4 py-3 font-semibold">Seri No</th>
                        <th class="px-4 py-3 font-semibold">Durum</th>
                        <th class="px-4 py-3 font-semibold">Alım Tarihi</th>
                        <th class="px-4 py-3 font-semibold text-right">İşlem</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    <?php if (empty($inventory)): ?>
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center">
                                    <span class="text-lg">📦</span>
                                    <p>Henüz envanter kaydı bulunamadı.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($inventory as $item): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-slate-900"><?= esc($item['name']) ?></div>
                                    <div class="text-xs text-slate-400"><?= esc($item['brand'] ?? 'Marka Belirtilmemiş') ?></div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800">
                                        <?= esc($item['category_name'] ?? 'Genel') ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm font-mono text-slate-600">
                                    <?= esc($item['serial_no'] ?: '—') ?>
                                </td>
                                <td class="px-4 py-3">
                                    <?php 
                                        $statusClasses = [
                                            'boşta'     => 'bg-emerald-100 text-emerald-700',
                                            'kullanımda' => 'bg-blue-100 text-blue-700',
                                            'arızalı'    => 'bg-rose-100 text-rose-700',
                                        ];
                                        $class = $statusClasses[$item['status']] ?? 'bg-slate-100 text-slate-700';
                                    ?>
                                    <span class="px-2 py-1 text-xs font-bold uppercase rounded-full <?= $class ?>">
                                        <?= esc($item['status']) ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-500">
                                    <?= esc($item['purchase_date'] ?: '—') ?>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end gap-3">
                                        <a href="/admin/inventory/<?= $item['id'] ?>" class="text-slate-400 hover:text-brand-600" title="Görüntüle">
                                            🔍
                                        </a>
                                        <a href="/admin/inventory/<?= $item['id'] ?>/edit" class="text-slate-400 hover:text-brand-600" title="Düzenle">
                                            ✏️
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