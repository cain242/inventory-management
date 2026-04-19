<?php

namespace Config;

use CodeIgniter\Events\Events;

/*
 * =====================================================================
 * Session Köprüsü
 * =====================================================================
 * Shield kendi session yönetimini kullanır. Ancak lazim.md'deki
 * haftalık görevlerde session()->get('user_id') ve session()->get('role')
 * kullanılıyor. Bu event'ler ikisini de uyumlu kılmak için çalışır.
 *
 * Kullanım:
 *   session()->get('user_id')   → Giriş yapan kullanıcının ID'si
 *   session()->get('role')      → 'admin' veya 'staff'
 *   session()->get('username')  → Kullanıcı adı
 *   session()->get('isLoggedIn') → true
 *
 *   auth()->user()              → Shield User entity (obje)
 *   auth()->id()                → Kullanıcı ID
 * =====================================================================
 */

Events::on('login', static function ($user) {
    $groups = $user->getGroups();
    $role   = in_array('admin', $groups) ? 'admin' : 'staff';

    session()->set([
        'user_id'    => $user->id,
        'username'   => $user->username,
        'role'       => $role,
        'isLoggedIn' => true,
    ]);
});

Events::on('logout', static function ($user) {
    session()->remove(['user_id', 'username', 'role', 'isLoggedIn']);
});
