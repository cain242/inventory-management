<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Talep Detayı</h1>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="<?= base_url('staff/requests') ?>" class="inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Listeye Dön
            </a>
        </div>
    </div>
</div>

<div class="overflow-hidden bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg font-medium leading-6 text-slate-900">Talep Bilgileri</h3>
    </div>
    <div class="border-t border-slate-200 px-4 py-5 sm:p-0">
        <dl class="sm:divide-y sm:divide-slate-200">
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                <dt class="text-sm font-medium text-slate-500">Talep Türü</dt>
                <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">
                    <?php if ($request['type'] === 'repair'): ?>
                        <span class="inline-flex items-center rounded-md bg-orange-50 px-2 py-1 text-xs font-medium text-orange-700 ring-1 ring-inset ring-orange-600/20">Arıza Bildirimi</span>
                    <?php else: ?>
                        <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Yeni Ekipman</span>
                    <?php endif; ?>
                </dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                <dt class="text-sm font-medium text-slate-500">Durum</dt>
                <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">
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
                    $color = $statusColors[$request['status']] ?? 'bg-slate-50 text-slate-600 ring-slate-500/10';
                    $label = $statusLabels[$request['status']] ?? $request['status'];
                    ?>
                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset <?= $color ?>">
                        <?= esc($label) ?>
                    </span>
                </dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                <dt class="text-sm font-medium text-slate-500">İlgili Envanter</dt>
                <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">
                    <?= $request['inventory_name'] ? esc($request['inventory_name']) . ' (' . esc($request['serial_no']) . ')' : '-' ?>
                </dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                <dt class="text-sm font-medium text-slate-500">Oluşturulma Tarihi</dt>
                <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">
                    <?= date('d.m.Y H:i', strtotime($request['created_at'])) ?>
                </dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                <dt class="text-sm font-medium text-slate-500">Açıklama</dt>
                <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0 whitespace-pre-wrap"><?= esc($request['description']) ?></dd>
            </div>
            <?php if ($request['admin_note']): ?>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6 <?= $request['status'] === 'rejected' ? 'bg-red-50' : 'bg-slate-50' ?>">
                <dt class="text-sm font-medium <?= $request['status'] === 'rejected' ? 'text-red-800' : 'text-slate-800' ?>">Yönetici Notu</dt>
                <dd class="mt-1 text-sm <?= $request['status'] === 'rejected' ? 'text-red-900' : 'text-slate-900' ?> sm:col-span-2 sm:mt-0 whitespace-pre-wrap"><?= esc($request['admin_note']) ?></dd>
            </div>
            <?php endif; ?>
        </dl>
    </div>
</div>

<?php if ($request['status'] === 'pending'): ?>
<div class="mt-8 flex justify-end">
    <form action="<?= base_url('staff/requests/' . $request['uuid'] . '/cancel') ?>" method="post">
        <?= csrf_field() ?>
        <button type="button" id="cancel-btn" onclick="this.style.display='none'; document.getElementById('cancel-confirm').style.display='flex';" class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
            Talebi İptal Et
        </button>
        <div id="cancel-confirm" style="display:none;" class="items-center gap-3">
            <span class="text-sm text-slate-600">Bu talebi iptal etmek istediğinize emin misiniz?</span>
            <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
                Evet, İptal Et
            </button>
            <button type="button" onclick="document.getElementById('cancel-confirm').style.display='none'; document.getElementById('cancel-btn').style.display='inline-flex';" class="inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50">
                Vazgeç
            </button>
        </div>
    </form>
</div>
<?php endif; ?>
<?= $this->endSection() ?>
