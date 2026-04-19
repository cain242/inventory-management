<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * =====================================================================
 * HAFTA 2 — Öğrenci 2
 * =====================================================================
 * Envanter tablosu burada oluşturulacak.
 *
 * Kolonlar: id, category_id (FK), name, serial_no, brand,
 *           purchase_date, status (enum), notes, created_at, updated_at
 * =====================================================================
 */
class CreateInventoryTable extends Migration
{
    public function up()
    {
        // TODO: Hafta 2'de doldurulacak
    }

    public function down()
    {
        $this->forge->dropTable('inventory', true);
    }
}
