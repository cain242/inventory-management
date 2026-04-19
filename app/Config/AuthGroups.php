<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    /**
     * Kullanıcı grupları (roller).
     */
    public array $groups = [
        'superadmin' => [
            'title'       => 'Süper Yönetici',
            'description' => 'Sistemin tamamına erişim.',
        ],
        'admin' => [
            'title'       => 'Yönetici',
            'description' => 'Envanter, kategori, talep onayı, zimmet ve raporlara erişim.',
        ],
        'staff' => [
            'title'       => 'Personel',
            'description' => 'Talep oluşturma ve kendi taleplerini görme.',
        ],
    ];

    /**
     * İzinler — haftalar ilerledikçe kullanılacak.
     */
    public array $permissions = [
        'admin.access'       => 'Admin paneline erişim',
        'categories.manage'  => 'Kategori CRUD işlemleri',
        'inventory.manage'   => 'Envanter CRUD ve görsel yönetimi',
        'requests.manage'    => 'Talepleri onaylama / reddetme',
        'assignments.manage' => 'Zimmet oluşturma ve iade',
        'reports.view'       => 'Dashboard ve raporları görüntüleme',
        'requests.create'    => 'Yeni talep oluşturma',
        'requests.own'       => 'Kendi taleplerini görme',
    ];

    /**
     * Grup — izin matrisi.
     */
    public array $matrix = [
        'superadmin' => ['*'],
        'admin' => [
            'admin.access',
            'categories.manage',
            'inventory.manage',
            'requests.manage',
            'assignments.manage',
            'reports.view',
        ],
        'staff' => [
            'requests.create',
            'requests.own',
        ],
    ];

    /**
     * Yeni kayıtlarda varsayılan grup.
     */
    public string $defaultGroup = 'staff';
}
