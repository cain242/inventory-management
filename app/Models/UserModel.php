<?php

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

/**
 * HAFTA 1 — Çekirdek
 *
 * Shield'in UserModel'ini genişletir.
 * Shield, users tablosunu ve auth_identities tablosunu yönetir.
 *
 * Kullanım:
 *   $users = model('UserModel');
 *   $user  = $users->find($id);           // User entity döner
 *   $user->email                           // auth_identities'den gelir
 *   $user->username                        // users tablosundan gelir
 *   $user->inGroup('admin')                // auth_groups_users tablosundan
 */
class UserModel extends ShieldUserModel
{
    /**
     * Entity sınıfı olarak kendi User entity'mizi kullan.
     */
    protected $returnType = \App\Entities\User::class;
}
