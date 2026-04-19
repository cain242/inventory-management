<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="min-h-[70vh] flex items-center justify-center">
    <div class="card w-full max-w-md">
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-brand-600 text-white rounded-xl text-2xl font-bold mb-3">
                E
            </div>
            <h1 class="text-2xl font-bold text-slate-900">Envanter Sistemine Giriş</h1>
            <p class="text-sm text-slate-500 mt-1">E-posta ve şifrenizle giriş yapın</p>
        </div>

        <!-- Hata mesajları -->
        <?php if (session('error') !== null) : ?>
            <div class="alert-error"><?= esc(session('error')) ?></div>
        <?php elseif (session('errors') !== null) : ?>
            <div class="alert-error">
                <?php if (is_array(session('errors'))) : ?>
                    <?php foreach (session('errors') as $err) : ?>
                        <div><?= esc($err) ?></div>
                    <?php endforeach ?>
                <?php else : ?>
                    <?= esc(session('errors')) ?>
                <?php endif ?>
            </div>
        <?php endif ?>

        <?php if (session('message') !== null) : ?>
            <div class="alert-success"><?= esc(session('message')) ?></div>
        <?php endif ?>

        <form action="<?= site_url('/login') ?>" method="post" class="space-y-4">
            <?= csrf_field() ?>

            <div>
                <label for="email" class="label">E-posta veya Kullanıcı Adı</label>
                <input type="text" name="email" id="email"
                       value="<?= old('email') ?>" required autofocus
                       class="input"
                       placeholder="ornek@envanter.local">
            </div>

            <div>
                <label for="password" class="label">Şifre</label>
                <input type="password" name="password" id="password" required
                       class="input"
                       placeholder="••••••••">
            </div>

            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" value="1"
                       class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                Beni hatırla
            </label>

            <button type="submit" class="btn-primary w-full">
                Giriş Yap
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-slate-200">
            <p class="text-xs text-slate-500 text-center">
                Test hesapları:
                <br>
                <code class="text-slate-700">admin@envanter.local</code> / <code class="text-slate-700">Admin123!</code>
                <br>
                <code class="text-slate-700">personel1@envanter.local</code> / <code class="text-slate-700">Staff123!</code>
            </p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
