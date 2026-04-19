<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Shield\Config\AuthToken as ShieldAuthToken;

/**
 * Hafta 5'te API endpoint'leri için token tabanlı kimlik doğrulama
 * gerekirse burada yapılandırılır.
 */
class AuthToken extends ShieldAuthToken
{
    /**
     * Authenticator header ayarları.
     */
    public array $authenticatorHeader = [
        'tokens' => [
            'headerName'  => 'Authorization',
            'tokenPrefix' => 'Bearer',
        ],
    ];

    /**
     * Kullanılmayan token'ların ömrü (0 = sınırsız).
     */
    public int $unusedTokenLifetime = 0;
}
