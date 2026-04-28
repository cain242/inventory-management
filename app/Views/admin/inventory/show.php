<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="/admin/inventory" class="text-slate-400 hover:text-slate-600">← Geri</a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900"><?= esc($item['name']) ?></h1>
                <p class="text-sm text-slate-500 mt-1"><?= esc($item['category_name'] ?? 'Genel') ?> | Seri No: <?= esc($item['serial_no'] ?: '—') ?></p>
            </div>
        </div>
        <a href="/admin/inventory/<?= $item['id'] ?>/edit" class="btn-secondary">Düzenle</a>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Detaylar -->
        <div class="md:col-span-1 space-y-4">
            <div class="card p-5 space-y-4">
                <h3 class="font-semibold text-slate-900 border-b pb-2">Ürün Bilgileri</h3>
                
                <div>
                    <span class="block text-xs text-slate-500">Durum</span>
                    <?php 
                        $statusClasses = [
                            'boşta'      => 'badge-success',
                            'kullanımda' => 'badge-info',
                            'arızalı'    => 'badge-danger',
                        ];
                        $class = $statusClasses[$item['status']] ?? 'badge bg-slate-100 text-slate-700';
                    ?>
                    <span class="<?= $class ?> uppercase mt-1">
                        <?= esc($item['status']) ?>
                    </span>
                </div>

                <div>
                    <span class="block text-xs text-slate-500">Marka</span>
                    <span class="text-sm font-medium"><?= esc($item['brand'] ?: '—') ?></span>
                </div>

                <div>
                    <span class="block text-xs text-slate-500">Alım Tarihi</span>
                    <span class="text-sm font-medium"><?= esc($item['purchase_date'] ?: '—') ?></span>
                </div>

                <div>
                    <span class="block text-xs text-slate-500">Kayıt Tarihi</span>
                    <span class="text-sm font-medium"><?= esc($item['created_at']) ?></span>
                </div>

                <?php if ($item['notes']): ?>
                <div>
                    <span class="block text-xs text-slate-500">Notlar</span>
                    <p class="text-sm mt-1 whitespace-pre-wrap"><?= esc($item['notes']) ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Görseller -->
        <div class="md:col-span-2 space-y-4">
            <div class="card p-5">
                <div class="flex items-center justify-between border-b pb-2 mb-4">
                    <h3 class="font-semibold text-slate-900">Görseller</h3>
                </div>

                <!-- Resim Yükleme Formu -->
                <form action="/admin/inventory/<?= $item['id'] ?>/images" method="post" enctype="multipart/form-data" class="mb-6 flex gap-3">
                    <?= csrf_field() ?>
                    <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100" required>
                    <button type="submit" class="btn-primary whitespace-nowrap">Yükle</button>
                </form>

                <!-- Resim Galerisi -->
                <?php if (empty($images)): ?>
                    <div class="text-center py-8 text-slate-400">
                        <span class="text-2xl mb-2 block">📸</span>
                        Bu ürün için henüz görsel yüklenmemiş.
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <?php foreach ($images as $img): ?>
                            <div class="relative group rounded-lg overflow-hidden border border-slate-200 aspect-square">
                                <img src="/<?= esc($img['file_path']) ?>" alt="Ürün Görseli" class="w-full h-full object-cover">
                                
                                <form action="/admin/inventory/images/<?= $img['id'] ?>/delete" method="post" class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <?= csrf_field() ?>
                                    <button type="submit" onclick="return confirm('Silmek istediğinize emin misiniz?')" class="bg-rose-600 text-white p-2 rounded-full hover:bg-rose-700" title="Sil">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

</div>
<?= $this->endSection() ?>
