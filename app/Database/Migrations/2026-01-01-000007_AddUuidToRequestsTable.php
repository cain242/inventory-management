<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Requests tablosuna UUID kolonu ekler.
 * URL'lerde numerik ID yerine UUID kullanılır.
 */
class AddUuidToRequestsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('requests', [
            'uuid' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => true,
                'after'      => 'id',
            ],
        ]);

        // Mevcut kayıtlara UUID ata
        $db = \Config\Database::connect();
        $rows = $db->table('requests')->get()->getResultArray();
        foreach ($rows as $row) {
            $db->table('requests')
               ->where('id', $row['id'])
               ->update(['uuid' => $this->generateUuid()]);
        }

        // NOT NULL kısıtlaması ekle
        $this->forge->modifyColumn('requests', [
            'uuid' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('requests', 'uuid');
    }

    private function generateUuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}
