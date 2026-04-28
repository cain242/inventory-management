<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-3xl space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-900">Yeni Ürün Ekle</h1>
        <p class="text-sm text-slate-500 mt-1">Envantere yeni bir donanım veya varlık kaydet</p>
    </div>


    <form action="/admin/inventory" method="post" class="card space-y-4">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="label">Kategori *</label>
                <select name="category_id" class="input" required>
                    <option value="">Seçiniz...</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= old('category_id') == $cat['id'] ? 'selected' : '' ?>>
                            <?= esc($cat['name']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div>
                <label class="label">Ürün Adı *</label>
                <input type="text" name="name" value="<?= esc(old('name')) ?>" class="input" required>
            </div>

            <div>
                <label class="label">Marka</label>
                <input type="text" name="brand" value="<?= esc(old('brand')) ?>" class="input">
            </div>

            <div>
                <label class="label">Seri No</label>
                <input type="text" name="serial_no" value="<?= esc(old('serial_no')) ?>" class="input">
            </div>

            <div>
                <label class="label">Alım Tarihi</label>
                <input type="date" name="purchase_date" value="<?= esc(old('purchase_date')) ?>" class="input">
            </div>

            <div>
                <label class="label">Durum *</label>
                <select name="status" class="input" required>
                    <option value="boşta" <?= old('status') === 'boşta' ? 'selected' : '' ?>>Boşta</option>
                    <option value="kullanımda" <?= old('status') === 'kullanımda' ? 'selected' : '' ?>>Kullanımda</option>
                    <option value="arızalı" <?= old('status') === 'arızalı' ? 'selected' : '' ?>>Arızalı</option>
                </select>
            </div>
        </div>

        <div>
            <label class="label">Notlar</label>
            <textarea name="notes" rows="3" class="input"><?= esc(old('notes')) ?></textarea>
        </div>

        <div class="flex justify-end gap-2 pt-2">
            <a href="/admin/inventory" class="btn-secondary">İptal</a>
            <button type="submit" class="btn-primary">Kaydet</button>
        </div>
    </form>

</div>
<?= $this->endSection() ?>
