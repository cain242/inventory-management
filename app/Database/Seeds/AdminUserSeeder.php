<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Entities\User;


class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $users = model('UserModel');

        // -----------------------------
        // Admin hesabı
        // -----------------------------
        $adminEmail = 'admin@envanter.local';
        $existing   = $users->findByCredentials(['email' => $adminEmail]);

        if ($existing === null) {
            $admin = new User([
                'username' => 'admin',
                'email'    => $adminEmail,
                'password' => 'Admin123!',
            ]);
            $users->save($admin);

            // Kaydedilen kullanıcıyı al ve admin grubuna ekle
            $admin = $users->findById($users->getInsertID());
            $admin->addGroup('admin');

            echo "\n  ✓ Admin oluşturuldu: admin@envanter.local / Admin123!\n";
        } else {
            echo "\n  - Admin zaten mevcut, atlandı.\n";
        }

        // -----------------------------
        // Personel hesabı (test için)
        // -----------------------------
        $staffEmail = 'personel1@envanter.local';
        $existing   = $users->findByCredentials(['email' => $staffEmail]);

        if ($existing === null) {
            $staff = new User([
                'username' => 'personel1',
                'email'    => $staffEmail,
                'password' => 'Staff123!',
            ]);
            $users->save($staff);

            // Kaydedilen kullanıcıyı al ve staff grubuna ekle
            $staff = $users->findById($users->getInsertID());
            $staff->addGroup('staff');

            echo "  ✓ Personel oluşturuldu: personel1@envanter.local / Staff123!\n";
        } else {
            echo "  - Personel 1 zaten mevcut, atlandı.\n";
        }

        // -----------------------------
        // Personel 2 hesabı (test için)
        // -----------------------------
        $staff2Email = 'personel2@envanter.local';
        $existing    = $users->findByCredentials(['email' => $staff2Email]);

        if ($existing === null) {
            $staff2 = new User([
                'username' => 'personel2',
                'email'    => $staff2Email,
                'password' => 'Staff123!',
            ]);
            $users->save($staff2);

            // Kaydedilen kullanıcıyı al ve staff grubuna ekle
            $staff2 = $users->findById($users->getInsertID());
            $staff2->addGroup('staff');

            echo "  ✓ Personel 2 oluşturuldu: personel2@envanter.local / Staff123!\n";
        } else {
            echo "  - Personel 2 zaten mevcut, atlandı.\n";
        }
    }
}
