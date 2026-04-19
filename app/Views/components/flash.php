<?php
$success = session()->getFlashdata('success');
$error   = session()->getFlashdata('error');
$errors  = session()->getFlashdata('errors');
?>

<?php if ($success) : ?>
    <div class="alert-success" data-auto-dismiss>
        <?= esc($success) ?>
    </div>
<?php endif ?>

<?php if ($error) : ?>
    <div class="alert-error" data-auto-dismiss>
        <?= esc($error) ?>
    </div>
<?php endif ?>

<?php if (is_array($errors) && ! empty($errors)) : ?>
    <div class="alert-error">
        <ul class="list-disc list-inside space-y-1">
            <?php foreach ($errors as $err) : ?>
                <li><?= esc($err) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>
