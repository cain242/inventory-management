<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Kategoriler</h1>
            <p class="text-sm text-slate-500 mt-1">Envanter kategorilerini yönet</p>
        </div>
        <a href="/admin/categories/create" class="btn-primary">+ Yeni Kategori</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="card bg-emerald-50 border-emerald-200">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="card bg-rose-50 border-rose-200">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif ?>

    <div class="card p-0 overflow-hidden">
        <table class="w-full text-left">
            <thead class="sticky top-0 z-10 bg-slate-50 text-xs uppercase text-slate-500 border-b border-slate-200">
                <tr>
                    <th class="px-4 py-3">Ad</th>
                    <th class="px-4 py-3">Açıklama</th>
                    <th class="px-4 py-3">Oluşturulma</th>
                    <th class="px-4 py-3 text-right">İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-slate-400">
                            Henüz kategori eklenmemiş.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categories as $cat): ?>
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3 font-medium"><?= esc($cat['name']) ?></td>
                            <td class="px-4 py-3 text-slate-600"><?= esc($cat['description'] ?? '') ?></td>
                            <td class="px-4 py-3 text-slate-500 text-sm"><?= esc($cat['created_at']) ?></td>
                            <td class="px-4 py-3 text-right">
                                <a href="/admin/categories/<?= $cat['id'] ?>/edit" class="text-brand-600 hover:underline">Düzenle</a>
                                <form action="/admin/categories/<?= $cat['id'] ?>/delete" method="post" class="inline" onsubmit="return confirm('Bu kategoriyi silmek istediğinize emin misiniz?');">
                                    <?= csrf_field() ?>
                                        <button type="submit" class="text-rose-600 hover:underline bg-transparent border-none p-0 cursor-pointer">Sil</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>

</div>
<?= $this->endSection() ?>