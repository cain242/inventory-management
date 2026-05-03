<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Personel Paneli</h1>
            <p class="text-sm text-slate-500 mt-1">
                Hoş geldin, <?= esc($currentUser->username) ?>!
            </p>
        </div>
    </div>

    <div class="card">
        <h2 class="text-lg font-semibold text-slate-900 mb-3">Talep oluşturma</h2>
        <p class="text-slate-600 text-sm mb-4">
            Arızalı bir ekipman mı var? Yeni bir ekipmana mı ihtiyacın var?
        </p>
        <a href="<?= base_url('staff/requests/create') ?>" class="btn-primary">
            Yeni Talep Oluştur
        </a>
    </div>

    <div class="card">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold text-slate-900">Son Taleplerim</h2>
            <a href="<?= base_url('staff/requests') ?>" class="text-sm text-indigo-600 hover:text-indigo-900">Tümünü Gör</a>
        </div>
        <p class="text-slate-600 text-sm mb-4">
            Gönderdiğin son 5 talep ve durumları burada listelenmektedir.
        </p>
        
        <?php if (empty($recentRequests)): ?>
            <div class="mt-4 py-8 text-center text-slate-400 text-sm border-2 border-dashed border-slate-200 rounded-lg">
                Henüz hiçbir talep oluşturmadınız.
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="py-3 pl-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tür</th>
                            <th scope="col" class="py-3 px-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Durum</th>
                            <th scope="col" class="py-3 px-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tarih</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        <?php foreach ($recentRequests as $req): ?>
                        <tr>
                            <td class="py-3 pl-4 text-sm text-slate-500">
                                <?php if ($req['type'] === 'repair'): ?>
                                    <span class="inline-flex items-center rounded-md bg-orange-50 px-2 py-1 text-xs font-medium text-orange-700 ring-1 ring-inset ring-orange-600/20">Arıza Bildirimi</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Yeni Ekipman</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-3 text-sm text-slate-500">
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
                            <td class="py-3 px-3 text-sm text-slate-500">
                                <?= date('d.m.Y', strtotime($req['created_at'])) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</div>
<?= $this->endSection() ?>
