<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-900">Yeni Kategori</h1>
        <p class="text-sm text-slate-500 mt-1">Örn: Donanım, Yazılım, Sarf Malzeme</p>
    </div>


    <form action="/admin/categories" method="post" class="card space-y-4">
        <?= csrf_field() ?>

        <div>
            <label class="label">Ad (2-255 karakter) *</label>
            <input type="text" name="name" value="<?= esc(old('name')) ?>"
                   class="input" required>
        </div>

        <div>
            <label class="label">Açıklama (En fazla 500 karakter)</label>
            <textarea name="description" rows="3"
                      class="input"><?= esc(old('description')) ?></textarea>
        </div>

        <div class="flex justify-end gap-2 pt-2">
            <a href="/admin/categories" class="btn-secondary">İptal</a>
            <button type="submit" class="btn-primary">Kaydet</button>
        </div>
    </form>

</div>
<?= $this->endSection() ?>