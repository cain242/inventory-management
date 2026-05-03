<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Taleplerim</h1>
        <p class="mt-1 text-sm text-slate-500">Açtığınız donanım ve arıza taleplerini buradan takip edebilirsiniz.</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="<?= base_url('staff/requests/create') ?>" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            Yeni Talep Oluştur
        </a>
    </div>
</div>

<div class="bg-white shadow-sm ring-1 ring-slate-200 sm:rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6">Tür</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">İlgili Envanter</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Durum</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Tarih</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">İşlemler</span>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            <?php if (empty($requests)): ?>
            <tr>
                <td colspan="5" class="py-8 text-center text-sm text-slate-500">Henüz hiç talep oluşturmamışsınız.</td>
            </tr>
            <?php else: ?>
                <?php foreach ($requests as $req): ?>
                <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-slate-500 sm:pl-6">
                        <?php if ($req['type'] === 'repair'): ?>
                            <span class="inline-flex items-center rounded-md bg-orange-50 px-2 py-1 text-xs font-medium text-orange-700 ring-1 ring-inset ring-orange-600/20">Arıza Bildirimi</span>
                        <?php else: ?>
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Yeni Ekipman</span>
                        <?php endif; ?>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                        <?= $req['inventory_name'] ? esc($req['inventory_name']) . ' (' . esc($req['serial_no']) . ')' : '-' ?>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                        <?php 
                        $statusColors = [
                            'pending'   => 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
                            'approved'  => 'bg-green-50 text-green-700 ring-green-600/20',
                            'rejected'  => 'bg-red-50 text-red-700 ring-red-600/10',
                            'cancelled' => 'bg-slate-50 text-slate-600 ring-slate-500/10',
                        ];
                        $statusLabels = [
                            'pending'   => 'Bekliyor',
                            'approved'  => 'Onaylandı',
                            'rejected'  => 'Reddedildi',
                            'cancelled' => 'İptal Edildi',
                        ];
                        $color = $statusColors[$req['status']] ?? 'bg-slate-50 text-slate-600 ring-slate-500/10';
                        $label = $statusLabels[$req['status']] ?? $req['status'];
                        ?>
                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset <?= $color ?>">
                            <?= esc($label) ?>
                        </span>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                        <?= date('d.m.Y H:i', strtotime($req['created_at'])) ?>
                    </td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                        <a href="<?= base_url('staff/requests/' . $req['uuid']) ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Detay</a>
                        <?php if ($req['status'] === 'pending'): ?>
                            <button type="button" onclick="openCancelModal('<?= esc($req['uuid']) ?>', '<?= $req['type'] === 'repair' ? 'Arıza Bildirimi' : 'Yeni Ekipman' ?>', '<?= $req['inventory_name'] ? esc($req['inventory_name']) : '-' ?>', '<?= date('d.m.Y H:i', strtotime($req['created_at'])) ?>')" class="text-red-600 hover:text-red-900">İptal Et</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- İptal Onay Modal -->
<div id="cancelModal" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center">
    <!-- Yarı saydam karartma katmanı -->
    <div id="cancelModalOverlay" onclick="closeCancelModal()" class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
    
    <!-- Modal kutusu -->
    <div class="relative bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 overflow-hidden transform transition-all">
        <!-- Üst kısım - Uyarı ikonu -->
        <div class="bg-red-50 px-6 py-5 flex items-center gap-4 border-b border-red-100">
            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-red-800">Talep İptali</h3>
                <p class="text-sm text-red-600 mt-0.5">Bu talebi iptal etmek istediğinizden emin misiniz?</p>
            </div>
        </div>

        <!-- Talep bilgileri -->
        <div class="px-6 py-5 space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm font-medium text-slate-500">Talep Türü</span>
                <span id="modalType" class="text-sm font-semibold text-slate-800"></span>
            </div>
            <div class="border-t border-slate-100"></div>
            <div class="flex justify-between items-center">
                <span class="text-sm font-medium text-slate-500">İlgili Envanter</span>
                <span id="modalInventory" class="text-sm font-semibold text-slate-800"></span>
            </div>
            <div class="border-t border-slate-100"></div>
            <div class="flex justify-between items-center">
                <span class="text-sm font-medium text-slate-500">Oluşturulma Tarihi</span>
                <span id="modalDate" class="text-sm font-semibold text-slate-800"></span>
            </div>
        </div>

        <!-- Butonlar -->
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end gap-3">
            <button type="button" onclick="closeCancelModal()" class="inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                Vazgeç
            </button>
            <form id="cancelForm" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                    Evet, İptal Et
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openCancelModal(id, type, inventory, date) {
    document.getElementById('modalType').textContent = type;
    document.getElementById('modalInventory').textContent = inventory;
    document.getElementById('modalDate').textContent = date;
    document.getElementById('cancelForm').action = '<?= base_url('staff/requests/') ?>' + id + '/cancel';
    document.getElementById('cancelModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeCancelModal() {
    document.getElementById('cancelModal').style.display = 'none';
    document.body.style.overflow = '';
}

// ESC tuşu ile kapatma
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeCancelModal();
});
</script>
<?= $this->endSection() ?>
