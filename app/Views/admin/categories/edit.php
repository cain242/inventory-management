<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Kategori Düzenle: <?= esc($category['name']) ?></h1>
    </div>

    <form action="/admin/categories/<?= $category['id'] ?>" method="post" class="card space-y-4">
        <?= csrf_field() ?>
        <div>
            <label class="label">Ad (2-255 karakter) *</label>
            <input type="text" name="name" value="<?= esc(old('name', $category['name'])) ?>"
                   class="input" required>
        </div>

        <div>
            <label class="label">Açıklama (En fazla 500 karakter)</label>
            <textarea name="description" rows="3"
                      class="input"><?= esc(old('description', $category['description'])) ?></textarea>
        </div>
        
        <div class="flex justify-end gap-2 pt-2">
            <a href="/admin/categories" class="btn-secondary">İptal</a>
            <button type="submit" class="btn-primary">Kaydet</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>