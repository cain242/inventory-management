<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * =====================================================================
 * HAFTA 2 — Öğrenci 2
 * =====================================================================
 * Envanter görselleri tablosu burada oluşturulacak.
 *
 * Kolonlar: id, inventory_id (FK), file_path, created_at
 * =====================================================================
 */
class CreateInventoryImagesTable extends Migration
{
    public function up()
    {
        // TODO: Hafta 2'de doldurulacak
    }

    public function down()
    {
        $this->forge->dropTable('inventory_images', true);
    }
}
