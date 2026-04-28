<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-3xl space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-900">Ürünü Düzenle: <?= esc($item['name']) ?></h1>
    </div>


    <form action="/admin/inventory/<?= $item['id'] ?>" method="post" class="card space-y-4">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="label">Kategori *</label>
                <select name="category_id" class="input" required>
                    <option value="">Seçiniz...</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= old('category_id', $item['category_id']) == $cat['id'] ? 'selected' : '' ?>>
                            <?= esc($cat['name']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div>
                <label class="label">Ürün Adı *</label>
                <input type="text" name="name" value="<?= esc(old('name', $item['name'])) ?>" class="input" required>
            </div>

            <div>
                <label class="label">Marka</label>
                <input type="text" name="brand" value="<?= esc(old('brand', $item['brand'])) ?>" class="input">
            </div>

            <div>
                <label class="label">Seri No</label>
                <input type="text" name="serial_no" value="<?= esc(old('serial_no', $item['serial_no'])) ?>" class="input">
            </div>

            <div>
                <label class="label">Alım Tarihi</label>
                <input type="date" name="purchase_date" value="<?= esc(old('purchase_date', $item['purchase_date'])) ?>" class="input">
            </div>

            <div>
                <label class="label">Durum *</label>
                <select name="status" class="input" required>
                    <option value="boşta" <?= old('status', $item['status']) === 'boşta' ? 'selected' : '' ?>>Boşta</option>
                    <option value="kullanımda" <?= old('status', $item['status']) === 'kullanımda' ? 'selected' : '' ?>>Kullanımda</option>
                    <option value="arızalı" <?= old('status', $item['status']) === 'arızalı' ? 'selected' : '' ?>>Arızalı</option>
                </select>
            </div>
        </div>

        <div>
            <label class="label">Notlar</label>
            <textarea name="notes" rows="3" class="input"><?= esc(old('notes', $item['notes'])) ?></textarea>
        </div>

        <div class="flex justify-between items-center pt-2">
            <div>
                <button type="button" onclick="if(confirm('Bu ürünü silmek istediğinize emin misiniz?')) document.getElementById('delete-form').submit();" class="text-rose-600 text-sm hover:underline">Ürünü Sil</button>
            </div>
            <div class="flex gap-2">
                <a href="/admin/inventory" class="btn-secondary">İptal</a>
                <button type="submit" class="btn-primary">Güncelle</button>
            </div>
        </div>
    </form>

    <form id="delete-form" action="/admin/inventory/<?= $item['id'] ?>/delete" method="post" class="hidden">
        <?= csrf_field() ?>
    </form>

</div>
<?= $this->endSection() ?>
