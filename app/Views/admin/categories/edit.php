<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<form action="/categories/<?= $category['id'] ?>" method="post">

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Ad (2-255 karakter) *</label>
            <input type="text" name="name" value="<?= esc(old('name')) ?>"
                   class="w-full border-slate-300 rounded-md" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Açıklama (En fazla 500 karakter)</label>
            <textarea name="description" rows="3"
                      class="w-full border-slate-300 rounded-md"><?= esc(old('description')) ?></textarea>
            <div class="flex justify-end gap-2 pt-2">
            <a href="/admin/categories" class="btn-ghost">İptal</a>
            <button type="submit" class="btn-primary">Kaydet</button>
        </div>
        </div>

</form>
<?= $this->endSection() ?>