<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User as ShieldUser;

/**
 * User Entity
 *
 * Shield'in User entity'sini genişletir.
 * Hafta 2-5'te özel property'ler veya method'lar eklenebilir.
 *
 * Shield sayesinde şu property'ler otomatik çalışır:
 *   $user->id         → users tablosundan
 *   $user->username   → users tablosundan
 *   $user->email      → auth_identities tablosundan (magic getter)
 *   $user->password   → auth_identities tablosundan (magic setter, hash'ler)
 *
 * Grup işlemleri:
 *   $user->addGroup('admin')      → Gruba ekle
 *   $user->removeGroup('admin')   → Gruptan çıkar
 *   $user->getGroups()            → Grupları getir
 *   $user->inGroup('admin')       → Grupta mı kontrol et
 */
class User extends ShieldUser
{
    // Hafta 2-5'te gerekirse özel alanlar/metodlar buraya eklenebilir
}
