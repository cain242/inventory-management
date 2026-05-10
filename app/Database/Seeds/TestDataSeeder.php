<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $now = date('Y-m-d H:i:s');

        // ==============================
        // KATEGORİLER
        // ==============================
        $categories = [
            ['name' => 'Donanım',         'description' => 'Bilgisayar, monitör, klavye vb.'],
            ['name' => 'Yazılım',         'description' => 'Lisanslar ve yazılım ürünleri'],
            ['name' => 'Ağ Ekipmanları',  'description' => 'Router, switch, kablo vb.'],
            ['name' => 'Ofis Malzemesi',  'description' => 'Masa, sandalye, projeksiyon vb.'],
        ];

        foreach ($categories as $cat) {
            $exists = $db->table('categories')->where('name', $cat['name'])->countAllResults();
            if ($exists === 0) {
                $db->table('categories')->insert([
                    'name'        => $cat['name'],
                    'description' => $cat['description'],
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ]);
            }
        }

        echo "  ✓ 4 kategori oluşturuldu\n";

        // Kategori ID'lerini al
        $catIds = [];
        $allCats = $db->table('categories')->get()->getResultArray();
        foreach ($allCats as $c) {
            $catIds[$c['name']] = $c['id'];
        }

        // ==============================
        // ENVANTER ÜRÜNLERİ
        // ==============================
        $items = [
            [
                'category_id'   => $catIds['Donanım'] ?? 1,
                'name'          => 'Dell Latitude 5540 Laptop',
                'brand'         => 'Dell',
                'serial_no'     => 'DLL-2024-001',
                'purchase_date' => '2024-06-15',
                'status'        => 'boşta',
                'notes'         => 'i7 işlemci, 16GB RAM',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'category_id'   => $catIds['Donanım'] ?? 1,
                'name'          => 'HP EliteBook 840 Laptop',
                'brand'         => 'HP',
                'serial_no'     => 'HP-2024-002',
                'purchase_date' => '2024-07-20',
                'status'        => 'boşta',
                'notes'         => 'i5 işlemci, 8GB RAM',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'category_id'   => $catIds['Donanım'] ?? 1,
                'name'          => 'LG 27 inç Monitör',
                'brand'         => 'LG',
                'serial_no'     => 'LG-MON-003',
                'purchase_date' => '2024-03-10',
                'status'        => 'boşta',
                'notes'         => '27 inç IPS panel',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'category_id'   => $catIds['Yazılım'] ?? 2,
                'name'          => 'Microsoft Office 365 Lisansı',
                'brand'         => 'Microsoft',
                'serial_no'     => 'MS-OFF-004',
                'purchase_date' => '2024-01-01',
                'status'        => 'boşta',
                'notes'         => '1 yıllık kurumsal lisans',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'category_id'   => $catIds['Ağ Ekipmanları'] ?? 3,
                'name'          => 'TP-Link Router',
                'brand'         => 'TP-Link',
                'serial_no'     => 'TPL-RTR-005',
                'purchase_date' => '2024-05-01',
                'status'        => 'boşta',
                'notes'         => 'Wi-Fi 6 destekli',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'category_id'   => $catIds['Ofis Malzemesi'] ?? 4,
                'name'          => 'Ergonomik Ofis Sandalyesi',
                'brand'         => 'Herman Miller',
                'serial_no'     => 'HM-CHR-006',
                'purchase_date' => '2024-08-01',
                'status'        => 'boşta',
                'notes'         => 'Bel destekli, ayarlanabilir',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ];

        foreach ($items as $item) {
            $exists = $db->table('inventory')->where('serial_no', $item['serial_no'])->countAllResults();
            if ($exists === 0) {
                $db->table('inventory')->insert($item);
            }
        }

        echo "  ✓ 6 envanter ürünü oluşturuldu\n";

        // ==============================
        // TEST TALEPLERİ (sunum için hazır bekleyen talepler)
        // ==============================
        // personel1 kullanıcısının ID'sini bul
        $personel = $db->table('users')->where('username', 'personel1')->get()->getRowArray();
        $personel2 = $db->table('users')->where('username', 'personel2')->get()->getRowArray();

        if ($personel) {
            $existingRequests = $db->table('requests')->countAllResults();
            if ($existingRequests === 0) {
                // İlk envanter ID'lerini al
                $inv1 = $db->table('inventory')->where('serial_no', 'DLL-2024-001')->get()->getRowArray();
                $inv2 = $db->table('inventory')->where('serial_no', 'HP-2024-002')->get()->getRowArray();
                $inv3 = $db->table('inventory')->where('serial_no', 'LG-MON-003')->get()->getRowArray();

                if ($inv1) {
                    $db->table('requests')->insert([
                        'user_id'      => $personel['id'],
                        'inventory_id' => $inv1['id'],
                        'type'         => 'new',
                        'description'  => 'Mevcut bilgisayarım çok yavaş, yeni laptop talep ediyorum.',
                        'status'       => 'pending',
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ]);
                }

                if ($inv2 && $personel2) {
                    $db->table('requests')->insert([
                        'user_id'      => $personel2['id'],
                        'inventory_id' => $inv2['id'],
                        'type'         => 'new',
                        'description'  => 'Yeni başlayan personel için laptop gerekiyor.',
                        'status'       => 'pending',
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ]);
                }

                if ($inv3) {
                    $db->table('requests')->insert([
                        'user_id'      => $personel['id'],
                        'inventory_id' => $inv3['id'],
                        'type'         => 'repair',
                        'description'  => 'Monitörde görüntü titremesi var, arıza bildiriyorum.',
                        'status'       => 'pending',
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ]);
                }

                echo "  ✓ 3 test talebi oluşturuldu (bekliyor durumunda)\n";
            } else {
                echo "  ⓘ Talepler zaten var, atlandı.\n";
            }
        }

        echo "\n  🎉 Test verileri hazır! Sunuma başlayabilirsin.\n";
    }
}
