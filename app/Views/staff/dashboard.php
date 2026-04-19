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
        <span class="badge bg-slate-100 text-slate-700">Hafta 1</span>
    </div>

    <div class="card">
        <h2 class="text-lg font-semibold text-slate-900 mb-3">Talep oluşturma</h2>
        <p class="text-slate-600 text-sm mb-4">
            Arızalı bir ekipman mı var? Yeni bir ekipmana mı ihtiyacın var?
            Talep formu Hafta 3'te aktif olacak.
        </p>
        <button disabled class="btn-secondary opacity-60 cursor-not-allowed">
            Yeni Talep Oluştur
        </button>
        <p class="text-xs text-slate-400 mt-2">Bu buton Hafta 3'te etkinleşecek</p>
    </div>

    <div class="card">
        <h2 class="text-lg font-semibold text-slate-900 mb-3">Taleplerim</h2>
        <p class="text-slate-600 text-sm">
            Gönderdiğin talepler ve durumları burada listelenecek.
        </p>
        <div class="mt-4 py-8 text-center text-slate-400 text-sm border-2 border-dashed border-slate-200 rounded-lg">
            Henüz talep oluşturma modülü aktif değil (Hafta 3)
        </div>
    </div>

</div>
<?= $this->endSection() ?>
