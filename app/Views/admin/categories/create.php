<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-900">Yeni Kategori</h1>
        <p class="text-sm text-slate-500 mt-1">Örn: Donanım, Yazılım, Sarf Malzeme</p>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="card bg-rose-50 border-rose-200">
            <ul class="list-disc list-inside text-sm">
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form action="/admin/categories" method="post" class="card space-y-4">
        <?= csrf_field() ?>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Ad (2-255 karakter) *</label>
            <input type="text" name="name" value="<?= esc(old('name')) ?>"
                   class="w-full border-slate-300 rounded-md" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Açıklama (En fazla 500 karakter)</label>
            <textarea name="description" rows="3"
                      class="w-full border-slate-300 rounded-md"><?= esc(old('description')) ?></textarea>
        </div>

        <div class="flex justify-end gap-2 pt-2">
            <a href="/admin/categories" class="btn-ghost">İptal</a>
            <button type="submit" class="btn-primary">Kaydet</button>
        </div>
    </form>

</div>
<?= $this->endSection() ?>