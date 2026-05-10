<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Talep Onay Paneli</h1>
            <p class="text-sm text-slate-500 mt-1">Personelden gelen talepleri incele, onayla veya reddet</p>
        </div>
        <span class="badge-info">Hafta 4 — Onay Mekanizması</span>
    </div>

    <div class="card p-0 overflow-hidden border border-slate-200 rounded-lg shadow-sm">
        <div class="overflow-y-auto max-h-[calc(100vh-250px)]">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 z-10 bg-slate-50 text-xs uppercase text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold">#</th>
                        <th class="px-4 py-3 font-semibold">Personel</th>
                        <th class="px-4 py-3 font-semibold">Cihaz</th>
                        <th class="px-4 py-3 font-semibold">Tür</th>
                        <th class="px-4 py-3 font-semibold">Açıklama</th>
                        <th class="px-4 py-3 font-semibold">Durum</th>
                        <th class="px-4 py-3 font-semibold">Tarih</th>
                        <th class="px-4 py-3 font-semibold text-right">İşlem</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    <?php if (empty($requests)): ?>
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl mb-2">📋</span>
                                    <p>Henüz talep bulunamadı.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($requests as $req): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 text-sm font-mono text-slate-500"><?= $req['id'] ?></td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-slate-900"><?= esc($req['staff_name'] ?? 'Bilinmiyor') ?></div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-slate-900"><?= esc($req['inventory_name'] ?? '—') ?></div>
                                    <div class="text-xs text-slate-400"><?= esc($req['serial_no'] ?? '') ?></div>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if ($req['type'] === 'new'): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            Yeni Ekipman
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                            Arıza Bildirimi
                                        </span>
                                    <?php endif ?>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-600 max-w-[200px] truncate">
                                    <?= esc($req['description'] ?: '—') ?>
                                </td>
                                <td class="px-4 py-3">
                                    <?php
                                        $statusConfig = [
                                            'pending'   => ['class' => 'bg-amber-100 text-amber-800', 'label' => 'Bekliyor'],
                                            'approved'  => ['class' => 'bg-green-100 text-green-800', 'label' => 'Onaylandı'],
                                            'rejected'  => ['class' => 'bg-red-100 text-red-800',     'label' => 'Reddedildi'],
                                            'cancelled' => ['class' => 'bg-slate-100 text-slate-600', 'label' => 'İptal'],
                                        ];
                                        $sc = $statusConfig[$req['status']] ?? ['class' => 'bg-slate-100 text-slate-700', 'label' => $req['status']];
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold <?= $sc['class'] ?>">
                                        <?= $sc['label'] ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-500">
                                    <?= date('d.m.Y H:i', strtotime($req['created_at'])) ?>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <?php if ($req['status'] === 'pending'): ?>
                                        <div class="flex justify-end gap-2">
                                            <button type="button"
                                                    onclick="approveRequest(<?= $req['id'] ?>)"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium bg-green-600 text-white hover:bg-green-700 transition-colors shadow-sm">
                                                ✓ Onayla
                                            </button>
                                            <button type="button"
                                                    onclick="openRejectModal(<?= $req['id'] ?>)"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium bg-red-600 text-white hover:bg-red-700 transition-colors shadow-sm">
                                                ✕ Reddet
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <?php if ($req['status'] === 'rejected' && !empty($req['admin_note'])): ?>
                                            <span class="text-xs text-slate-400 italic" title="<?= esc($req['admin_note']) ?>">
                                                📝 Not var
                                            </span>
                                        <?php else: ?>
                                            <span class="text-xs text-slate-400">—</span>
                                        <?php endif ?>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Onayla formu (gizli) -->
<form id="approve-form" method="post" style="display:none;">
    <?= csrf_field() ?>
</form>

<!-- Reddet formu (gizli) -->
<form id="reject-form" method="post" style="display:none;">
    <?= csrf_field() ?>
    <input type="hidden" name="admin_note" id="reject-note-input">
</form>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    /**
     * Onayla butonuna basınca SweetAlert2 confirm kutusu gösterir.
     */
    function approveRequest(id) {
        Swal.fire({
            title: 'Talebi Onayla',
            text: 'Bu talebi onaylamak istediğinize emin misiniz? Cihaz otomatik olarak zimmetlenecektir.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Evet, Onayla',
            cancelButtonText: 'Vazgeç',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('approve-form');
                form.action = '/admin/requests/' + id + '/approve';
                form.submit();
            }
        });
    }

    /**
     * Reddet butonuna basınca önce açıklama modal'ı açar, sonra confirm sorar.
     */
    function openRejectModal(id) {
        Swal.fire({
            title: 'Talebi Reddet',
            html: '<textarea id="swal-reject-note" class="swal2-textarea" placeholder="Red sebebini yazınız..." style="width:100%;min-height:100px;border:1px solid #e2e8f0;border-radius:8px;padding:12px;font-size:14px;resize:vertical;"></textarea>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Reddet',
            cancelButtonText: 'Vazgeç',
            reverseButtons: true,
            focusConfirm: false,
            preConfirm: () => {
                const note = document.getElementById('swal-reject-note').value;
                if (!note.trim()) {
                    Swal.showValidationMessage('Lütfen red sebebi yazınız.');
                    return false;
                }
                return note;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Emin misiniz?',
                    text: 'Bu talebi reddetmek istediğinize emin misiniz?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Evet, Reddet',
                    cancelButtonText: 'Vazgeç',
                    reverseButtons: true
                }).then((confirmResult) => {
                    if (confirmResult.isConfirmed) {
                        document.getElementById('reject-note-input').value = result.value;
                        const form = document.getElementById('reject-form');
                        form.action = '/admin/requests/' + id + '/reject';
                        form.submit();
                    }
                });
            }
        });
    }

    // Flash mesajları varsa SweetAlert2 ile göster
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({
                title: 'Başarılı!',
                text: '<?= esc(session()->getFlashdata('success')) ?>',
                icon: 'success',
                confirmButtonColor: '#2563eb',
                timer: 3000,
                timerProgressBar: true
            });
        <?php endif ?>

        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                title: 'Hata!',
                text: '<?= esc(session()->getFlashdata('error')) ?>',
                icon: 'error',
                confirmButtonColor: '#dc2626'
            });
        <?php endif ?>
    });
</script>
<?= $this->endSection() ?>
