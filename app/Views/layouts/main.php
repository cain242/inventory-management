<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title><?= esc($title ?? 'Envanter Yönetim Sistemi') ?></title>
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <?= vite(['resources/css/app.css', 'resources/js/app.js']) ?>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen flex flex-col">

    <?= view('components/navbar') ?>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?= view('components/flash') ?>
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 py-4 text-center text-sm text-slate-500">
            Envanter Yönetim Sistemi &middot; CodeIgniter 4.7 &middot; Shield &middot; Tailwind v4
        </div>
    </footer>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
