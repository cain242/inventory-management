<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // HAFTA 1: Admin + test personel hesapları
        $this->call('AdminUserSeeder');

        // =====================================================
        // HAFTA 2 — Öğrenci 2:
        // $this->call('CategorySeeder');
        // =====================================================
    }
}
