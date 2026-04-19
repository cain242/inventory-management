<?php

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

class Autoload extends AutoloadConfig
{
    public $psr4 = [
        APP_NAMESPACE => APPPATH,
    ];

    public $classmap = [];

    public $files = [];

    /**
     * Tüm sayfalarda otomatik yüklenen helper'lar.
     * - auth, setting: Shield tarafından gerekli
     * - form, url:     CI4 genel kullanım
     * - vite:          bizim özel helper (resources/ -> public/build/)
     */
    public $helpers = [
        'auth',
        'setting',
        'form',
        'url',
        'vite',
    ];
}
