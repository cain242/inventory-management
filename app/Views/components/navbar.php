<?php
// Session köprüsü sayesinde hem auth() hem session() kullanılabilir
$isLoggedIn = auth()->loggedIn();
$user       = auth()->user();
$isAdmin    = $user && $user->inGroup('admin');
$isStaff    = $user && $user->inGroup('staff');
$username   = $user ? $user->username : '';
?>
<nav class="bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Logo + Başlık -->
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-brand-600 rounded-lg flex items-center justify-center text-white font-bold">
                    E
                </div>
                <a href="/" class="text-slate-900 font-semibold text-lg hidden sm:block">
                    Envanter Yönetim
                </a>
            </div>

            <?php if ($isLoggedIn) : ?>
                <!-- Menü (sadece giriş yapmış kullanıcılar) -->
                <div class="hidden md:flex items-center gap-1">
                    <?php if ($isAdmin) : ?>
                        <a href="/admin/dashboard" class="px-3 py-2 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-100">Dashboard</a>
                        <a href="/admin/inventory" class="px-3 py-2 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-100">Envanter</a>
                        <a href="/admin/categories" class="px-3 py-2 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-100">Kategoriler</a>
                        <span class="px-3 py-2 rounded-md text-sm font-medium text-slate-400 cursor-not-allowed" title="Hafta 4'te aktif olacak">Talepler</span>
                        <span class="px-3 py-2 rounded-md text-sm font-medium text-slate-400 cursor-not-allowed" title="Hafta 4'te aktif olacak">Zimmetler</span>
                    <?php elseif ($isStaff) : ?>
                        <a href="/staff/dashboard" class="px-3 py-2 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-100">Dashboard</a>
                        <span class="px-3 py-2 rounded-md text-sm font-medium text-slate-400 cursor-not-allowed" title="Hafta 3'te aktif olacak">Taleplerim</span>
                        <span class="px-3 py-2 rounded-md text-sm font-medium text-slate-400 cursor-not-allowed" title="Hafta 3'te aktif olacak">Yeni Talep</span>
                    <?php endif ?>
                </div>

                <!-- Kullanıcı menüsü -->
                <div class="flex items-center gap-3">
                    <span class="hidden sm:block text-sm text-slate-600">
                        <?= esc($username) ?>
                        <?php if ($isAdmin) : ?>
                            <span class="badge-info ml-1">admin</span>
                        <?php else : ?>
                            <span class="badge bg-slate-100 text-slate-700 ml-1">personel</span>
                        <?php endif ?>
                    </span>
                    <a href="<?= site_url('/logout') ?>"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="text-sm text-slate-600 hover:text-red-600">
                        Çıkış
                    </a>
                    <form id="logout-form" action="<?= site_url('/logout') ?>" method="post" class="hidden">
                        <?= csrf_field() ?>
                    </form>
                </div>
            <?php else : ?>
                <a href="<?= site_url('/login') ?>" class="btn-primary text-sm">Giriş Yap</a>
            <?php endif ?>

        </div>
    </div>
</nav>
