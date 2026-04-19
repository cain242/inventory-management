<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Shield\Config\Auth as ShieldAuth;

class Auth extends ShieldAuth
{
    /**
     * Giriş denemelerini kaydet.
     */
    public int $recordLoginAttempt = self::RECORD_LOGIN_ATTEMPT_ALL;

    /**
     * View dosya yolları.
     * Login view'ı kendi Tailwind tasarımımızla değiştiriyoruz.
     */
    public array $views = [
        'login'                       => 'auth/login',
        'register'                    => '\CodeIgniter\Shield\Views\register',
        'layout'                      => '\CodeIgniter\Shield\Views\layout',
        'action_email_2fa'            => '\CodeIgniter\Shield\Views\email_2fa_show',
        'action_email_2fa_verify'     => '\CodeIgniter\Shield\Views\email_2fa_verify',
        'action_email_2fa_email'      => '\CodeIgniter\Shield\Views\Email\email_2fa_email',
        'action_email_activate_show'  => '\CodeIgniter\Shield\Views\email_activate_show',
        'action_email_activate_email' => '\CodeIgniter\Shield\Views\Email\email_activate_email',
        'magic-link-login'            => '\CodeIgniter\Shield\Views\magic_link_form',
        'magic-link-message'          => '\CodeIgniter\Shield\Views\magic_link_message',
        'magic-link-email'            => '\CodeIgniter\Shield\Views\Email\magic_link_email',
    ];

    /**
     * Yönlendirmeler.
     * Login sonrası Home::index role göre admin/staff dashboard'a yönlendirir.
     */
    public array $redirects = [
        'register'          => '/',
        'login'             => '/',
        'logout'            => 'login',
        'force_reset'       => '/',
        'permission_denied' => '/',
        'group_denied'      => '/',
    ];

    /**
     * Auth actions (e-posta doğrulama, 2FA vb.)
     * Şimdilik devre dışı.
     */
    public array $actions = [
        'register' => null,
        'login'    => null,
    ];

    /**
     * Session ayarları.
     */
    public array $sessionConfig = [
        'field'              => 'user',
        'allowRemembering'   => true,
        'rememberCookieName' => 'remember',
        'rememberLength'     => 30 * DAY,
    ];

    /**
     * Kayıt kapalı — kullanıcılar seeder ile oluşturulur.
     */
    public bool $allowRegistration = false;

    /**
     * Magic link devre dışı.
     */
    public bool $allowMagicLinkLogins = false;

    /**
     * E-posta VEYA kullanıcı adı ile giriş yapılabilir.
     */
    public array $validFields = [
        'email',
        'username',
    ];

    /**
     * Kişisel alanlar (giriş için kullanılmaz).
     */
    public array $personalFields = [];

    /**
     * Minimum şifre uzunluğu.
     */
    public int $minimumPasswordLength = 8;

    /**
     * Şifre hashleme algoritması.
     */
    public string $hashAlgorithm = PASSWORD_DEFAULT;
    public int $hashMemoryCost    = 65536;
    public int $hashTimeCost      = 4;
    public int $hashThreads       = 1;
}
