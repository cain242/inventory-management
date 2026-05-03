<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto">
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Talep Oluştur</h1>
        <p class="mt-2 text-sm text-slate-600">
            Arıza bildiriminde bulunabilir veya yeni bir donanım/yazılım talebi yapabilirsiniz.
        </p>
    </div>

    <form action="<?= base_url('staff/requests') ?>" method="POST">
        <?= csrf_field() ?>
        
        <div class="shadow sm:overflow-hidden sm:rounded-md">
            <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                
                <?php if (session('validation')): ?>
                    <div class="rounded-md bg-red-50 p-4 mb-4">
                        <div class="flex">
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Lütfen aşağıdaki hataları düzeltin:</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc space-y-1 pl-5">
                                        <?php foreach (session('validation') as $error): ?>
                                            <li><?= esc($error) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Talep Türü -->
                <fieldset>
                    <legend class="text-sm font-semibold text-slate-900">Talep Türü <span class="text-red-500">*</span></legend>
                    <div class="mt-4 space-y-4">
                        <div class="flex items-center">
                            <input id="type_repair" name="type" type="radio" value="repair" <?= old('type') === 'repair' ? 'checked' : '' ?> class="h-4 w-4 border-slate-300 text-indigo-600 focus:ring-indigo-600">
                            <label for="type_repair" class="ml-3 block text-sm font-medium text-slate-700">Arıza Bildirimi</label>
                        </div>
                        <div class="flex items-center">
                            <input id="type_new" name="type" type="radio" value="new" <?= old('type') === 'new' ? 'checked' : '' ?> class="h-4 w-4 border-slate-300 text-indigo-600 focus:ring-indigo-600">
                            <label for="type_new" class="ml-3 block text-sm font-medium text-slate-700">Yeni Ekipman Talebi</label>
                        </div>
                    </div>
                </fieldset>

                <!-- Kategori Seçimi -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-slate-700">Kategori <span class="text-red-500">*</span></label>
                    <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border border-slate-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        <option value="">Kategori seçiniz...</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= esc($cat['id']) ?>" <?= old('category_id') == $cat['id'] ? 'selected' : '' ?>>
                                <?= esc($cat['name']) ?> (<?= $cat['item_count'] ?> ürün)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Ürün Seçimi (Kategoriye bağlı) -->
                <div>
                    <label for="inventory_id" class="block text-sm font-medium text-slate-700">Ürün <span class="text-red-500">*</span></label>
                    <select id="inventory_id" name="inventory_id" disabled class="mt-1 block w-full rounded-md border border-slate-300 bg-slate-50 py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        <option value="">Önce bir kategori seçiniz...</option>
                    </select>
                    <p id="inventory_hint" class="mt-2 text-sm text-slate-500">Kategori seçtikten sonra ürünler listelenecektir.</p>
                </div>

                <!-- Açıklama -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700">Açıklama <span class="text-xs text-slate-400">(Opsiyonel, maks. 500 karakter)</span></label>
                    <div class="mt-1 relative">
                        <textarea id="description" name="description" rows="4" maxlength="500" class="mt-1 block w-full rounded-md border border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" placeholder="Sorunu veya talebinizi detaylı bir şekilde açıklayın..."><?= old('description') ?></textarea>
                        <div class="absolute bottom-2 right-2 text-xs text-slate-400">
                            <span id="char-count">0</span>/500
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-slate-50 px-4 py-3 text-right sm:px-6">
                <a href="<?= base_url('staff/requests') ?>" class="inline-flex justify-center rounded-md border border-slate-300 bg-white py-2 px-4 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mr-3">
                    İptal
                </a>
                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Kaydet
                </button>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category_id');
    const inventorySelect = document.getElementById('inventory_id');
    const inventoryHint = document.getElementById('inventory_hint');
    const descriptionField = document.getElementById('description');
    const charCount = document.getElementById('char-count');

    // Karakter sayacı
    function updateCharCount() {
        charCount.textContent = descriptionField.value.length;
    }
    descriptionField.addEventListener('input', updateCharCount);
    updateCharCount();

    // Kategori değiştiğinde ürünleri AJAX ile çek
    categorySelect.addEventListener('change', function() {
        const categoryId = this.value;
        
        // Ürün select'ini sıfırla
        inventorySelect.innerHTML = '<option value="">Yükleniyor...</option>';
        inventorySelect.disabled = true;
        inventorySelect.classList.add('bg-slate-50');
        inventorySelect.classList.remove('bg-white');

        if (!categoryId) {
            inventorySelect.innerHTML = '<option value="">Önce bir kategori seçiniz...</option>';
            inventoryHint.textContent = 'Kategori seçtikten sonra ürünler listelenecektir.';
            return;
        }

        fetch('<?= base_url('staff/requests/inventory-by-category') ?>/' + categoryId)
            .then(function(response) { return response.json(); })
            .then(function(items) {
                inventorySelect.innerHTML = '';
                
                if (items.length === 0) {
                    inventorySelect.innerHTML = '<option value="">Bu kategoride ürün bulunamadı</option>';
                    inventoryHint.textContent = 'Bu kategoride henüz envanter kaydı yok.';
                } else {
                    inventorySelect.innerHTML = '<option value="">Ürün seçiniz...</option>';
                    items.forEach(function(item) {
                        var option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.name + ' (' + (item.serial_no || 'Seri No Yok') + ') - Durum: ' + item.status;
                        inventorySelect.appendChild(option);
                    });
                    inventorySelect.disabled = false;
                    inventorySelect.classList.remove('bg-slate-50');
                    inventorySelect.classList.add('bg-white');
                    inventoryHint.textContent = items.length + ' ürün listelendi.';
                }

                // Eğer old value varsa seç
                var oldVal = '<?= old('inventory_id') ?>';
                if (oldVal) {
                    inventorySelect.value = oldVal;
                }
            })
            .catch(function() {
                inventorySelect.innerHTML = '<option value="">Ürünler yüklenemedi</option>';
                inventoryHint.textContent = 'Bir hata oluştu, lütfen tekrar deneyin.';
            });
    });

    // Sayfa yüklendiğinde eski kategori seçili ise ürünleri çek
    if (categorySelect.value) {
        categorySelect.dispatchEvent(new Event('change'));
    }
});
</script>
<?= $this->endSection() ?>
